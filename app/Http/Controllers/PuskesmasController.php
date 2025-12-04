<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Puskesmas;
use App\Models\Posyandu;
use App\Models\Anak;
use App\Models\DataPengukuran;
use App\Models\DataStunting;
use App\Models\IntervensiStunting;
use App\Models\Laporan;
use App\Models\OrangTua;
use App\Models\Notifikasi;
use App\Helpers\AuditHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PuskesmasController extends Controller
{
    // ========================================
    // UC-PUSK-01: DASHBOARD & MONITORING
    // ========================================
    
    /**
     * Dashboard utama Petugas Puskesmas
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get Puskesmas dari User (TODO: Sesuaikan dengan relasi User)
        // Untuk demo, kita ambil Puskesmas pertama
        $puskesmas = Puskesmas::where('status', 'Aktif')->first();
        
        if (!$puskesmas) {
            return redirect()->back()->with('error', 'Puskesmas tidak ditemukan');
        }
        
        // Get Posyandu di wilayah kerja
        $posyanduList = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->where('status', 'Aktif')
            ->get();
        
        $posyanduIds = $posyanduList->pluck('id_posyandu');
        
        // Statistics
        $totalAnak = Anak::whereIn('id_posyandu', $posyanduIds)->count();
        
        $kasusStunting = DataStunting::whereHas('dataPengukuran', function($q) use ($posyanduIds) {
                $q->whereIn('id_posyandu', $posyanduIds);
            })
            ->whereIn('status_stunting', ['Stunting Ringan', 'Stunting Sedang', 'Stunting Berat'])
            ->where('status_validasi', 'Validated')
            ->count();
        
        $persentaseStunting = $totalAnak > 0 ? round(($kasusStunting / $totalAnak) * 100, 1) : 0;
        
        // Pending Validation Count
        $pendingValidasi = DataStunting::whereHas('dataPengukuran', function($q) use ($posyanduIds) {
                $q->whereIn('id_posyandu', $posyanduIds);
            })
            ->where('status_validasi', 'Pending')
            ->count();
        
        // Data Posyandu (untuk tabel)
        $dataPosyandu = $posyanduList->map(function($posyandu) {
            $anakCount = Anak::where('id_posyandu', $posyandu->id_posyandu)->count();
            $stuntingCount = DataStunting::whereHas('dataPengukuran', function($q) use ($posyandu) {
                    $q->where('id_posyandu', $posyandu->id_posyandu);
                })
                ->whereIn('status_stunting', ['Stunting Ringan', 'Stunting Sedang', 'Stunting Berat'])
                ->where('status_validasi', 'Validated')
                ->count();
            
            return [
                'id' => $posyandu->id_posyandu,
                'nama' => $posyandu->nama_posyandu,
                'anak_terdaftar' => $anakCount,
                'kasus_stunting' => $stuntingCount,
                'persentase' => $anakCount > 0 ? round(($stuntingCount / $anakCount) * 100, 1) : 0
            ];
        });
        
        // Laporan Stunting (untuk chart)
        $laporanStunting = $this->getLaporanBulanan($posyanduIds);
        
        // Intervensi Terbaru
        $intervensiTerbaru = IntervensiStunting::whereHas('anak', function($q) use ($posyanduIds) {
                $q->whereIn('id_posyandu', $posyanduIds);
            })
            ->with(['anak', 'petugas'])
            ->latest('created_at')
            ->take(5)
            ->get();
        
        // Log activity
        AuditHelper::log(
            'VIEW',
            'Dashboard',
            'Mengakses dashboard Puskesmas',
            null,
            null,
            null
        );
        
        return view('puskesmas.dashboard.index', compact(
            'puskesmas',
            'totalAnak',
            'kasusStunting',
            'persentaseStunting',
            'pendingValidasi',
            'dataPosyandu',
            'laporanStunting',
            'intervensiTerbaru'
        ));
    }
    
    /**
     * Monitoring Data dengan filter
     */
    public function monitoring(Request $request)
    {
        $user = Auth::user();
        $puskesmas = Puskesmas::where('status', 'Aktif')->first();
        
        $posyanduIds = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->pluck('id_posyandu');
        
        // Build query
        $query = DataStunting::with([
                'dataPengukuran.anak.orangTua',
                'dataPengukuran.posyandu'
            ])
            ->whereHas('dataPengukuran', function($q) use ($posyanduIds) {
                $q->whereIn('id_posyandu', $posyanduIds);
            });
        
        // Apply filters
        if ($request->filled('posyandu')) {
            $query->whereHas('dataPengukuran', function($q) use ($request) {
                $q->where('id_posyandu', $request->posyandu);
            });
        }
        
        if ($request->filled('status_gizi')) {
            $query->where('status_stunting', $request->status_gizi);
        }
        
        if ($request->filled('tanggal_dari')) {
            $query->whereHas('dataPengukuran', function($q) use ($request) {
                $q->whereDate('tanggal_ukur', '>=', $request->tanggal_dari);
            });
        }
        
        if ($request->filled('tanggal_sampai')) {
            $query->whereHas('dataPengukuran', function($q) use ($request) {
                $q->whereDate('tanggal_ukur', '<=', $request->tanggal_sampai);
            });
        }
        
        $dataMonitoring = $query->latest('created_at')->paginate(20);
        
        // Get Posyandu list for filter
        $posyanduList = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->where('status', 'Aktif')
            ->get();
        
        return view('puskesmas.monitoring.index', compact(
            'dataMonitoring',
            'posyanduList',
            'puskesmas'
        ));
    }

    public function monitoringFilter(Request $request)
    {
        // Panggil method monitoring yang sudah memiliki logika filter di dalamnya
        return $this->monitoring($request);
    }
    
    /**
     * Helper: Get Laporan Bulanan untuk Chart
     */
    private function getLaporanBulanan($posyanduIds)
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            
            $stunting = DataStunting::whereHas('dataPengukuran', function($q) use ($posyanduIds, $month) {
                    $q->whereIn('id_posyandu', $posyanduIds)
                      ->whereYear('tanggal_ukur', $month->year)
                      ->whereMonth('tanggal_ukur', $month->month);
                })
                ->whereIn('status_stunting', ['Stunting Ringan', 'Stunting Sedang', 'Stunting Berat'])
                ->where('status_validasi', 'Validated')
                ->count();
            
            $data[] = [
                'bulan' => $month->locale('id')->isoFormat('MMM'),
                'kasus' => $stunting
            ];
        }
        
        return $data;
    }
    
    // ========================================
    // UC-PUSK-02: VALIDASI DATA STUNTING
    // ========================================
    
    /**
     * Halaman validasi data stunting
     */
    public function validasiIndex(Request $request)
    {
        $user = Auth::user();
        $puskesmas = Puskesmas::where('status', 'Aktif')->first();
        
        $posyanduIds = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->pluck('id_posyandu');
        
        // Build query dengan filter
        $query = DataStunting::with([
                'dataPengukuran.anak.orangTua',
                'dataPengukuran.posyandu',
                'dataPengukuran.petugas'
            ])
            ->whereHas('dataPengukuran', function($q) use ($posyanduIds) {
                $q->whereIn('id_posyandu', $posyanduIds);
            })
            ->where('status_validasi', 'Pending');
        
        // Apply search filter
        if ($request->filled('search')) {
            $query->whereHas('dataPengukuran.anak', function($q) use ($request) {
                $q->where('nama_anak', 'like', '%' . $request->search . '%');
            });
        }
        
        // Apply posyandu filter
        if ($request->filled('posyandu')) {
            $query->whereHas('dataPengukuran', function($q) use ($request) {
                $q->where('id_posyandu', $request->posyandu);
            });
        }
        
        // Apply date range filter
        if ($request->filled('tanggal_dari')) {
            $query->whereHas('dataPengukuran', function($q) use ($request) {
                $q->whereDate('tanggal_ukur', '>=', $request->tanggal_dari);
            });
        }
        
        if ($request->filled('tanggal_sampai')) {
            $query->whereHas('dataPengukuran', function($q) use ($request) {
                $q->whereDate('tanggal_ukur', '<=', $request->tanggal_sampai);
            });
        }
        
        // Pending Validations
        $pendingData = $query->latest('created_at')->paginate(20);
        
        // Statistics
        $totalPending = DataStunting::whereHas('dataPengukuran', function($q) use ($posyanduIds) {
                $q->whereIn('id_posyandu', $posyanduIds);
            })
            ->where('status_validasi', 'Pending')
            ->count();
        
        $validatedToday = DataStunting::whereHas('dataPengukuran', function($q) use ($posyanduIds) {
                $q->whereIn('id_posyandu', $posyanduIds);
            })
            ->where('status_validasi', 'Validated')
            ->where('id_validator', Auth::id())
            ->whereDate('tanggal_validasi', today())
            ->count();
        
        $rejectedToday = DataStunting::whereHas('dataPengukuran', function($q) use ($posyanduIds) {
                $q->whereIn('id_posyandu', $posyanduIds);
            })
            ->where('status_validasi', 'Rejected')
            ->where('id_validator', Auth::id())
            ->whereDate('tanggal_validasi', today())
            ->count();
        
        // Get Posyandu list for filter dropdown
        $posyanduList = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->where('status', 'Aktif')
            ->get();
        
        return view('puskesmas.validasi.index', compact(
            'pendingData',
            'totalPending',
            'validatedToday',
            'rejectedToday',
            'posyanduList'
        ));
    }
    
    /**
     * Detail data untuk validasi
     */
    public function validasiDetail($id)
    {
        $dataStunting = DataStunting::with([
            'dataPengukuran.anak.orangTua',
            'dataPengukuran.posyandu',
            'dataPengukuran.petugas'
        ])->findOrFail($id);
        
        // Get Riwayat Pengukuran (untuk grafik)
        $riwayatPengukuran = DataPengukuran::where('id_anak', $dataStunting->dataPengukuran->id_anak)
            ->with('dataStunting')
            ->orderBy('tanggal_ukur')
            ->get();
        
        // Log activity
        AuditHelper::log(
            'VIEW',
            'Data Stunting',
            'Melihat detail data stunting untuk validasi: ' . $dataStunting->dataPengukuran->anak->nama_anak,
            $id,
            null,
            null
        );
        
        return view('puskesmas.validasi.detail', compact('dataStunting', 'riwayatPengukuran'));
    }
    
    /**
     * Proses validasi data
     */
    public function validasiProses(Request $request, $id)
    {
        $request->validate([
            'status_validasi' => 'required|in:Validated,Rejected',
            'catatan_validasi' => 'nullable|string|max:500'
        ]);
        
        $dataStunting = DataStunting::findOrFail($id);
        
        // Store old values for audit
        $oldValues = [
            'status_validasi' => $dataStunting->status_validasi,
            'id_validator' => $dataStunting->id_validator
        ];
        
        $dataStunting->update([
            'status_validasi' => $request->status_validasi,
            'id_validator' => Auth::id(),
            'tanggal_validasi' => now(),
            'catatan_validasi' => $request->catatan_validasi
        ]);
        
        // Log Activity
        AuditHelper::log(
            'UPDATE',
            'Data Stunting',
            'Validasi data stunting: ' . $request->status_validasi,
            $id,
            $oldValues,
            [
                'status_validasi' => $request->status_validasi,
                'id_validator' => Auth::id()
            ]
        );
        
        // Jika Rejected, kirim notifikasi ke Petugas Posyandu
        if ($request->status_validasi === 'Rejected') {
            $petugasPosyandu = $dataStunting->dataPengukuran->petugas;
            
            Notifikasi::create([
                'id_user' => $petugasPosyandu->id_user,
                'id_stunting' => $id,
                'judul' => 'Data Pengukuran Ditolak',
                'pesan' => 'Data pengukuran ' . $dataStunting->dataPengukuran->anak->nama_anak . 
                           ' telah ditolak oleh Petugas Puskesmas. Alasan: ' . 
                           ($request->catatan_validasi ?: 'Tidak ada catatan'),
                'tipe_notifikasi' => 'Peringatan',
                'status_baca' => 'Belum Dibaca',
                'tanggal_kirim' => now()
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Validasi berhasil disimpan',
            'status' => $request->status_validasi
        ]);
    }
    
    /**
     * Bulk validation (multiple data sekaligus)
     */
    public function validasiBulk(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:data_stunting,id_stunting',
            'status_validasi' => 'required|in:Validated,Rejected',
            'catatan_validasi' => 'nullable|string|max:500'
        ]);
        
        $updated = DataStunting::whereIn('id_stunting', $request->ids)
            ->where('status_validasi', 'Pending')
            ->update([
                'status_validasi' => $request->status_validasi,
                'id_validator' => Auth::id(),
                'tanggal_validasi' => now(),
                'catatan_validasi' => $request->catatan_validasi
            ]);
        
        // Log
        AuditHelper::log(
            'UPDATE',
            'Data Stunting',
            "Bulk validation: {$updated} records " . $request->status_validasi,
            null,
            null,
            [
                'jumlah_data' => $updated,
                'status' => $request->status_validasi
            ]
        );
        
        // Send notifications if rejected
        if ($request->status_validasi === 'Rejected') {
            $dataList = DataStunting::whereIn('id_stunting', $request->ids)
                ->with('dataPengukuran.petugas')
                ->get();
            
            foreach ($dataList as $data) {
                Notifikasi::create([
                    'id_user' => $data->dataPengukuran->petugas->id_user,
                    'id_stunting' => $data->id_stunting,
                    'judul' => 'Data Pengukuran Ditolak (Bulk)',
                    'pesan' => 'Data pengukuran telah ditolak dalam validasi bulk.',
                    'tipe_notifikasi' => 'Peringatan',
                    'status_baca' => 'Belum Dibaca',
                    'tanggal_kirim' => now()
                ]);
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => "{$updated} data berhasil divalidasi",
            'count' => $updated
        ]);
    }
    
    // ========================================
    // UC-PUSK-04: INPUT DATA PENGUKURAN (BACKUP)
    // ========================================
    
    /**
     * Form input data pengukuran
     */

    /**
     * UC-PUSK-04: Input Data Pengukuran - Index
     */
    public function inputIndex()
    {
        $user = Auth::user();
        
        // Get puskesmas
        $puskesmas = Puskesmas::where('status', 'Aktif')->first();
        
        if (!$puskesmas) {
            return redirect()->route('puskesmas.dashboard')
                ->with('error', 'Data Puskesmas tidak ditemukan');
        }
        
        // Get posyandu list under this puskesmas
        $posyanduList = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->where('status', 'Aktif')
            ->orderBy('nama_posyandu')
            ->get();
        
        // Get all anak with their posyandu and orang tua info
        $anakList = Anak::with(['orangTua', 'posyandu'])
            ->whereHas('posyandu', function($q) use ($puskesmas) {
                $q->where('id_puskesmas', $puskesmas->id_puskesmas)
                ->where('status', 'Aktif');
            })
            ->orderBy('nama_anak')
            ->get()
            ->map(function($anak) {
                return [
                    'id_anak' => $anak->id_anak,
                    'nama_anak' => $anak->nama_anak,
                    'nik_anak' => $anak->nik_anak,
                    'jenis_kelamin' => $anak->jenis_kelamin,
                    'tanggal_lahir' => $anak->tanggal_lahir,
                    'id_posyandu' => $anak->id_posyandu,
                    'nama_posyandu' => $anak->posyandu->nama_posyandu ?? '-',
                    'nama_orangtua' => $anak->orangTua->nama_ayah ?? $anak->orangTua->nama_ibu ?? '-'
                ];
            });
        
        // Get recent inputs from session (will be populated after first input)
        $recentInputs = session('recent_inputs', []);
        
        // Get today's stats
        $inputsToday = session('inputs_today', 0);
        $stuntingToday = session('stunting_detected_today', 0);
        
        // If session is empty, calculate from database
        if ($inputsToday === 0) {
            $posyanduIds = $posyanduList->pluck('id_posyandu');
            
            $inputsToday = DataPengukuran::whereIn('id_posyandu', $posyanduIds)
                ->where('id_petugas', Auth::id())
                ->whereDate('created_at', today())
                ->count();
            
            $stuntingToday = DataStunting::whereHas('dataPengukuran', function($q) use ($posyanduIds) {
                    $q->whereIn('id_posyandu', $posyanduIds)
                    ->where('id_petugas', Auth::id())
                    ->whereDate('created_at', today());
                })
                ->whereIn('status_stunting', ['Stunting Ringan', 'Stunting Sedang', 'Stunting Berat'])
                ->count();
            
            session([
                'inputs_today' => $inputsToday,
                'stunting_detected_today' => $stuntingToday
            ]);
        }
        
        // Get actual recent inputs if session is empty
        if (empty($recentInputs)) {
            $posyanduIds = $posyanduList->pluck('id_posyandu');
            
            $recentData = DataPengukuran::with(['anak', 'dataStunting'])
                ->whereIn('id_posyandu', $posyanduIds)
                ->where('id_petugas', Auth::id())
                ->latest()
                ->take(5)
                ->get();
            
            $recentInputs = $recentData->map(function($data) {
                return [
                    'nama_anak' => $data->anak->nama_anak,
                    'berat_badan' => $data->berat_badan,
                    'tinggi_badan' => $data->tinggi_badan,
                    'status_gizi' => $data->dataStunting->status_stunting ?? 'Pending',
                    'time_ago' => $data->created_at->diffForHumans()
                ];
            })->toArray();
            
            session(['recent_inputs' => $recentInputs]);
        }
        
        return view('puskesmas.input.index', compact(
            'posyanduList',
            'anakList',
            'recentInputs'
        ));
    }

    public function inputStore(Request $request)
    {
        $request->validate([
            'id_anak' => 'required|exists:anak,id_anak',
            'tanggal_ukur' => 'required|date|before_or_equal:today',
            'berat_badan' => 'required|numeric|min:1|max:50',
            'tinggi_badan' => 'required|numeric|min:30|max:150',
            'lingkar_kepala' => 'required|numeric|min:20|max:60',
            'lingkar_lengan' => 'required|numeric|min:5|max:40',
            'catatan' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            // Get anak data
            $anak = Anak::with('orangTua.user')->findOrFail($request->id_anak);
            
            // Calculate umur_bulan
            $tanggalLahir = new \Carbon\Carbon($anak->tanggal_lahir);
            $tanggalUkur = new \Carbon\Carbon($request->tanggal_ukur);
            $umurBulan = $tanggalLahir->diffInMonths($tanggalUkur);
            
            // Auto-determine cara_ukur
            $caraUkur = $umurBulan < 24 ? 'Berbaring' : 'Berdiri';

            // Create Data Pengukuran
            $dataPengukuran = DataPengukuran::create([
                'id_anak' => $request->id_anak,
                'id_posyandu' => $anak->id_posyandu,
                'id_petugas' => Auth::id(),
                'tanggal_ukur' => $request->tanggal_ukur,
                'umur_bulan' => $umurBulan,
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan,
                'lingkar_kepala' => $request->lingkar_kepala,
                'lingkar_lengan' => $request->lingkar_lengan,
                'cara_ukur' => $caraUkur,
                'status_gizi' => 'Pending', // Will be updated after Z-Score
                'catatan' => $request->catatan
            ]);

            // Calculate Z-Score
            $zScores = $this->calculateZScore(
                $request->berat_badan,
                $request->tinggi_badan,
                $umurBulan,
                $anak->jenis_kelamin
            );

            // Determine stunting status
            $statusStunting = $this->determineStuntingStatus(
                $zScores['zscore_tb_u'],
                $zScores['zscore_bb_u'],
                $zScores['zscore_bb_tb']
            );

            // Create Data Stunting with AUTO-VALIDATED status
            $dataStunting = DataStunting::create([
                'id_pengukuran' => $dataPengukuran->id_pengukuran,
                'status_stunting' => $statusStunting,
                'zscore_tb_u' => $zScores['zscore_tb_u'],
                'zscore_bb_u' => $zScores['zscore_bb_u'],
                'zscore_bb_tb' => $zScores['zscore_bb_tb'],
                'status_validasi' => 'Validated', // AUTO-VALIDATED
                'id_validator' => Auth::id(),
                'tanggal_validasi' => now(),
                'catatan_validasi' => 'Auto-validated by Puskesmas upon data entry'
            ]);

            // Update status_gizi di pengukuran
            $dataPengukuran->update([
                'status_gizi' => $statusStunting
            ]);

            // Detect if stunting
            $stuntingDetected = in_array($statusStunting, [
                'Stunting Ringan', 
                'Stunting Sedang', 
                'Stunting Berat'
            ]);

            // Send notification to orang tua if stunting detected
            if ($stuntingDetected && $anak->orangTua && $anak->orangTua->user) {
                Notifikasi::create([
                    'id_user' => $anak->orangTua->user->id_user,
                    'id_stunting' => $dataStunting->id_stunting,
                    'judul' => 'Peringatan Status Gizi Anak',
                    'pesan' => "Anak Anda ({$anak->nama_anak}) terdeteksi {$statusStunting} berdasarkan pengukuran terbaru. Harap segera konsultasi ke Puskesmas terdekat untuk pemeriksaan lanjutan.",
                    'tipe_notifikasi' => 'Peringatan',
                    'status_baca' => 'Belum Dibaca',
                    'tanggal_kirim' => now()
                ]);

                // TODO: Send WhatsApp notification (integrate with WhatsApp API)
            }

            // Log activity
            AuditHelper::log(
                'input_data_pengukuran',
                "Input data pengukuran untuk anak: {$anak->nama_anak}",
                'create',
                null,
                $dataPengukuran->toArray()
            );

            // Update session stats
            $inputsToday = session('inputs_today', 0) + 1;
            $stuntingToday = session('stunting_detected_today', 0) + ($stuntingDetected ? 1 : 0);
            
            session([
                'inputs_today' => $inputsToday,
                'stunting_detected_today' => $stuntingToday
            ]);

            // Add to recent inputs
            $recentInputs = session('recent_inputs', []);
            array_unshift($recentInputs, [
                'nama_anak' => $anak->nama_anak,
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan,
                'status_gizi' => $statusStunting,
                'time_ago' => 'Baru saja'
            ]);
            session(['recent_inputs' => array_slice($recentInputs, 0, 5)]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data pengukuran berhasil disimpan dan divalidasi',
                'data' => [
                    'id_pengukuran' => $dataPengukuran->id_pengukuran,
                    'status_stunting' => $statusStunting,
                    'zscore_tb_u' => number_format($zScores['zscore_tb_u'], 2),
                    'stunting_detected' => $stuntingDetected
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error inputStore: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Calculate Z-Score for anthropometric data
     * This is a SIMPLIFIED version for demonstration
     * PRODUCTION should call Python microservice with WHO lookup tables
     * 
     * @param float $beratBadan
     * @param float $tinggiBadan
     * @param int $umurBulan
     * @param string $jenisKelamin (L/P)
     * @return array
     */
    private function calculateZScore($beratBadan, $tinggiBadan, $umurBulan, $jenisKelamin)
    {
        // SIMPLIFIED CALCULATION
        // In production, this should call Python service with WHO lookup tables
        
        // Mock WHO reference medians (L, M, S parameters)
        // These are APPROXIMATE values for demonstration only
        $whoReference = $this->getWHOReference($umurBulan, $jenisKelamin);
        
        // Calculate Z-Score using LMS method
        // Z = ((value/M)^L - 1) / (L * S)
        
        // Z-Score TB/U (Height-for-Age)
        $zscoreTBU = $this->calculateLMS(
            $tinggiBadan,
            $whoReference['tb']['L'],
            $whoReference['tb']['M'],
            $whoReference['tb']['S']
        );
        
        // Z-Score BB/U (Weight-for-Age)
        $zscoreBBU = $this->calculateLMS(
            $beratBadan,
            $whoReference['bb']['L'],
            $whoReference['bb']['M'],
            $whoReference['bb']['S']
        );
        
        // Z-Score BB/TB (Weight-for-Height)
        $zscoreBBTB = $this->calculateLMS(
            $beratBadan,
            $whoReference['bb_tb']['L'],
            $whoReference['bb_tb']['M'],
            $whoReference['bb_tb']['S']
        );
        
        return [
            'zscore_tb_u' => round($zscoreTBU, 2),
            'zscore_bb_u' => round($zscoreBBU, 2),
            'zscore_bb_tb' => round($zscoreBBTB, 2)
        ];
    }

    /**
     * Calculate Z-Score using LMS method
     * Formula: Z = ((value/M)^L - 1) / (L * S)
     */
    private function calculateLMS($value, $L, $M, $S)
    {
        if ($L == 0) {
            // When L=0, use: Z = ln(value/M) / S
            return log($value / $M) / $S;
        }
        
        return (pow($value / $M, $L) - 1) / ($L * $S);
    }

    /**
     * Get WHO reference values (SIMPLIFIED - Mock data)
     * PRODUCTION: Load from WHO lookup tables or database
     */
    private function getWHOReference($umurBulan, $jenisKelamin)
    {
        // This is MOCK data for demonstration
        // Production should use actual WHO Child Growth Standards tables
        
        if ($jenisKelamin === 'L') {
            // Laki-laki
            if ($umurBulan <= 12) {
                return [
                    'tb' => ['L' => 1, 'M' => 72.0, 'S' => 0.04],
                    'bb' => ['L' => 1, 'M' => 9.0, 'S' => 0.12],
                    'bb_tb' => ['L' => 1, 'M' => 9.0, 'S' => 0.10]
                ];
            } elseif ($umurBulan <= 24) {
                return [
                    'tb' => ['L' => 1, 'M' => 85.0, 'S' => 0.04],
                    'bb' => ['L' => 1, 'M' => 12.0, 'S' => 0.12],
                    'bb_tb' => ['L' => 1, 'M' => 12.0, 'S' => 0.10]
                ];
            } elseif ($umurBulan <= 36) {
                return [
                    'tb' => ['L' => 1, 'M' => 94.0, 'S' => 0.04],
                    'bb' => ['L' => 1, 'M' => 14.0, 'S' => 0.12],
                    'bb_tb' => ['L' => 1, 'M' => 14.0, 'S' => 0.10]
                ];
            } else {
                return [
                    'tb' => ['L' => 1, 'M' => 103.0, 'S' => 0.04],
                    'bb' => ['L' => 1, 'M' => 16.0, 'S' => 0.12],
                    'bb_tb' => ['L' => 1, 'M' => 16.0, 'S' => 0.10]
                ];
            }
        } else {
            // Perempuan
            if ($umurBulan <= 12) {
                return [
                    'tb' => ['L' => 1, 'M' => 70.0, 'S' => 0.04],
                    'bb' => ['L' => 1, 'M' => 8.5, 'S' => 0.12],
                    'bb_tb' => ['L' => 1, 'M' => 8.5, 'S' => 0.10]
                ];
            } elseif ($umurBulan <= 24) {
                return [
                    'tb' => ['L' => 1, 'M' => 83.0, 'S' => 0.04],
                    'bb' => ['L' => 1, 'M' => 11.5, 'S' => 0.12],
                    'bb_tb' => ['L' => 1, 'M' => 11.5, 'S' => 0.10]
                ];
            } elseif ($umurBulan <= 36) {
                return [
                    'tb' => ['L' => 1, 'M' => 92.0, 'S' => 0.04],
                    'bb' => ['L' => 1, 'M' => 13.5, 'S' => 0.12],
                    'bb_tb' => ['L' => 1, 'M' => 13.5, 'S' => 0.10]
                ];
            } else {
                return [
                    'tb' => ['L' => 1, 'M' => 101.0, 'S' => 0.04],
                    'bb' => ['L' => 1, 'M' => 15.5, 'S' => 0.12],
                    'bb_tb' => ['L' => 1, 'M' => 15.5, 'S' => 0.10]
                ];
            }
        }
    }

    /**
     * Determine stunting status based on Z-Scores
     * Using WHO classification standards
     */
    private function determineStuntingStatus($zscoreTBU, $zscoreBBU, $zscoreBBTB)
    {
        // Primary indicator: Z-Score TB/U (Height-for-Age)
        // WHO Classification:
        // Normal: Z-Score >= -2 SD
        // Stunting Ringan: -3 SD <= Z-Score < -2 SD
        // Stunting Sedang: -4 SD <= Z-Score < -3 SD
        // Stunting Berat: Z-Score < -4 SD
        
        if ($zscoreTBU >= -2.0) {
            return 'Normal';
        } elseif ($zscoreTBU >= -3.0) {
            return 'Stunting Ringan';
        } elseif ($zscoreTBU >= -4.0) {
            return 'Stunting Sedang';
        } else {
            return 'Stunting Berat';
        }
    }
    
    // ========================================
    // UC-PUSK-05: EDIT DATA ANAK
    // ========================================
    
    /**
     * List data anak
     */
    public function anakIndex(Request $request)
    {
        $puskesmas = Puskesmas::where('status', 'Aktif')->first();
        
        $posyanduIds = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->pluck('id_posyandu');
        
        $query = Anak::with(['orangTua', 'posyandu'])
            ->whereIn('id_posyandu', $posyanduIds);
        
        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_anak', 'like', '%' . $request->search . '%')
                  ->orWhere('nik_anak', 'like', '%' . $request->search . '%');
            });
        }
        
        $anakList = $query->orderBy('nama_anak')->paginate(20);
        
        return view('puskesmas.anak.index', compact('anakList'));
    }
    
    /**
     * Form edit data anak
     */
    public function anakEdit($id)
    {
        $anak = Anak::with(['orangTua', 'posyandu'])->findOrFail($id);
        
        $puskesmas = Puskesmas::where('status', 'Aktif')->first();
        
        $posyanduList = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->where('status', 'Aktif')
            ->get();
        
        return view('puskesmas.anak.edit', compact('anak', 'posyanduList'));
    }
    
    /**
     * Update data anak
     */
    public function anakUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_anak' => 'required|string|max:100',
            'nik_anak' => 'required|string|size:16|unique:anak,nik_anak,' . $id . ',id_anak',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:100',
            'anak_ke' => 'nullable|integer|min:1',
            'id_posyandu' => 'required|exists:posyandu,id_posyandu'
        ]);
        
        $anak = Anak::findOrFail($id);
        
        // Store old values for audit
        $oldValues = $anak->toArray();
        
        $anak->update($request->all());
        
        // Log Activity
        AuditHelper::log(
            'UPDATE',
            'Anak',
            'Update data anak: ' . $anak->nama_anak,
            $id,
            $oldValues,
            $anak->fresh()->toArray()
        );
        
        return redirect()->route('puskesmas.anak.index')
            ->with('success', 'Data anak berhasil diperbarui');
    }
    
    // ========================================
    // UC-PUSK-06: KELOLA INTERVENSI STUNTING
    // ========================================
    
    /**
     * List semua intervensi
     */
    public function intervensiIndex()
    {
        $puskesmas = Puskesmas::where('status', 'Aktif')->first();
        
        $posyanduIds = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->pluck('id_posyandu');
        
        $intervensiList = IntervensiStunting::whereHas('anak', function($q) use ($posyanduIds) {
                $q->whereIn('id_posyandu', $posyanduIds);
            })
            ->with(['anak.orangTua', 'dataStunting', 'petugas'])
            ->latest('tanggal_pelaksanaan')
            ->paginate(20);
        
        // Statistics
        $totalIntervensi = IntervensiStunting::whereHas('anak', function($q) use ($posyanduIds) {
                $q->whereIn('id_posyandu', $posyanduIds);
            })->count();
        
        $selesai = IntervensiStunting::whereHas('anak', function($q) use ($posyanduIds) {
                $q->whereIn('id_posyandu', $posyanduIds);
            })
            ->where('status_tindak_lanjut', 'Selesai')
            ->count();
        
        $sedangBerjalan = IntervensiStunting::whereHas('anak', function($q) use ($posyanduIds) {
                $q->whereIn('id_posyandu', $posyanduIds);
            })
            ->where('status_tindak_lanjut', 'Sedang Berjalan')
            ->count();
        
        return view('puskesmas.intervensi.index', compact(
            'intervensiList',
            'totalIntervensi',
            'selesai',
            'sedangBerjalan'
        ));
    }
    
    /**
     * Form create intervensi
     */
    public function intervensiCreate($id_anak)
    {
        $anak = Anak::with(['orangTua', 'posyandu'])->findOrFail($id_anak);
        
        // Get latest stunting data
        $latestStunting = DataStunting::whereHas('dataPengukuran', function($q) use ($id_anak) {
                $q->where('id_anak', $id_anak);
            })
            ->where('status_validasi', 'Validated')
            ->whereIn('status_stunting', ['Stunting Ringan', 'Stunting Sedang', 'Stunting Berat'])
            ->latest('created_at')
            ->first();
        
        if (!$latestStunting) {
            return redirect()->back()->with('error', 'Anak tidak memiliki data stunting yang tervalidasi');
        }
        
        return view('puskesmas.intervensi.create', compact('anak', 'latestStunting'));
    }
    
    /**
     * Store intervensi
     */
    public function intervensiStore(Request $request)
    {
        $request->validate([
            'id_anak' => 'required|exists:anak,id_anak',
            'id_stunting' => 'required|exists:data_stunting,id_stunting',
            'jenis_intervensi' => 'required|in:PMT,Suplemen/Vitamin,Edukasi Gizi,Rujukan RS,Konseling,Lainnya',
            'tanggal_pelaksanaan' => 'required|date|before_or_equal:today',
            'dosis_jumlah' => 'nullable|string|max:100',
            'catatan_perkembangan' => 'required|string|max:1000',
            'status_tindak_lanjut' => 'required|in:Sedang Berjalan,Selesai,Perlu Rujukan Lanjutan',
            'file_pendukung' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);
        
        $data = $request->except('file_pendukung');
        $data['penanggung_jawab'] = Auth::id();
        
        // Handle file upload
        if ($request->hasFile('file_pendukung')) {
            $file = $request->file('file_pendukung');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('intervensi', $filename, 'public');
            $data['file_pendukung'] = $path;
        }
        
        $intervensi = IntervensiStunting::create($data);
        
        // Log Activity
        AuditHelper::log(
            'CREATE',
            'Intervensi Stunting',
            'Menambahkan intervensi ' . $request->jenis_intervensi . ' untuk anak ID: ' . $request->id_anak,
            $intervensi->id_intervensi,
            null,
            $intervensi->toArray()
        );
        
        // Send notification to orang tua
        $anak = Anak::with('orangTua')->findOrFail($request->id_anak);
        
        Notifikasi::create([
            'id_user' => $anak->orangTua->id_user,
            'id_stunting' => $request->id_stunting,
            'judul' => 'Intervensi Kesehatan Anak',
            'pesan' => 'Anak Anda (' . $anak->nama_anak . ') telah menerima intervensi ' . 
                       $request->jenis_intervensi . ' pada ' . 
                       Carbon::parse($request->tanggal_pelaksanaan)->locale('id')->isoFormat('D MMMM Y'),
            'tipe_notifikasi' => 'Informasi',
            'status_baca' => 'Belum Dibaca',
            'tanggal_kirim' => now()
        ]);
        
        return redirect()->route('puskesmas.intervensi.index')
            ->with('success', 'Data intervensi berhasil ditambahkan');
    }
    
    /**
     * Form edit intervensi
     */
    public function intervensiEdit($id)
    {
        $intervensi = IntervensiStunting::with(['anak.orangTua', 'dataStunting'])
            ->findOrFail($id);
        
        return view('puskesmas.intervensi.edit', compact('intervensi'));
    }
    
    /**
     * Update intervensi
     */
    public function intervensiUpdate(Request $request, $id)
    {
        $request->validate([
            'tanggal_pelaksanaan' => 'required|date|before_or_equal:today',
            'dosis_jumlah' => 'nullable|string|max:100',
            'catatan_perkembangan' => 'required|string|max:1000',
            'status_tindak_lanjut' => 'required|in:Sedang Berjalan,Selesai,Perlu Rujukan Lanjutan',
            'file_pendukung' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);
        
        $intervensi = IntervensiStunting::findOrFail($id);
        
        // Store old values
        $oldValues = $intervensi->toArray();
        
        $data = $request->except('file_pendukung');
        
        // Handle file upload
        if ($request->hasFile('file_pendukung')) {
            // Delete old file
            if ($intervensi->file_pendukung) {
                Storage::disk('public')->delete($intervensi->file_pendukung);
            }
            
            $file = $request->file('file_pendukung');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('intervensi', $filename, 'public');
            $data['file_pendukung'] = $path;
        }
        
        $intervensi->update($data);
        
        // Log Activity
        AuditHelper::log(
            'UPDATE',
            'Intervensi Stunting',
            'Update intervensi ID: ' . $id,
            $id,
            $oldValues,
            $intervensi->fresh()->toArray()
        );
        
        return redirect()->route('puskesmas.intervensi.index')
            ->with('success', 'Data intervensi berhasil diperbarui');
    }
    
    // ========================================
    // UC-PUSK-03: MEMBUAT LAPORAN
    // ========================================
    
    /**
     * Halaman laporan
     */
    public function laporanIndex()
    {
        $user = Auth::user();
        $puskesmas = Puskesmas::where('status', 'Aktif')->first();
        
        // Get laporan history
        $laporanList = Laporan::where('id_pembuat', Auth::id())
            ->where('jenis_laporan', 'Laporan Puskesmas')
            ->latest('created_at')
            ->paginate(10);
        
        return view('puskesmas.laporan.index', compact('laporanList', 'puskesmas'));
    }
    
    /**
     * Generate laporan
     */
    public function laporanGenerate(Request $request)
    {
        $request->validate([
            'jenis_laporan' => 'required|in:Bulanan,Tahunan',
            'periode_bulan' => 'required_if:jenis_laporan,Bulanan|nullable|integer|min:1|max:12',
            'periode_tahun' => 'required|integer|min:2020|max:' . date('Y')
        ]);
        
        $puskesmas = Puskesmas::where('status', 'Aktif')->first();
        
        $posyanduIds = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->pluck('id_posyandu');
        
        // Generate report data
        $reportData = $this->generateReportData(
            $posyanduIds,
            $request->jenis_laporan,
            $request->periode_bulan,
            $request->periode_tahun
        );
        
        // Create Laporan record
        $laporan = Laporan::create([
            'jenis_laporan' => 'Laporan Puskesmas',
            'id_pembuat' => Auth::id(),
            'periode_bulan' => $request->periode_bulan,
            'periode_tahun' => $request->periode_tahun,
            'id_wilayah' => $puskesmas->id_puskesmas,
            'tipe_wilayah' => 'Puskesmas',
            'total_anak' => $reportData['total_anak'],
            'total_stunting' => $reportData['total_stunting'],
            'total_normal' => $reportData['total_normal'],
            'persentase_stunting' => $reportData['persentase_stunting'],
            'file_laporan' => null, // Will be generated
            'tanggal_buat' => now()
        ]);
        
        // Log
        AuditHelper::log(
            'CREATE',
            'Laporan',
            'Generate laporan Puskesmas periode ' . $request->periode_bulan . '/' . $request->periode_tahun,
            $laporan->id_laporan,
            null,
            $laporan->toArray()
        );
        
        // Generate PDF/Excel file here
        // TODO: Implement PDF generation with Laravel DomPDF or similar
        
        return redirect()->route('puskesmas.laporan.index')
            ->with('success', 'Laporan berhasil dibuat');
    }
    
    /**
     * Generate report data
     */
    private function generateReportData($posyanduIds, $jenisLaporan, $bulan, $tahun)
    {
        $query = DataStunting::whereHas('dataPengukuran', function($q) use ($posyanduIds, $bulan, $tahun) {
            $q->whereIn('id_posyandu', $posyanduIds)
              ->whereYear('tanggal_ukur', $tahun);
            
            if ($bulan) {
                $q->whereMonth('tanggal_ukur', $bulan);
            }
        })->where('status_validasi', 'Validated');
        
        $totalAnak = $query->distinct('id_pengukuran')->count();
        
        $totalStunting = (clone $query)
            ->whereIn('status_stunting', ['Stunting Ringan', 'Stunting Sedang', 'Stunting Berat'])
            ->count();
        
        $totalNormal = (clone $query)
            ->where('status_stunting', 'Normal')
            ->count();
        
        $persentaseStunting = $totalAnak > 0 ? round(($totalStunting / $totalAnak) * 100, 2) : 0;
        
        return [
            'total_anak' => $totalAnak,
            'total_stunting' => $totalStunting,
            'total_normal' => $totalNormal,
            'persentase_stunting' => $persentaseStunting
        ];
    }
    
    /**
     * Download laporan
     */
    public function laporanDownload($id)
    {
        $laporan = Laporan::findOrFail($id);
        
        // Check authorization
        if ($laporan->id_pembuat !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        // Log
        AuditHelper::log(
            'VIEW',
            'Laporan',
            'Download laporan ID: ' . $id,
            $id,
            null,
            null
        );
        
        // TODO: Return actual file download
        return redirect()->back()->with('info', 'Download laporan sedang dalam pengembangan');
    }
}