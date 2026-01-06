<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Posyandu as PosyanduModel;
use App\Models\Anak;
use App\Models\OrangTua;
use App\Models\DataPengukuran;
use App\Models\DataStunting;
use App\Models\Notifikasi;
use Carbon\Carbon;
use App\Services\ZScoreService; 

class PosyanduController extends Controller
{
    /**
     * Helper untuk mendapatkan Posyandu User saat ini
     */
    private function getActivePosyandu()
    {
        $user = Auth::user();
        if (!$user || !$user->id_posyandu) {
            return null;
        }
        return PosyanduModel::with('puskesmas')->find($user->id_posyandu);
    }

    /**
     * UC-PSY-01: Dashboard Posyandu
     */
    public function dashboard()
    {
        $posyandu = $this->getActivePosyandu();
        
        if (!$posyandu) {
            return redirect()->route('login')->with('error', 'Akun Anda belum ditugaskan di Posyandu manapun.');
        }

        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        // Menggunakan satu base query scope untuk efisiensi
        $basePengukuranQuery = DataPengukuran::whereHas('anak', function($q) use ($posyandu) {
            $q->where('id_posyandu', $posyandu->id_posyandu);
        });

        // Statistics
        $todayMeasurements = (clone $basePengukuranQuery)->whereDate('tanggal_ukur', $today)->count();
        $monthlyMeasurements = (clone $basePengukuranQuery)->where('tanggal_ukur', '>=', $thisMonth)->count();
        $totalAnak = Anak::where('id_posyandu', $posyandu->id_posyandu)->count();

        // Stunting statistics (Optimized)
        $stuntingData = DataStunting::whereHas('dataPengukuran.anak', function($q) use ($posyandu) {
            $q->where('id_posyandu', $posyandu->id_posyandu);
        })
        ->select('status_stunting', DB::raw('count(*) as total'))
        ->groupBy('status_stunting')
        ->pluck('total', 'status_stunting'); // Mengambil array [status => total]

        $totalStunting = $stuntingData->except(['Normal'])->sum();
        $persentaseStunting = $totalAnak > 0 ? round(($totalStunting / $totalAnak) * 100, 1) : 0;

        // Recent measurements
        $recentMeasurements = (clone $basePengukuranQuery)
            ->with(['anak', 'dataStunting'])
            ->orderBy('tanggal_ukur', 'desc')
            ->take(10)
            ->get();

        // Pending validations
        $pendingValidations = DataStunting::where('status_validasi', 'Pending')
            ->whereHas('dataPengukuran.anak', function($q) use ($posyandu) {
                $q->where('id_posyandu', $posyandu->id_posyandu);
            })
            ->count();

        // Monthly trend & Notifications
        $monthlyTrend = $this->getMonthlyTrend($posyandu->id_posyandu, 6);
        $notifications = Notifikasi::where('id_user', Auth::id())
            ->orderBy('tanggal_kirim', 'desc')
            ->take(5)
            ->get();

        return view('posyandu.dashboard', compact(
            'posyandu', 'todayMeasurements', 'monthlyMeasurements', 'totalAnak',
            'totalStunting', 'persentaseStunting', 'recentMeasurements',
            'pendingValidations', 'monthlyTrend', 'notifications'
        ));
    }

    /**
     * UC-PSY-02: Input Data Pengukuran - Form
     */
    public function inputPengukuranForm(Request $request)
    {
        $posyandu = $this->getActivePosyandu();
        if (!$posyandu) return redirect()->route('posyandu.dashboard');

        $query = Anak::with(['orangTua', 'pengukuranTerakhir'])
            ->where('id_posyandu', $posyandu->id_posyandu);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_anak', 'like', "%{$search}%")
                  ->orWhere('nik_anak', 'like', "%{$search}%");
            });
        }

        $anakList = $query->orderBy('nama_anak')->limit(50)->get(); // Limit untuk performa

        $selectedAnak = null;
        if ($request->filled('id_anak')) {
            $selectedAnak = Anak::with(['orangTua', 'pengukuranTerakhir'])
                ->where('id_posyandu', $posyandu->id_posyandu)
                ->find($request->id_anak);
        }

        return view('posyandu.pengukuran.form', compact('posyandu', 'anakList', 'selectedAnak'));
    }

    /**
     * UC-PSY-02: Input Data Pengukuran - Store
     */
    public function inputPengukuranStore(Request $request)
    {
        $user = Auth::user();
        $posyandu = $this->getActivePosyandu();
        if (!$posyandu) return redirect()->route('posyandu.dashboard');

        $validated = $request->validate([
            'id_anak' => 'required|exists:anak,id_anak',
            'tanggal_ukur' => 'required|date|before_or_equal:today',
            'berat_badan' => 'required|numeric|min:1|max:50',
            'tinggi_badan' => 'required|numeric|min:30|max:150',
            'lingkar_kepala' => 'required|numeric|min:20|max:70',
            'lingkar_lengan' => 'required|numeric|min:5|max:40',
            'cara_ukur' => 'required|in:Berdiri,Terlentang',
            'catatan' => 'nullable|string|max:500'
        ]);

        $anak = Anak::where('id_anak', $validated['id_anak'])
            ->where('id_posyandu', $posyandu->id_posyandu)
            ->firstOrFail();

        // Outlier Check
        if (!$request->has('confirm_outlier')) {
            $outlierCheck = $this->detectOutlier($validated, $anak);
            if ($outlierCheck['is_outlier']) {
                return back()
                    ->withInput()
                    ->with('warning', $outlierCheck['message'])
                    ->with('outlier_data', $validated);
            }
        } else {
             $validated['catatan'] = ($validated['catatan'] ?? '') . ' [KONFIRMASI PETUGAS: DATA VALID]';
        }

        DB::beginTransaction();
        try {
            $umurBulan = Carbon::parse($anak->tanggal_lahir)
                ->diffInMonths(Carbon::parse($validated['tanggal_ukur']));

            $pengukuran = DataPengukuran::create([
                'id_anak' => $validated['id_anak'],
                'id_posyandu' => $posyandu->id_posyandu,
                'id_petugas' => $user->id_user,
                'tanggal_ukur' => $validated['tanggal_ukur'],
                'umur_bulan' => $umurBulan,
                'berat_badan' => $validated['berat_badan'],
                'tinggi_badan' => $validated['tinggi_badan'],
                'lingkar_kepala' => $validated['lingkar_kepala'],
                'lingkar_lengan' => $validated['lingkar_lengan'],
                'cara_ukur' => $validated['cara_ukur'],
                'catatan' => $validated['catatan'],
                // 'status_gizi' => belum ada nilainya di sini
                'created_at' => now()
            ]);

            // 2. Hitung Z-Score
            $analisis = ZScoreService::calculate(
                $anak->jenis_kelamin,
                $umurBulan,
                $validated['berat_badan'],
                $validated['tinggi_badan']
            );

            // 3. Mapping Status (Logika yang sudah Anda buat)
            $rawStatus = $analisis['status_stunting'];
            $finalStatus = 'Normal'; 

            if (str_contains($rawStatus, 'Severely Stunted') || str_contains($rawStatus, 'Sangat Pendek')) {
                $finalStatus = 'Stunting Berat';
            } elseif (str_contains($rawStatus, 'Stunted') || str_contains($rawStatus, 'Pendek')) {
                $finalStatus = 'Stunting Sedang'; 
            } elseif (str_contains($rawStatus, 'Normal')) {
                $finalStatus = 'Normal';
            } elseif (str_contains($rawStatus, 'Tinggi') || str_contains($rawStatus, 'Tall')) {
                $finalStatus = 'Normal'; 
            }

            // === TAMBAHKAN KODE INI UNTUK MENGISI KOLOM NULL ===
            // Update record pengukuran dengan status yang sudah dihitung
            $pengukuran->update([
                'status_gizi' => $finalStatus
            ]);
            // ===================================================

            // 4. Simpan ke Data Stunting (Detail Z-Score)
            $stunting = DataStunting::create([
                'id_pengukuran' => $pengukuran->id_pengukuran,
                'zscore_tb_u' => $analisis['zscore_tb_u'],
                'zscore_bb_u' => $analisis['zscore_bb_u'],
                'zscore_bb_tb' => $analisis['zscore_bb_tb'],
                'status_stunting' => $finalStatus, 
                'status_validasi' => 'Pending',
                'created_at' => now()
            ]);

            if ($finalStatus !== 'Normal') {
                $this->sendStuntingNotification($anak, $stunting);
            }

            DB::commit();

            return redirect()
                ->route('posyandu.pengukuran.form', ['id_anak' => $anak->id_anak])
                ->with('success', 'Data berhasil disimpan! Status Gizi: ' . $finalStatus);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Pengukuran store error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage()); 
        }
    }

    /**
     * UC-PSY-04: Riwayat Pengukuran
     */
    public function riwayatPengukuran(Request $request)
    {
        $posyandu = $this->getActivePosyandu();
        if (!$posyandu) return redirect()->route('posyandu.dashboard');
        
        $query = DataPengukuran::with(['anak.orangTua', 'dataStunting'])
            ->whereHas('anak', function($q) use ($posyandu) {
                $q->where('id_posyandu', $posyandu->id_posyandu);
            });
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('anak', function($q) use ($search) {
                $q->where('nama_anak', 'like', "%{$search}%")
                ->orWhere('nik_anak', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('tanggal_dari')) $query->where('tanggal_ukur', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai')) $query->where('tanggal_ukur', '<=', $request->tanggal_sampai);
        
        if ($request->filled('status')) {
            $query->whereHas('dataStunting', function($q) use ($request) {
                if ($request->status === 'Normal') {
                    $q->where('status_stunting', 'Normal');
                } else {
                    $q->where('status_stunting', '!=', 'Normal');
                }
            });
        }
        
        $sortBy = $request->get('sort_by', 'tanggal_ukur');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $pengukuranList = $query->paginate(25);
        
        // Stats untuk initial view
        $stats = [
            'total' => DataPengukuran::whereHas('anak', function($q) use ($posyandu) {
                $q->where('id_posyandu', $posyandu->id_posyandu);
            })->count(),
            'bulan_ini' => DataPengukuran::whereHas('anak', function($q) use ($posyandu) {
                $q->where('id_posyandu', $posyandu->id_posyandu);
            })->whereMonth('tanggal_ukur', now()->month)->count(),
            'hari_ini' => DataPengukuran::whereHas('anak', function($q) use ($posyandu) {
                $q->where('id_posyandu', $posyandu->id_posyandu);
            })->whereDate('tanggal_ukur', today())->count(),
        ];
        
        return view('posyandu.pengukuran.riwayat', compact('posyandu', 'pengukuranList', 'stats'));
    }

    /**
     * UC-PSY-01: Dashboard Statistics AJAX Endpoint
     */
    public function dashboardStats(Request $request)
    {
        $posyandu = $this->getActivePosyandu();
        if (!$posyandu) return response()->json(['error' => 'Unauthorized'], 403);

        $posyanduId = $posyandu->id_posyandu;

        // Hitung statistik secara efisien
        $totalPengukuran = DataPengukuran::whereHas('anak', fn($q) => $q->where('id_posyandu', $posyanduId))->count();
        
        $bulanIni = DataPengukuran::whereHas('anak', fn($q) => $q->where('id_posyandu', $posyanduId))
            ->whereMonth('tanggal_ukur', now()->month)
            ->whereYear('tanggal_ukur', now()->year)
            ->count();
            
        $totalStunting = DataStunting::whereHas('dataPengukuran.anak', fn($q) => $q->where('id_posyandu', $posyanduId))
            ->where('status_stunting', '!=', 'Normal')
            ->count();
            
        $persentaseStunting = $totalPengukuran > 0 ? round(($totalStunting / $totalPengukuran) * 100, 1) : 0;

        return response()->json([
            'total_pengukuran' => $totalPengukuran,
            'bulan_ini' => $bulanIni,
            'total_stunting' => $totalStunting,
            'persentase_stunting' => $persentaseStunting
        ]);
    }

    public function riwayatPengukuranDetail($id)
    {
        $posyandu = $this->getActivePosyandu();
        
        $pengukuran = DataPengukuran::with(['anak.orangTua', 'dataStunting', 'petugas'])->findOrFail($id);
        
        if ($pengukuran->anak->id_posyandu !== $posyandu->id_posyandu) abort(404);
        
        return view('posyandu.pengukuran.detail', compact('pengukuran', 'posyandu'));
    }

    // --- MANAJEMEN DATA ANAK ---

    public function dataAnakIndex(Request $request)
    {
        $posyandu = $this->getActivePosyandu();
        if (!$posyandu) return redirect()->route('posyandu.dashboard');

        $query = Anak::with(['orangTua', 'pengukuranTerakhir'])
            ->where('id_posyandu', $posyandu->id_posyandu);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_anak', 'like', "%{$search}%")
                  ->orWhere('nik_anak', 'like', "%{$search}%")
                  ->orWhereHas('orangTua', function($q2) use ($search) {
                      $q2->where('nama_ayah', 'like', "%{$search}%")
                         ->orWhere('nama_ibu', 'like', "%{$search}%");
                  });
            });
        }
        
        $anakList = $query->orderBy('nama_anak')->paginate(20);
        $totalAnak = Anak::where('id_posyandu', $posyandu->id_posyandu)->count();
        $anakNormal = 0; // Placeholder jika kolom status belum ada di tabel Anak
        $anakStunting = 0;

        return view('posyandu.anak.index', compact(
            'posyandu', 'anakList', 'totalAnak', 'anakNormal', 'anakStunting'
        ));
    }

    public function dataAnakCreate()
    {
        $posyandu = $this->getActivePosyandu();
        if (!$posyandu) return redirect()->route('posyandu.dashboard');

        $orangTuaList = OrangTua::orderBy('nama_ayah')->get();
        return view('posyandu.anak.create', compact('posyandu', 'orangTuaList'));
    }

    public function dataAnakStore(Request $request)
    {
        $posyandu = $this->getActivePosyandu();
        if (!$posyandu) return redirect()->route('posyandu.dashboard');

        $validated = $request->validate([
            'id_orangtua' => 'required|exists:orang_tua,id_orangtua',
            'nik_anak' => 'required|digits:16|unique:anak,nik_anak',
            'nama_anak' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:today|after:2015-01-01',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'anak_ke' => 'required|integer|min:1|max:20'
        ]);

        try {
            Anak::create(array_merge($validated, [
                'id_posyandu' => $posyandu->id_posyandu,
                'created_at' => now()
            ]));

            return redirect()
                ->route('posyandu.anak.index')
                ->with('success', 'Data anak berhasil didaftarkan! Silakan lakukan pengukuran pertama.');

        } catch (\Exception $e) {
            Log::error('Anak registration error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal mendaftarkan anak.');
        }
    }

    public function dataAnakShow($id)
    {
        $posyandu = $this->getActivePosyandu();
        if (!$posyandu) return redirect()->route('posyandu.dashboard');

        $anak = Anak::with(['orangTua', 'posyandu'])
            ->where('id_posyandu', $posyandu->id_posyandu)
            ->findOrFail($id);

        $riwayatPengukuran = DataPengukuran::with('dataStunting')
            ->where('id_anak', $id)
            ->orderBy('tanggal_ukur', 'desc')
            ->take(12)
            ->get();

        return view('posyandu.anak.show', compact('posyandu', 'anak', 'riwayatPengukuran'));
    }

    public function dataAnakEdit($id)
    {
        $posyandu = $this->getActivePosyandu();
        if (!$posyandu) return redirect()->route('posyandu.dashboard');

        $anak = Anak::where('id_posyandu', $posyandu->id_posyandu)->findOrFail($id);
        $orangTuaList = OrangTua::orderBy('nama_ayah')->get();

        return view('posyandu.anak.edit', compact('posyandu', 'anak', 'orangTuaList'));
    }

    public function dataAnakUpdate(Request $request, $id)
    {
        $posyandu = $this->getActivePosyandu();
        if (!$posyandu) return redirect()->route('posyandu.dashboard');

        $anak = Anak::where('id_posyandu', $posyandu->id_posyandu)->findOrFail($id);
        
        $validated = $request->validate([
            'id_orangtua' => 'required|exists:orang_tua,id_orangtua',
            'nik_anak' => 'required|digits:16|unique:anak,nik_anak,' . $id . ',id_anak',
            'nama_anak' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:today|after:2015-01-01',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'anak_ke' => 'required|integer|min:1|max:20'
        ]);

        $anak->update($validated);
        return redirect()->route('posyandu.anak.show', $id)->with('success', 'Data anak berhasil diperbarui!');
    }

    // --- LAPORAN & EXPORT ---

    public function riwayatExport(Request $request)
    {
        $posyandu = $this->getActivePosyandu();
        
        $query = DataPengukuran::with(['anak.orangTua', 'dataStunting', 'petugas'])
            ->whereHas('anak', function($q) use ($posyandu) {
                $q->where('id_posyandu', $posyandu->id_posyandu);
            });
        
        if ($request->filled('tanggal_dari')) $query->where('tanggal_ukur', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai')) $query->where('tanggal_ukur', '<=', $request->tanggal_sampai);
        
        $pengukuranList = $query->orderBy('tanggal_ukur', 'desc')->get();
        return $this->generateExcelRiwayat($pengukuranList, $posyandu);
    }

    private function generateExcelRiwayat($data, $posyandu)
    {
        if (!class_exists('\PhpOffice\PhpSpreadsheet\Spreadsheet')) {
            return back()->with('error', 'Library Excel belum terinstall.');
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'RIWAYAT PENGUKURAN ANAK');
        $sheet->setCellValue('A2', $posyandu->nama_posyandu);
        $sheet->setCellValue('A3', 'Periode: ' . now()->format('d F Y'));
        
        // Header styling simplified for brevity
        $headers = ['No', 'Tanggal', 'NIK', 'Nama', 'Umur(bln)', 'BB', 'TB', 'LK', 'Gizi', 'Petugas'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '5', $header);
            $col++;
        }
        
        $row = 6;
        foreach ($data as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, Carbon::parse($item->tanggal_ukur)->format('d/m/Y'));
            $sheet->setCellValue('C' . $row, $item->anak->nik_anak);
            $sheet->setCellValue('D' . $row, $item->anak->nama_anak);
            $sheet->setCellValue('E' . $row, $item->umur_bulan);
            $sheet->setCellValue('F' . $row, $item->berat_badan);
            $sheet->setCellValue('G' . $row, $item->tinggi_badan);
            $sheet->setCellValue('H' . $row, $item->lingkar_kepala);
            $sheet->setCellValue('I' . $row, $item->dataStunting ? $item->dataStunting->status_stunting : '-');
            $sheet->setCellValue('J' . $row, $item->petugas ? $item->petugas->nama : '-');
            $row++;
        }
        
        $filename = 'Riwayat_Pengukuran_' . now()->format('Y-m-d') . '.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    }

    // --- NOTIFIKASI ---

    public function notifikasiIndex(Request $request)
    {
        $posyandu = $this->getActivePosyandu();
        $userId = Auth::id();
        
        $query = Notifikasi::where('id_user', $userId);

        // 1. Filter Status (Belum Dibaca / Sudah Dibaca)
        if ($request->filled('status') && $request->status != '') {
            $query->where('status_baca', $request->status);
        }

        // 2. Filter Tipe (Validasi, Peringatan, Informasi)
        if ($request->filled('tipe') && $request->tipe != '') {
            $query->where('tipe_notifikasi', $request->tipe);
        }
        
        // 3. Pagination dengan withQueryString()
        // Ini otomatis menempelkan parameter filter (?status=..&tipe=..) ke link pagination
        $notifikasiList = $query->orderBy('tanggal_kirim', 'desc')
                                ->paginate(20)
                                ->withQueryString();
        
        // Stats untuk Cards (Logic tetap sama)
        $stats = [
            'total' => Notifikasi::where('id_user', $userId)->count(),
            'belum_dibaca' => Notifikasi::where('id_user', $userId)->where('status_baca', 'Belum Dibaca')->count(),
            'hari_ini' => Notifikasi::where('id_user', $userId)->whereDate('tanggal_kirim', today())->count(),
        ];
        
        return view('posyandu.notifikasi.index', compact('posyandu', 'notifikasiList', 'stats'));
    }

    public function notifikasiMarkAsRead($id) 
    {
        $notifikasi = Notifikasi::where('id_user', Auth::id())->findOrFail($id);
        $notifikasi->update(['status_baca' => 'Sudah Dibaca']);
        
        return redirect()->back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function notifikasiMarkAllAsRead()
    {
        Notifikasi::where('id_user', Auth::id())
            ->where('status_baca', 'Belum Dibaca')
            ->update(['status_baca' => 'Sudah Dibaca']);

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sudah dibaca.');
    }

    public function notifikasiDelete($id)
    {
        $notifikasi = Notifikasi::where('id_user', Auth::id())->findOrFail($id);
        $notifikasi->delete();

        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    public function notifikasiDeleteAllRead()
    {
        $deleted = Notifikasi::where('id_user', Auth::id())
            ->where('status_baca', 'Sudah Dibaca')
            ->delete();

        if ($deleted > 0) {
            return redirect()->back()->with('success', "Berhasil menghapus {$deleted} notifikasi yang sudah dibaca.");
        }

        return redirect()->back()->with('info', 'Tidak ada notifikasi "Sudah Dibaca" yang dapat dihapus.');
    }

    // --- PROFILE & SETTINGS ---

    public function profile() {
        $user = Auth::user();
        $posyandu = $this->getActivePosyandu();

        // Ambil data pengukuran terakhir (Model DataPengukuran)
        $lastInputData = DataPengukuran::where('id_petugas', $user->id_user)
            ->latest('created_at')
            ->first();

        $stats = [
            'total_input' => DataPengukuran::where('id_petugas', $user->id_user)->count(),
            'bulan_ini' => DataPengukuran::where('id_petugas', $user->id_user)
                ->whereMonth('created_at', now()->month)
                ->count(),
            // PERBAIKAN: Kirim object Model utuh (atau null), JANGAN kirim ->created_at di sini
            'terakhir_input' => $lastInputData, 
        ];

        return view('posyandu.profile.index', compact('user', 'posyandu', 'stats'));
    }

    public function profileUpdate(Request $request) {
        $user = User::findOrFail(Auth::id());
        
        $request->validate([
            'nama' => 'required|string|max:100',
            // PERBAIKAN: Ubah 'User' menjadi 'users' (nama tabel di database)
            'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'no_telepon' => 'nullable|string|max:15', // Tambahkan validasi no_telepon jika ada di form
            'password' => 'nullable|min:8|confirmed' // Tambahkan validasi password jika form menyertakan ubah password
        ]);

        // Siapkan data update
        $dataToUpdate = $request->only(['nama', 'email', 'no_telepon']);

        // Cek jika user ingin mengubah password
        if ($request->filled('password')) {
            $dataToUpdate['password'] = bcrypt($request->password);
        }

        $user->update($dataToUpdate);

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function settings() {
        return view('posyandu.settings.index', ['user' => Auth::user(), 'posyandu' => $this->getActivePosyandu()]);
    }

    // --- PRIVATE HELPERS ---

    private function detectOutlier($data, $anak)
    {
        $errors = [];
        if ($data['berat_badan'] < 2 || $data['berat_badan'] > 40) $errors[] = "Berat {$data['berat_badan']} kg tidak wajar.";
        if ($data['tinggi_badan'] < 40 || $data['tinggi_badan'] > 140) $errors[] = "Tinggi {$data['tinggi_badan']} cm tidak wajar.";

        if (!empty($errors)) {
            return [
                'is_outlier' => true,
                'message' => 'DATA TIDAK WAJAR! ' . implode(' ', $errors) . ' Mohon periksa kembali.'
            ];
        }
        return ['is_outlier' => false];
    }

    private function sendStuntingNotification($anak, $stunting)
    {
        if ($anak->orangTua && $anak->orangTua->user) {
            Notifikasi::create([
                'id_user' => $anak->orangTua->id_user,
                'judul' => 'Perhatian: Status Gizi Anak',
                'pesan' => "Anak {$anak->nama_anak} status gizi: {$stunting->status_stunting}.",
                'tipe_notifikasi' => 'Peringatan',
                'status_baca' => 'Belum Dibaca',
                'tanggal_kirim' => now()
            ]);
        }
    }

    private function getMonthlyTrend($idPosyandu, $months = 6)
    {
        $trends = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = DataPengukuran::whereHas('anak', fn($q) => $q->where('id_posyandu', $idPosyandu))
                ->whereMonth('tanggal_ukur', $date->month)
                ->whereYear('tanggal_ukur', $date->year)
                ->count();
            $trends[] = ['label' => $date->format('M Y'), 'value' => $count];
        }
        return $trends;
    }
    
    /**
     * UC-PSY-05: Laporan Index
     */
    public function laporanIndex()
    {
        $posyandu = $this->getActivePosyandu();
        if (!$posyandu) return redirect()->route('posyandu.dashboard');

        // 1. Ambil Data Bulan/Tahun yang tersedia untuk Dropdown & Quick Reports
        // Mengelompokkan berdasarkan tanggal_ukur yang ada di database
        $availableMonths = DataPengukuran::where('id_posyandu', $posyandu->id_posyandu)
            ->select(
                DB::raw('YEAR(tanggal_ukur) as year'), 
                DB::raw('MONTH(tanggal_ukur) as month')
            )
            ->distinct()
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // 2. Siapkan Statistik Bulan Ini (Default view saat halaman dibuka)
        $bulanIni = now()->month;
        $tahunIni = now()->year;

        // Query dasar pengukuran bulan ini
        $pengukuranBulanIni = DataPengukuran::where('id_posyandu', $posyandu->id_posyandu)
            ->whereMonth('tanggal_ukur', $bulanIni)
            ->whereYear('tanggal_ukur', $tahunIni);

        $totalPengukuran = (clone $pengukuranBulanIni)->count();
        $totalAnak = Anak::where('id_posyandu', $posyandu->id_posyandu)->count();

        // Hitung detail stunting bulan ini
        // Kita ambil data stunting yang berelasi dengan pengukuran bulan ini
        $stuntingData = DataStunting::whereHas('dataPengukuran', function($q) use ($posyandu, $bulanIni, $tahunIni) {
            $q->where('id_posyandu', $posyandu->id_posyandu)
              ->whereMonth('tanggal_ukur', $bulanIni)
              ->whereYear('tanggal_ukur', $tahunIni);
        })->get();

        // Inisialisasi counter
        $countNormal = 0;
        $countRingan = 0;
        $countSedang = 0;
        $countBerat  = 0;

        foreach ($stuntingData as $data) {
            $status = strtolower($data->status_stunting);
            
            // Logika mapping status string ke kategori (sesuaikan dengan output ZScoreService Anda)
            if ($status === 'normal') {
                $countNormal++;
            } elseif (str_contains($status, 'berat') || str_contains($status, 'sangat pendek')) {
                $countBerat++;
            } elseif (str_contains($status, 'sedang') || str_contains($status, 'pendek')) { 
                $countSedang++;
            } elseif (str_contains($status, 'ringan')) {
                $countRingan++;
            } else {
                // Fallback jika ada status lain (misal: "Risiko Stunting" masuk ke Ringan/Sedang)
                if ($status !== 'normal') $countRingan++;
            }
        }

        $totalStunting = $countRingan + $countSedang + $countBerat;

        // Susun array stats sesuai kebutuhan view 'partials/current-stats.blade.php'
        $stats = [
            'bulan' => $bulanIni,
            'tahun' => $tahunIni,
            'total_anak' => $totalAnak,
            'total_pengukuran' => $totalPengukuran,
            'normal' => $countNormal,
            'persentase_normal' => $totalPengukuran > 0 ? round(($countNormal / $totalPengukuran) * 100, 1) : 0,
            'total_stunting' => $totalStunting,
            'persentase_stunting' => $totalPengukuran > 0 ? round(($totalStunting / $totalPengukuran) * 100, 1) : 0,
            'stunting_ringan' => $countRingan,
            'stunting_sedang' => $countSedang,
            'stunting_berat' => $countBerat,
        ];

        return view('posyandu.laporan.index', compact('posyandu', 'availableMonths', 'stats'));
    }

    /**
     * UC-PSY-06: Generate Laporan (View, PDF, Excel)
     */
    public function laporanGenerate(Request $request)
    {
        $posyandu = $this->getActivePosyandu();
        if (!$posyandu) return redirect()->route('posyandu.dashboard');

        // 1. Validasi Input
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:'.(date('Y')+1),
            'format' => 'required|in:view,pdf,excel',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $format = $request->format;

        // 2. Ambil Data Detail Pengukuran pada Bulan & Tahun Tersebut
        $detailData = DataPengukuran::with(['anak', 'dataStunting'])
            ->where('id_posyandu', $posyandu->id_posyandu)
            ->whereMonth('tanggal_ukur', $bulan)
            ->whereYear('tanggal_ukur', $tahun)
            ->orderBy('tanggal_ukur', 'asc')
            ->get();

        // 3. Hitung Statistik Ringkasan (Sama seperti di Index, tapi untuk bulan terpilih)
        $totalAnak = Anak::where('id_posyandu', $posyandu->id_posyandu)->count();
        $totalPengukuran = $detailData->count();
        
        $countNormal = 0;
        $countStunting = 0; // Total Stunting (Ringan + Sedang + Berat)
        
        // Counter spesifik untuk grafik
        $stuntingRingan = 0;
        $stuntingSedang = 0;
        $stuntingBerat = 0;

        foreach ($detailData as $data) {
            $status = $data->dataStunting ? strtolower($data->dataStunting->status_stunting) : '-';
            
            if ($status === 'normal') {
                $countNormal++;
            } elseif ($status !== '-') {
                // Asumsi selain normal dan kosong adalah masalah gizi/stunting
                $countStunting++;
                
                if (str_contains($status, 'berat') || str_contains($status, 'sangat pendek')) {
                    $stuntingBerat++;
                } elseif (str_contains($status, 'sedang') || str_contains($status, 'pendek')) { 
                    $stuntingSedang++;
                } else {
                    $stuntingRingan++;
                }
            }
        }

        $stats = [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'total_anak' => $totalAnak,
            'total_pengukuran' => $totalPengukuran,
            'normal' => $countNormal,
            'total_stunting' => $countStunting,
            'persentase_normal' => $totalPengukuran > 0 ? round(($countNormal / $totalPengukuran) * 100, 1) : 0,
            'persentase_stunting' => $totalPengukuran > 0 ? round(($countStunting / $totalPengukuran) * 100, 1) : 0,
            // Detail breakdown
            'stunting_ringan' => $stuntingRingan,
            'stunting_sedang' => $stuntingSedang,
            'stunting_berat' => $stuntingBerat,
        ];

        // 4. Return Berdasarkan Format
        if ($format === 'view') {
            return view('posyandu.laporan.preview', compact('posyandu', 'stats', 'detailData'));
        }

        if ($format === 'pdf') {
            // Cek apakah library DomPDF terinstall
            if (!class_exists('\Barryvdh\DomPDF\Facade\Pdf')) {
                return back()->with('error', 'Library PDF (barryvdh/laravel-dompdf) belum terinstall. Silakan hubungi admin.');
            }

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('posyandu.laporan.pdf-template', compact('posyandu', 'stats', 'detailData'));
            $pdf->setPaper('a4', 'portrait');
            $filename = 'Laporan_Posyandu_'. $bulan . '_' . $tahun . '.pdf';
            return $pdf->download($filename);
        }

        if ($format === 'excel') {
            return $this->generateExcelLaporan($detailData, $posyandu, $stats);
        }
    }

    /**
     * Helper untuk Generate Excel Laporan Bulanan
     */
    private function generateExcelLaporan($data, $posyandu, $stats)
    {
        if (!class_exists('\PhpOffice\PhpSpreadsheet\Spreadsheet')) {
            return back()->with('error', 'Library Excel belum terinstall.');
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Header Judul
        $sheet->setCellValue('A1', 'LAPORAN BULANAN POSYANDU');
        $sheet->setCellValue('A2', strtoupper($posyandu->nama_posyandu));
        $sheet->setCellValue('A3', 'Periode: ' . \Carbon\Carbon::createFromDate($stats['tahun'], $stats['bulan'], 1)->format('F Y'));
        
        // Ringkasan
        $sheet->setCellValue('A5', 'Ringkasan Statistik');
        $sheet->setCellValue('A6', 'Total Pengukuran: ' . $stats['total_pengukuran']);
        $sheet->setCellValue('A7', 'Total Stunting: ' . $stats['total_stunting'] . ' (' . $stats['persentase_stunting'] . '%)');

        // Table Header
        $headers = ['No', 'Tanggal', 'NIK', 'Nama Anak', 'Umur (Bln)', 'BB (kg)', 'TB (cm)', 'LK (cm)', 'Status Gizi'];
        $col = 'A';
        $rowHeader = 9;
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $rowHeader, $header);
            $sheet->getStyle($col . $rowHeader)->getFont()->setBold(true);
            $col++;
        }
        
        // Data Isi
        $row = 10;
        foreach ($data as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, \Carbon\Carbon::parse($item->tanggal_ukur)->format('d/m/Y'));
            $sheet->setCellValue('C' . $row, optional($item->anak)->nik_anak ?? '-');
            $sheet->setCellValue('D' . $row, optional($item->anak)->nama_anak ?? 'Data Anak Terhapus');
            $sheet->setCellValue('E' . $row, $item->umur_bulan);
            $sheet->setCellValue('F' . $row, $item->berat_badan);
            $sheet->setCellValue('G' . $row, $item->tinggi_badan);
            $sheet->setCellValue('H' . $row, $item->lingkar_kepala);
            $sheet->setCellValue('I' . $row, $item->dataStunting ? $item->dataStunting->status_stunting : '-');
            $row++;
        }
        
        // Auto size columns (A sampai I)
        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $filename = 'Laporan_Posyandu_' . $stats['tahun'] . '-' . $stats['bulan'] . '.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
}