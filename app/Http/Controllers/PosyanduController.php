<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Posyandu as PosyanduModel;
use App\Models\Anak;
use App\Models\OrangTua;
use App\Models\DataPengukuran;
use App\Models\DataStunting;
use App\Models\Notifikasi;
use Carbon\Carbon;

class PosyanduController extends Controller
{
    /**
     * UC-PSY-01: Dashboard Posyandu
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Mengambil data Posyandu berdasarkan User yang login
        $posyandu = $this->getUserPosyandu($user->id_user);
        
        // Safety Check: Redirect jika user tidak punya akses posyandu
        if (!$posyandu) {
            return redirect()->route('login')->with('error', 'Akun Anda belum ditugaskan di Posyandu manapun.');
        }

        // Today's statistics
        $today = Carbon::today();
        $todayMeasurements = DataPengukuran::whereHas('anak', function($q) use ($posyandu) {
            $q->where('id_posyandu', $posyandu->id_posyandu);
        })
        ->whereDate('tanggal_ukur', $today)
        ->count();

        // This month statistics
        $thisMonth = Carbon::now()->startOfMonth();
        $monthlyMeasurements = DataPengukuran::whereHas('anak', function($q) use ($posyandu) {
            $q->where('id_posyandu', $posyandu->id_posyandu);
        })
        ->where('tanggal_ukur', '>=', $thisMonth)
        ->count();

        // Total children registered
        $totalAnak = Anak::where('id_posyandu', $posyandu->id_posyandu)->count();

        // Stunting statistics
        $stuntingData = DataStunting::whereHas('pengukuran.anak', function($q) use ($posyandu) {
            $q->where('id_posyandu', $posyandu->id_posyandu);
        })
        ->select('status_stunting', DB::raw('count(*) as total'))
        ->groupBy('status_stunting')
        ->get();

        $totalStunting = $stuntingData->whereNotIn('status_stunting', ['Normal'])->sum('total');
        $persentaseStunting = $totalAnak > 0 ? round(($totalStunting / $totalAnak) * 100, 1) : 0;

        // Recent measurements (last 10)
        $recentMeasurements = DataPengukuran::with(['anak', 'stunting'])
            ->whereHas('anak', function($q) use ($posyandu) {
                $q->where('id_posyandu', $posyandu->id_posyandu);
            })
            ->orderBy('tanggal_ukur', 'desc')
            ->take(10)
            ->get();

        // Pending validations from Puskesmas
        $pendingValidations = DataStunting::where('status_validasi', 'Pending')
            ->whereHas('pengukuran.anak', function($q) use ($posyandu) {
                $q->where('id_posyandu', $posyandu->id_posyandu);
            })
            ->count();

        // Monthly trend (last 6 months)
        $monthlyTrend = $this->getMonthlyTrend($posyandu->id_posyandu, 6);

        // Notifications
        $notifications = Notifikasi::where('id_user', $user->id_user)
            ->orderBy('tanggal_kirim', 'desc')
            ->take(5)
            ->get();

        return view('posyandu.dashboard', compact(
            'posyandu',
            'todayMeasurements',
            'monthlyMeasurements',
            'totalAnak',
            'totalStunting',
            'persentaseStunting',
            'recentMeasurements',
            'pendingValidations',
            'monthlyTrend',
            'notifications'
        ));
    }

    /**
     * UC-PSY-02: Input Data Pengukuran - Form
     */
    public function inputPengukuranForm(Request $request)
    {
        $user = Auth::user();
        $posyandu = $this->getUserPosyandu($user->id_user);

        if (!$posyandu) return redirect()->route('posyandu.dashboard');

        // Get children list for this posyandu with search
        $query = Anak::with(['orangTua', 'pengukuranTerakhir'])
            ->where('id_posyandu', $posyandu->id_posyandu);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_anak', 'like', "%{$search}%")
                  ->orWhere('nik_anak', 'like', "%{$search}%");
            });
        }

        $anakList = $query->orderBy('nama_anak')->get();

        // Selected child if id_anak provided
        $selectedAnak = null;
        if ($request->filled('id_anak')) {
            $selectedAnak = Anak::with(['orangTua', 'pengukuranTerakhir', 'stuntingTerakhir'])
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
        $posyandu = $this->getUserPosyandu($user->id_user);

        if (!$posyandu) return redirect()->route('posyandu.dashboard');

        // Validation
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

        // Check authorization: anak belongs to this posyandu
        $anak = Anak::where('id_anak', $validated['id_anak'])
            ->where('id_posyandu', $posyandu->id_posyandu)
            ->firstOrFail();

        // Outlier detection
        $outlierCheck = $this->detectOutlier($validated, $anak);
        if ($outlierCheck['is_outlier']) {
            return back()
                ->withInput()
                ->with('warning', $outlierCheck['message'])
                ->with('outlier_data', $validated);
        }

        // Confirm outlier if user proceeds
        if ($request->has('confirm_outlier')) {
            $validated['catatan'] = ($validated['catatan'] ?? '') . ' [OUTLIER CONFIRMED BY PETUGAS]';
        }

        DB::beginTransaction();
        try {
            // Calculate umur_bulan
            $umurBulan = Carbon::parse($anak->tanggal_lahir)
                ->diffInMonths(Carbon::parse($validated['tanggal_ukur']));

            // Save data pengukuran
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
                'created_at' => now()
            ]);

            // Call Python microservice for Z-Score calculation
            $zScoreResult = $this->calculateZScore([
                'jenis_kelamin' => $anak->jenis_kelamin,
                'umur_bulan' => $umurBulan,
                'berat_badan' => $validated['berat_badan'],
                'tinggi_badan' => $validated['tinggi_badan'],
                'cara_ukur' => $validated['cara_ukur']
            ]);

            // Save stunting data
            $stunting = DataStunting::create([
                'id_pengukuran' => $pengukuran->id_pengukuran,
                'zscore_tb_u' => $zScoreResult['zscore_tb_u'],
                'zscore_bb_u' => $zScoreResult['zscore_bb_u'],
                'zscore_bb_tb' => $zScoreResult['zscore_bb_tb'],
                'status_stunting' => $zScoreResult['status_stunting'],
                'status_validasi' => 'Pending',
                'id_validator' => null,
                'tanggal_validasi' => null,
                'catatan_validasi' => null,
                'created_at' => now()
            ]);

            // Send notification to orang tua if stunting detected
            if ($zScoreResult['status_stunting'] !== 'Normal') {
                $this->sendStuntingNotification($anak, $stunting);
            }

            DB::commit();

            return redirect()
                ->route('posyandu.pengukuran.form', ['id_anak' => $anak->id_anak])
                ->with('success', 'Data pengukuran berhasil disimpan! Status: ' . $zScoreResult['status_stunting']);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Pengukuran store error: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data. Silakan coba lagi.');
        }
    }

    /**
     * UC-PSY-03: Manajemen Data Anak - Index
     */
    public function dataAnakIndex(Request $request)
    {
        $user = Auth::user();
        $posyandu = $this->getUserPosyandu($user->id_user);

        if (!$posyandu) return redirect()->route('posyandu.dashboard');

        $query = Anak::with(['orangTua', 'pengukuranTerakhir', 'stuntingTerakhir'])
            ->where('id_posyandu', $posyandu->id_posyandu);

        // Search
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

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'Normal') {
                $query->whereHas('stuntingTerakhir', function($q) {
                    $q->where('status_stunting', 'Normal');
                });
            } elseif ($request->status === 'Stunting') {
                $query->whereHas('stuntingTerakhir', function($q) {
                    $q->where('status_stunting', '!=', 'Normal');
                });
            }
        }

        $anakList = $query->orderBy('nama_anak')->paginate(20);

        // Statistics
        $totalAnak = Anak::where('id_posyandu', $posyandu->id_posyandu)->count();
        $anakNormal = Anak::where('id_posyandu', $posyandu->id_posyandu)
            ->whereHas('stuntingTerakhir', function($q) {
                $q->where('status_stunting', 'Normal');
            })->count();
        $anakStunting = Anak::where('id_posyandu', $posyandu->id_posyandu)
            ->whereHas('stuntingTerakhir', function($q) {
                $q->where('status_stunting', '!=', 'Normal');
            })->count();

        return view('posyandu.anak.index', compact(
            'posyandu',
            'anakList',
            'totalAnak',
            'anakNormal',
            'anakStunting'
        ));
    }

    /**
     * UC-PSY-03: Registrasi Anak Baru - Form
     */
    public function dataAnakCreate()
    {
        $user = Auth::user();
        $posyandu = $this->getUserPosyandu($user->id_user);

        if (!$posyandu) return redirect()->route('posyandu.dashboard');

        // Get orang tua list
        $orangTuaList = OrangTua::orderBy('nama_ayah')->get();

        return view('posyandu.anak.create', compact('posyandu', 'orangTuaList'));
    }

    /**
     * UC-PSY-03: Registrasi Anak Baru - Store
     */
    public function dataAnakStore(Request $request)
    {
        $user = Auth::user();
        $posyandu = $this->getUserPosyandu($user->id_user);

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

        DB::beginTransaction();
        try {
            $anak = Anak::create([
                'id_orangtua' => $validated['id_orangtua'],
                'id_posyandu' => $posyandu->id_posyandu,
                'nik_anak' => $validated['nik_anak'],
                'nama_anak' => $validated['nama_anak'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'anak_ke' => $validated['anak_ke'],
                'created_at' => now()
            ]);

            DB::commit();

            return redirect()
                ->route('posyandu.anak.index')
                ->with('success', 'Data anak berhasil didaftarkan! Silakan lakukan pengukuran pertama.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Anak registration error: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Gagal mendaftarkan anak. Silakan coba lagi.');
        }
    }

    /**
     * UC-PSY-03: Detail Anak
     */
    public function dataAnakShow($id)
    {
        $user = Auth::user();
        $posyandu = $this->getUserPosyandu($user->id_user);

        if (!$posyandu) return redirect()->route('posyandu.dashboard');

        $anak = Anak::with(['orangTua', 'posyandu'])
            ->where('id_posyandu', $posyandu->id_posyandu)
            ->findOrFail($id);

        // Get measurement history (last 12)
        $riwayatPengukuran = DataPengukuran::with('stunting')
            ->where('id_anak', $id)
            ->orderBy('tanggal_ukur', 'desc')
            ->take(12)
            ->get()
            ->reverse();

        return view('posyandu.anak.show', compact('posyandu', 'anak', 'riwayatPengukuran'));
    }

    /**
     * UC-PSY-03: Edit Anak
     */
    public function dataAnakEdit($id)
    {
        $user = Auth::user();
        $posyandu = $this->getUserPosyandu($user->id_user);

        if (!$posyandu) return redirect()->route('posyandu.dashboard');

        $anak = Anak::where('id_posyandu', $posyandu->id_posyandu)->findOrFail($id);
        $orangTuaList = OrangTua::orderBy('nama_ayah')->get();

        return view('posyandu.anak.edit', compact('posyandu', 'anak', 'orangTuaList'));
    }

    /**
     * UC-PSY-03: Update Anak
     */
    public function dataAnakUpdate(Request $request, $id)
    {
        $user = Auth::user();
        $posyandu = $this->getUserPosyandu($user->id_user);

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

        return redirect()
            ->route('posyandu.anak.show', $id)
            ->with('success', 'Data anak berhasil diperbarui!');
    }

    /**
     * UC-PSY-04: Riwayat Pengukuran
     */
    public function riwayatPengukuran(Request $request)
    {
        $userId = Auth::id();
        $posyandu = $this->getUserPosyandu($userId);
        
        if (!$posyandu) {
            return redirect()->route('posyandu.dashboard')->with('error', 'Posyandu tidak ditemukan');
        }
        
        // Build query
        $query = DataPengukuran::with(['anak.orangTua', 'stunting'])
            ->whereHas('anak', function($q) use ($posyandu) {
                $q->where('id_posyandu', $posyandu->id_posyandu);
            });
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('anak', function($q) use ($search) {
                $q->where('nama_anak', 'like', "%{$search}%")
                ->orWhere('nik_anak', 'like', "%{$search}%");
            });
        }
        
        // Date range filter
        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal_ukur', '>=', $request->tanggal_dari);
        }
        
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal_ukur', '<=', $request->tanggal_sampai);
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->whereHas('stunting', function($q) use ($request) {
                if ($request->status === 'Normal') {
                    $q->where('status_stunting', 'Normal');
                } else {
                    $q->where('status_stunting', '!=', 'Normal');
                }
            });
        }
        
        // Sort
        $sortBy = $request->get('sort_by', 'tanggal_ukur');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        // Paginate
        $pengukuranList = $query->paginate(25);
        
        // Statistics
        $stats = [
            'total' => DataPengukuran::whereHas('anak', function($q) use ($posyandu) {
                $q->where('id_posyandu', $posyandu->id_posyandu);
            })->count(),
            
            'bulan_ini' => DataPengukuran::whereHas('anak', function($q) use ($posyandu) {
                $q->where('id_posyandu', $posyandu->id_posyandu);
            })->whereMonth('tanggal_ukur', now()->month)
            ->whereYear('tanggal_ukur', now()->year)
            ->count(),
            
            'hari_ini' => DataPengukuran::whereHas('anak', function($q) use ($posyandu) {
                $q->where('id_posyandu', $posyandu->id_posyandu);
            })->whereDate('tanggal_ukur', today())->count(),
        ];
        
        return view('posyandu.pengukuran.riwayat', compact('posyandu', 'pengukuranList', 'stats'));
    }

    /**
     * Show detail pengukuran
     */
    public function riwayatPengukuranDetail($id)
    {
        $userId = Auth::id();
        $posyandu = $this->getUserPosyandu($userId);
        
        $pengukuran = DataPengukuran::with(['anak.orangTua', 'stunting', 'petugas'])
            ->findOrFail($id);
        
        // Authorization check
        if ($pengukuran->anak->id_posyandu !== $posyandu->id_posyandu) {
            abort(404);
        }
        
        return view('posyandu.pengukuran.detail', compact('pengukuran', 'posyandu'));
    }

    /**
     * Export riwayat to Excel
     */
    public function riwayatExport(Request $request)
    {
        $userId = Auth::id();
        $posyandu = $this->getUserPosyandu($userId);
        
        $query = DataPengukuran::with(['anak.orangTua', 'stunting'])
            ->whereHas('anak', function($q) use ($posyandu) {
                $q->where('id_posyandu', $posyandu->id_posyandu);
            });
        
        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('anak', function($q) use ($search) {
                $q->where('nama_anak', 'like', "%{$search}%")
                ->orWhere('nik_anak', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal_ukur', '>=', $request->tanggal_dari);
        }
        
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal_ukur', '<=', $request->tanggal_sampai);
        }
        
        $pengukuranList = $query->orderBy('tanggal_ukur', 'desc')->get();
        
        // Generate Excel using PhpSpreadsheet
        return $this->generateExcelRiwayat($pengukuranList, $posyandu);
    }

    /**
     * Generate Excel file
     */
    private function generateExcelRiwayat($data, $posyandu)
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set title
        $sheet->setCellValue('A1', 'RIWAYAT PENGUKURAN ANAK');
        $sheet->setCellValue('A2', $posyandu->nama_posyandu);
        $sheet->setCellValue('A3', 'Periode: ' . now()->format('d F Y'));
        
        // Merge cells for title
        $sheet->mergeCells('A1:K1');
        $sheet->mergeCells('A2:K2');
        $sheet->mergeCells('A3:K3');
        
        // Style title
        $titleStyle = [
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ];
        $sheet->getStyle('A1:A3')->applyFromArray($titleStyle);
        
        // Headers
        $headers = ['No', 'Tanggal', 'NIK Anak', 'Nama Anak', 'Umur (bln)', 'BB (kg)', 'TB (cm)', 'LK (cm)', 'LL (cm)', 'Status Gizi', 'Petugas'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '5', $header);
            $col++;
        }
        
        // Style headers
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '0D9488']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ];
        $sheet->getStyle('A5:K5')->applyFromArray($headerStyle);
        
        // Data
        $row = 6;
        foreach ($data as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, \Carbon\Carbon::parse($item->tanggal_ukur)->format('d/m/Y'));
            $sheet->setCellValue('C' . $row, $item->anak->nik_anak);
            $sheet->setCellValue('D' . $row, $item->anak->nama_anak);
            $sheet->setCellValue('E' . $row, $item->umur_bulan);
            $sheet->setCellValue('F' . $row, $item->berat_badan);
            $sheet->setCellValue('G' . $row, $item->tinggi_badan);
            $sheet->setCellValue('H' . $row, $item->lingkar_kepala);
            $sheet->setCellValue('I' . $row, $item->lingkar_lengan);
            $sheet->setCellValue('J' . $row, $item->stunting ? $item->stunting->status_stunting : '-');
            $sheet->setCellValue('K' . $row, $item->petugas ? $item->petugas->nama : '-');
            $row++;
        }
        
        // Auto-size columns
        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Generate file
        $filename = 'Riwayat_Pengukuran_' . $posyandu->nama_posyandu . '_' . now()->format('Y-m-d') . '.xlsx';
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    /**
     * UC-PSY-05: Notifikasi Management
     */
    public function notifikasiIndex(Request $request)
    {
        $userId = Auth::id();
        $posyandu = $this->getUserPosyandu($userId);
        
        // Build query
        $query = Notifikasi::where('id_user', $userId);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_baca', $request->status);
        }
        
        // Filter by type
        if ($request->filled('tipe')) {
            $query->where('tipe_notifikasi', $request->tipe);
        }
        
        // Sort
        $query->orderBy('tanggal_kirim', 'desc');
        
        // Paginate
        $notifikasiList = $query->paginate(20);
        
        // Statistics
        $stats = [
            'total' => Notifikasi::where('id_user', $userId)->count(),
            'belum_dibaca' => Notifikasi::where('id_user', $userId)
                ->where('status_baca', 'Belum Dibaca')->count(),
            'hari_ini' => Notifikasi::where('id_user', $userId)
                ->whereDate('tanggal_kirim', today())->count(),
        ];
        
        return view('posyandu.notifikasi.index', compact('posyandu', 'notifikasiList', 'stats'));
    }

    /**
     * Mark notification as read
     */
    public function notifikasiMarkAsRead($id)
    {
        $notifikasi = Notifikasi::where('id_user', Auth::id())->findOrFail($id);
        
        $notifikasi->update(['status_baca' => 'Sudah Dibaca']);
        
        return redirect()->back()->with('success', 'Notifikasi ditandai sudah dibaca');
    }

    /**
     * Mark all as read
     */
    public function notifikasiMarkAllAsRead()
    {
        Notifikasi::where('id_user', Auth::id())
            ->where('status_baca', 'Belum Dibaca')
            ->update(['status_baca' => 'Sudah Dibaca']);
        
        return redirect()->back()->with('success', 'Semua notifikasi ditandai sudah dibaca');
    }

    /**
     * Delete notification
     */
    public function notifikasiDelete($id)
    {
        $notifikasi = Notifikasi::where('id_user', Auth::id())->findOrFail($id);
        $notifikasi->delete();
        
        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus');
    }

    /**
     * Delete all read notifications
     */
    public function notifikasiDeleteAllRead()
    {
        Notifikasi::where('id_user', Auth::id())
            ->where('status_baca', 'Sudah Dibaca')
            ->delete();
        
        return redirect()->back()->with('success', 'Semua notifikasi yang sudah dibaca berhasil dihapus');
    }

    /**
     * UC-PSY-06: Laporan Posyandu
     */
    public function laporanIndex()
    {
        $userId = Auth::id();
        $posyandu = $this->getUserPosyandu($userId);
        
        if (!$posyandu) {
            return redirect()->route('posyandu.dashboard')->with('error', 'Posyandu tidak ditemukan');
        }
        
        // Get current month data
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        // Statistics for current month
        $stats = $this->getLaporanStats($posyandu->id_posyandu, $currentMonth, $currentYear);
        
        // Get available months for dropdown
        $availableMonths = $this->getAvailableMonths($posyandu->id_posyandu);
        
        return view('posyandu.laporan.index', compact('posyandu', 'stats', 'availableMonths'));
    }

    /**
     * Generate laporan statistics
     */
    private function getLaporanStats($idPosyandu, $month, $year)
    {
        // Total anak terdaftar
        $totalAnak = Anak::where('id_posyandu', $idPosyandu)->count();
        
        // Total pengukuran bulan ini
        $totalPengukuran = DataPengukuran::whereHas('anak', function($q) use ($idPosyandu) {
            $q->where('id_posyandu', $idPosyandu);
        })->whereMonth('tanggal_ukur', $month)
        ->whereYear('tanggal_ukur', $year)
        ->count();
        
        // Status gizi breakdown
        $statusBreakdown = DataStunting::whereHas('pengukuran.anak', function($q) use ($idPosyandu) {
            $q->where('id_posyandu', $idPosyandu);
        })->whereHas('pengukuran', function($q) use ($month, $year) {
            $q->whereMonth('tanggal_ukur', $month)
            ->whereYear('tanggal_ukur', $year);
        })->selectRaw('status_stunting, COUNT(*) as total')
        ->groupBy('status_stunting')
        ->get()
        ->pluck('total', 'status_stunting')
        ->toArray();
        
        $normal = $statusBreakdown['Normal'] ?? 0;
        $stuntingRingan = $statusBreakdown['Stunting Ringan'] ?? 0;
        $stuntingSedang = $statusBreakdown['Stunting Sedang'] ?? 0;
        $stuntingBerat = $statusBreakdown['Stunting Berat'] ?? 0;
        $totalStunting = $stuntingRingan + $stuntingSedang + $stuntingBerat;
        
        // Calculate percentages
        $persentaseStunting = $totalPengukuran > 0 ? round(($totalStunting / $totalPengukuran) * 100, 2) : 0;
        $persentaseNormal = $totalPengukuran > 0 ? round(($normal / $totalPengukuran) * 100, 2) : 0;
        
        return [
            'total_anak' => $totalAnak,
            'total_pengukuran' => $totalPengukuran,
            'normal' => $normal,
            'stunting_ringan' => $stuntingRingan,
            'stunting_sedang' => $stuntingSedang,
            'stunting_berat' => $stuntingBerat,
            'total_stunting' => $totalStunting,
            'persentase_stunting' => $persentaseStunting,
            'persentase_normal' => $persentaseNormal,
            'bulan' => $month,
            'tahun' => $year
        ];
    }

    /**
     * Get available months that have data
     */
    private function getAvailableMonths($idPosyandu)
    {
        return DataPengukuran::whereHas('anak', function($q) use ($idPosyandu) {
            $q->where('id_posyandu', $idPosyandu);
        })->selectRaw('YEAR(tanggal_ukur) as year, MONTH(tanggal_ukur) as month')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();
    }

    /**
     * Generate Laporan (View/Download)
     */
    public function laporanGenerate(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2015',
            'format' => 'required|in:view,pdf,excel'
        ]);
        
        $userId = Auth::id();
        $posyandu = $this->getUserPosyandu($userId);
        
        $stats = $this->getLaporanStats($posyandu->id_posyandu, $request->bulan, $request->tahun);
        
        // Get detailed data
        $detailData = $this->getLaporanDetailData($posyandu->id_posyandu, $request->bulan, $request->tahun);
        
        if ($request->format === 'view') {
            return view('posyandu.laporan.preview', compact('posyandu', 'stats', 'detailData'));
        } elseif ($request->format === 'pdf') {
            return $this->generateLaporanPDF($posyandu, $stats, $detailData);
        } else {
            return $this->generateLaporanExcel($posyandu, $stats, $detailData);
        }
    }

    /**
     * Get detail data for laporan
     */
    private function getLaporanDetailData($idPosyandu, $month, $year)
    {
        return DataPengukuran::with(['anak', 'stunting'])
            ->whereHas('anak', function($q) use ($idPosyandu) {
                $q->where('id_posyandu', $idPosyandu);
            })
            ->whereMonth('tanggal_ukur', $month)
            ->whereYear('tanggal_ukur', $year)
            ->orderBy('tanggal_ukur', 'desc')
            ->get();
    }

    /**
     * Generate PDF Laporan
     */
    private function generateLaporanPDF($posyandu, $stats, $detailData)
    {
        $pdf = new \Dompdf\Dompdf();
        
        $html = view('posyandu.laporan.pdf-template', compact('posyandu', 'stats', 'detailData'))->render();
        
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        
        $filename = 'Laporan_' . $posyandu->nama_posyandu . '_' . $stats['bulan'] . '_' . $stats['tahun'] . '.pdf';
        
        return $pdf->stream($filename);
    }

    /**
     * Generate Excel Laporan
     */
    private function generateLaporanExcel($posyandu, $stats, $detailData)
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Title
        $sheet->setCellValue('A1', 'LAPORAN BULANAN POSYANDU');
        $sheet->setCellValue('A2', strtoupper($posyandu->nama_posyandu));
        $sheet->setCellValue('A3', 'Periode: ' . $this->getMonthName($stats['bulan']) . ' ' . $stats['tahun']);
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        $sheet->mergeCells('A3:H3');
        
        // Summary Section
        $row = 5;
        $sheet->setCellValue('A' . $row, 'RINGKASAN DATA');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        
        $row++;
        $summaryData = [
            ['Total Anak Terdaftar', $stats['total_anak']],
            ['Total Pengukuran', $stats['total_pengukuran']],
            ['Status Normal', $stats['normal'] . ' (' . $stats['persentase_normal'] . '%)'],
            ['Stunting Ringan', $stats['stunting_ringan']],
            ['Stunting Sedang', $stats['stunting_sedang']],
            ['Stunting Berat', $stats['stunting_berat']],
            ['Total Stunting', $stats['total_stunting'] . ' (' . $stats['persentase_stunting'] . '%)'],
        ];
        
        foreach ($summaryData as $data) {
            $sheet->setCellValue('A' . $row, $data[0]);
            $sheet->setCellValue('B' . $row, $data[1]);
            $row++;
        }
        
        // Detail Section
        $row += 2;
        $sheet->setCellValue('A' . $row, 'DETAIL DATA PENGUKURAN');
        $sheet->mergeCells('A' . $row . ':H' . $row);
        
        $row++;
        $headers = ['No', 'Tanggal', 'Nama Anak', 'Umur (bln)', 'BB (kg)', 'TB (cm)', 'LK (cm)', 'Status'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $col++;
        }
        
        $row++;
        foreach ($detailData as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, \Carbon\Carbon::parse($item->tanggal_ukur)->format('d/m/Y'));
            $sheet->setCellValue('C' . $row, $item->anak->nama_anak);
            $sheet->setCellValue('D' . $row, $item->umur_bulan);
            $sheet->setCellValue('E' . $row, $item->berat_badan);
            $sheet->setCellValue('F' . $row, $item->tinggi_badan);
            $sheet->setCellValue('G' . $row, $item->lingkar_kepala);
            $sheet->setCellValue('H' . $row, $item->stunting ? $item->stunting->status_stunting : '-');
            $row++;
        }
        
        // Auto-size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        $filename = 'Laporan_' . $posyandu->nama_posyandu . '_' . $stats['bulan'] . '_' . $stats['tahun'] . '.xlsx';
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    /**
     * Helper: Get month name in Indonesian
     */
    private function getMonthName($month)
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $months[$month] ?? '';
    }

    /**
     * Profile Page
     */
    public function profile()
    {
        $userId = Auth::id();
        $user = User::with('orangTua')->findOrFail($userId);
        $posyandu = $this->getUserPosyandu($userId);
        
        // Get statistics for this petugas
        $stats = [
            'total_input' => DataPengukuran::where('id_petugas', $userId)->count(),
            'bulan_ini' => DataPengukuran::where('id_petugas', $userId)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'terakhir_input' => DataPengukuran::where('id_petugas', $userId)
                ->latest('created_at')
                ->first(),
        ];
        
        return view('posyandu.profile.index', compact('user', 'posyandu', 'stats'));
    }

    /**
     * Update Profile
     */
    public function profileUpdate(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:User,email,' . Auth::id() . ',id_user',
            'no_telepon' => 'nullable|string|max:15',
            'password' => 'nullable|min:8|confirmed',
        ]);
        
        $user = User::findOrFail(Auth::id());
        
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_telepon = $request->no_telepon;
        
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        
        $user->updated_at = now();
        $user->save();
        
        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Settings Page
     */
    public function settings()
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);
        $posyandu = $this->getUserPosyandu($userId);
        
        return view('posyandu.settings.index', compact('user', 'posyandu'));
    }

    /**
     * Update Settings
     */
    public function settingsUpdate(Request $request)
    {
        $request->validate([
            'notifikasi_email' => 'boolean',
            'notifikasi_browser' => 'boolean',
            'auto_logout' => 'boolean',
            'auto_logout_duration' => 'nullable|integer|min:5|max:120',
        ]);
        
        // Store settings in session or database (preference table)
        session([
            'settings.notifikasi_email' => $request->boolean('notifikasi_email'),
            'settings.notifikasi_browser' => $request->boolean('notifikasi_browser'),
            'settings.auto_logout' => $request->boolean('auto_logout'),
            'settings.auto_logout_duration' => $request->auto_logout_duration ?? 30,
        ]);
        
        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan');
    }

    // ============= HELPER METHODS =============

    /**
     * Get posyandu assignment for user
     * FIX: Mengambil data berdasarkan id_user (One-to-One)
     */
    private function getUserPosyandu($userId)
    {
        // 1. Ambil data User saat ini
        $user = User::find($userId);

        // 2. Cek apakah user punya id_posyandu
        if ($user && $user->id_posyandu) {
            // 3. Ambil data Posyandu berdasarkan ID yang ada di user
            return PosyanduModel::with('puskesmas')->find($user->id_posyandu);
        }

        return null;
    }

    /**
     * Detect outlier in measurement data
     */
    private function detectOutlier($data, $anak)
    {
        $umurBulan = Carbon::parse($anak->tanggal_lahir)
            ->diffInMonths(Carbon::parse($data['tanggal_ukur']));

        $errors = [];

        // Berat badan checks
        if ($data['berat_badan'] < 2 || $data['berat_badan'] > 40) {
            $errors[] = "Berat badan {$data['berat_badan']} kg tidak wajar untuk anak usia {$umurBulan} bulan.";
        }

        // Tinggi badan checks
        if ($data['tinggi_badan'] < 40 || $data['tinggi_badan'] > 140) {
            $errors[] = "Tinggi badan {$data['tinggi_badan']} cm tidak wajar untuk anak usia {$umurBulan} bulan.";
        }

        // Lingkar kepala checks
        if ($data['lingkar_kepala'] < 30 || $data['lingkar_kepala'] > 60) {
            $errors[] = "Lingkar kepala {$data['lingkar_kepala']} cm tidak wajar.";
        }

        if (!empty($errors)) {
            return [
                'is_outlier' => true,
                'message' => 'DATA TIDAK WAJAR TERDETEKSI! ' . implode(' ', $errors) . ' Apakah Anda yakin data sudah benar?'
            ];
        }

        return ['is_outlier' => false];
    }

    /**
     * Calculate Z-Score using Python microservice or fallback
     */
    private function calculateZScore($data)
    {
        // Try Python microservice first
        try {
            $response = Http::timeout(5)->post(env('ZSCORE_SERVICE_URL', 'http://localhost:5000/calculate'), $data);
            
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            \Log::warning('Python Z-Score service unavailable, using fallback');
        }

        // Fallback: Simplified PHP calculation
        return $this->calculateZScoreFallback($data);
    }

    /**
     * Fallback Z-Score calculation (simplified)
     */
    private function calculateZScoreFallback($data)
    {
        // Simplified WHO standards (production should use complete LMS tables)
        $umur = $data['umur_bulan'];
        $jk = $data['jenis_kelamin'];
        $bb = $data['berat_badan'];
        $tb = $data['tinggi_badan'];

        // Very simplified median calculation
        $median_bb = ($jk === 'L') ? (3.3 + $umur * 0.3) : (3.2 + $umur * 0.28);
        $median_tb = ($jk === 'L') ? (50 + $umur * 2.2) : (49.5 + $umur * 2.1);

        // Simplified Z-score
        $zscore_bb_u = round(($bb - $median_bb) / 1.5, 2);
        $zscore_tb_u = round(($tb - $median_tb) / 3, 2);
        $zscore_bb_tb = round(($bb - ($median_bb * 0.95)) / 1.2, 2);

        // Determine status
        $status = 'Normal';
        if ($zscore_tb_u < -3) {
            $status = 'Stunting Berat';
        } elseif ($zscore_tb_u < -2) {
            $status = 'Stunting Sedang';
        } elseif ($zscore_tb_u < -1) {
            $status = 'Stunting Ringan';
        }

        return [
            'zscore_tb_u' => $zscore_tb_u,
            'zscore_bb_u' => $zscore_bb_u,
            'zscore_bb_tb' => $zscore_bb_tb,
            'status_stunting' => $status
        ];
    }

    /**
     * Send notification to orang tua
     */
    private function sendStuntingNotification($anak, $stunting)
    {
        $orangTua = $anak->orangTua;
        
        if ($orangTua && $orangTua->user) {
            Notifikasi::create([
                'id_user' => $orangTua->id_user,
                'id_stunting' => $stunting->id_stunting,
                'judul' => 'Perhatian: Status Gizi Anak Memerlukan Perhatian',
                'pesan' => "Hasil pengukuran terbaru untuk anak Anda ({$anak->nama_anak}) menunjukkan status gizi: {$stunting->status_stunting}. Segera konsultasikan ke petugas kesehatan untuk penanganan lebih lanjut.",
                'tipe_notifikasi' => 'Peringatan',
                'status_baca' => 'Belum Dibaca',
                'tanggal_kirim' => now(),
                'created_at' => now()
            ]);
        }
    }

    /**
     * Get monthly trend data
     */
    private function getMonthlyTrend($idPosyandu, $months = 6)
    {
        $trends = [];
        
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $startDate = $date->copy()->startOfMonth();
            $endDate = $date->copy()->endOfMonth();

            $count = DataPengukuran::whereHas('anak', function($q) use ($idPosyandu) {
                $q->where('id_posyandu', $idPosyandu);
            })
            ->whereBetween('tanggal_ukur', [$startDate, $endDate])
            ->count();

            $trends[] = [
                'label' => $date->format('M Y'),
                'value' => $count
            ];
        }

        return $trends;
    }
}