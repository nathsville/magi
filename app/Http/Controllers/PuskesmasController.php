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
use Barryvdh\DomPDF\Facade\Pdf;

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
        // Ambil puskesmas aktif
        $puskesmas = Puskesmas::where('status', 'Aktif')->first();
        
        if (!$puskesmas) {
            return redirect()->route('puskesmas.dashboard')->with('error', 'Data Puskesmas tidak ditemukan');
        }

        $posyanduIds = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->pluck('id_posyandu');
        
        // --- Query Utama ---
        $query = DataStunting::with([
                'dataPengukuran.anak.orangTua',
                'dataPengukuran.posyandu'
            ])
            ->whereHas('dataPengukuran', function($q) use ($posyanduIds) {
                $q->whereIn('id_posyandu', $posyanduIds);
            });
        
        // --- Filter Logic ---
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
        
        // Apply Search (Nama Anak)
        if ($request->filled('search')) {
            $query->whereHas('dataPengukuran.anak', function($q) use ($request) {
                $q->where('nama_anak', 'like', '%' . $request->search . '%');
            });
        }
        
        $dataStunting = $query->latest('created_at')->paginate(20);

        // Hitung berdasarkan filter yang diterapkan atau data keseluruhan jika tanpa filter
        $statsQuery = clone $query; 
        $statsQuery->getQuery()->limit = null;
        $statsQuery->getQuery()->offset = null;

        $totalData = $statsQuery->count();
        $totalStunting = (clone $statsQuery)->whereIn('status_stunting', ['Stunting Ringan', 'Stunting Sedang', 'Stunting Berat'])->count();
        $persentaseStunting = $totalData > 0 ? round(($totalStunting / $totalData) * 100, 1) : 0;
        $validatedCount = (clone $statsQuery)->where('status_validasi', 'Validated')->count();

        // --- Data Pendukung View ---
        $posyanduList = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->where('status', 'Aktif')
            ->orderBy('nama_posyandu')
            ->get();
        
        AuditHelper::log('VIEW', 'Monitoring', 'Melihat data monitoring stunting');

        return view('puskesmas.monitoring.index', compact(
            'dataStunting',
            'posyanduList',
            'puskesmas',
            'totalData',
            'totalStunting',
            'persentaseStunting',
            'validatedCount'
        ));
    }

    public function monitoringFilter(Request $request)
    {
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
     * Data Anak - Index
     */
    public function anakIndex(Request $request)
    {
        $user = Auth::user();
        $puskesmas = Puskesmas::where('status', 'Aktif')->first();
        
        if (!$puskesmas) {
            return redirect()->route('puskesmas.dashboard')
                ->with('error', 'Data Puskesmas tidak ditemukan');
        }
        
        // Get posyandu IDs under this puskesmas
        $posyanduIds = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->pluck('id_posyandu');
        
        // Build query
        $query = Anak::with(['orangTua', 'posyandu'])
            ->whereIn('id_posyandu', $posyanduIds);
        
        // Apply search filter
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_anak', 'like', '%' . $request->search . '%')
                ->orWhere('nik_anak', 'like', '%' . $request->search . '%');
            });
        }
        
        // Apply posyandu filter
        if ($request->filled('posyandu')) {
            $query->where('id_posyandu', $request->posyandu);
        }
        
        // Apply jenis kelamin filter
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        
        // Get data with pagination
        $anakList = $query->orderBy('nama_anak')->paginate(20);
        
        // Get statistics
        $totalAnak = Anak::whereIn('id_posyandu', $posyanduIds)->count();
        $totalLakiLaki = Anak::whereIn('id_posyandu', $posyanduIds)
            ->where('jenis_kelamin', 'L')->count();
        $totalPerempuan = Anak::whereIn('id_posyandu', $posyanduIds)
            ->where('jenis_kelamin', 'P')->count();
        
        // Calculate average age in months
        $anakAll = Anak::whereIn('id_posyandu', $posyanduIds)->get();
        $totalUmur = 0;
        foreach ($anakAll as $anak) {
            $totalUmur += \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now());
        }
        $rataUmur = $totalAnak > 0 ? round($totalUmur / $totalAnak) : 0;
        
        // Get posyandu list for filter
        $posyanduList = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->where('status', 'Aktif')
            ->orderBy('nama_posyandu')
            ->get();
        
        return view('puskesmas.anak.index', compact(
            'anakList',
            'totalAnak',
            'totalLakiLaki',
            'totalPerempuan',
            'rataUmur',
            'posyanduList'
        ));
    }

    /**
     * UC-PUSK-05: Data Anak - Edit Form
     */
    public function anakEdit($id)
    {
        $anak = Anak::with(['orangTua', 'posyandu'])->findOrFail($id);
        
        // Get puskesmas
        $puskesmas = Puskesmas::where('status', 'Aktif')->first();
        
        // Get posyandu list
        $posyanduList = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->where('status', 'Aktif')
            ->orderBy('nama_posyandu')
            ->get();
        
        return view('puskesmas.anak.edit', compact('anak', 'posyanduList'));
    }

    /**
     * UC-PUSK-05: Data Anak - Update
     */
    public function anakUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_anak' => 'required|string|max:100',
            'nik_anak' => 'required|string|size:16|unique:anak,nik_anak,' . $id . ',id_anak',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'tempat_lahir' => 'nullable|string|max:100',
            'anak_ke' => 'nullable|integer|min:1|max:20',
            'id_posyandu' => 'required|exists:posyandu,id_posyandu'
        ], [
            'nama_anak.required' => 'Nama anak harus diisi',
            'nik_anak.required' => 'NIK anak harus diisi',
            'nik_anak.size' => 'NIK harus 16 digit',
            'nik_anak.unique' => 'NIK sudah terdaftar',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini',
            'id_posyandu.required' => 'Posyandu harus dipilih'
        ]);

        try {
            DB::beginTransaction();

            $anak = Anak::findOrFail($id);
            
            // Store old data for audit
            $oldData = $anak->toArray();
            
            // Update data
            $anak->update([
                'nama_anak' => $request->nama_anak,
                'nik_anak' => $request->nik_anak,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'anak_ke' => $request->anak_ke,
                'id_posyandu' => $request->id_posyandu
            ]);

            // Log activity
            AuditHelper::log(
                'update_data_anak',
                "Update data anak: {$anak->nama_anak}",
                'update',
                $oldData,
                $anak->toArray()
            );

            DB::commit();

            return redirect()->route('puskesmas.anak.index')
                ->with('success', 'Data anak berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error anakUpdate: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }
    
    // ========================================
    // UC-PUSK-06: KELOLA INTERVENSI STUNTING
    // ========================================
    
    /**
     * List semua intervensi
     */
    public function intervensiIndex(Request $request)
    {
        $user = Auth::user();
        
        // Get puskesmas
        $puskesmas = Puskesmas::where('status', 'Aktif')->first();
        if (!$puskesmas) {
            return redirect()->back()->with('error', 'Data Puskesmas tidak ditemukan');
        }

        // Get posyandu IDs under this puskesmas
        $posyanduIds = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->pluck('id_posyandu')
            ->toArray();

        // Build query
        $query = IntervensiStunting::whereHas('anak', function($q) use ($posyanduIds) {
            $q->whereIn('id_posyandu', $posyanduIds);
        })->with(['anak.posyandu', 'petugas']);

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('anak', function($q) use ($search) {
                $q->where('nama_anak', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('jenis_intervensi')) {
            $query->where('jenis_intervensi', $request->jenis_intervensi);
        }

        if ($request->filled('status')) {
            $query->where('status_tindak_lanjut', $request->status);
        }

        if ($request->filled('periode')) {
            $periode = $request->periode; // Format: Y-m
            $query->whereYear('tanggal_pelaksanaan', substr($periode, 0, 4))
                  ->whereMonth('tanggal_pelaksanaan', substr($periode, 5, 2));
        }

        // Statistics
        $totalIntervensi = IntervensiStunting::whereHas('anak', function($q) use ($posyanduIds) {
            $q->whereIn('id_posyandu', $posyanduIds);
        })->count();

        $sedangBerjalan = IntervensiStunting::whereHas('anak', function($q) use ($posyanduIds) {
            $q->whereIn('id_posyandu', $posyanduIds);
        })->where('status_tindak_lanjut', 'Sedang Berjalan')->count();

        $selesai = IntervensiStunting::whereHas('anak', function($q) use ($posyanduIds) {
            $q->whereIn('id_posyandu', $posyanduIds);
        })->where('status_tindak_lanjut', 'Selesai')->count();

        // Paginate
        $intervensiList = $query->orderBy('tanggal_pelaksanaan', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('puskesmas.intervensi.index', compact(
            'intervensiList',
            'totalIntervensi',
            'sedangBerjalan',
            'selesai'
        ));
    }

    /**
     * UC-PUSK-06: Intervensi Create Form
     */
    public function intervensiCreate()
    {
        // Get puskesmas
        $puskesmas = Puskesmas::where('status', 'Aktif')->first();
        if (!$puskesmas) {
            return redirect()->back()->with('error', 'Data Puskesmas tidak ditemukan');
        }

        // Get posyandu IDs under this puskesmas
        $posyanduIds = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->pluck('id_posyandu')
            ->toArray();

        // Get anak yang terindikasi stunting (status_stunting != 'Normal')
        $anakStuntingList = Anak::whereIn('id_posyandu', $posyanduIds)
            ->whereHas('dataPengukuran.dataStunting', function($q) {
                $q->where('status_stunting', '!=', 'Normal');
            })
            ->with('posyandu')
            ->orderBy('nama_anak')
            ->get();

        // Get petugas list (Petugas Posyandu & Petugas Puskesmas)
        $petugasList = User::whereIn('role', ['Petugas Posyandu', 'Petugas Puskesmas'])
            ->where('status', 'Aktif')
            ->orderBy('nama')
            ->get();

        return view('puskesmas.intervensi.create', compact(
            'anakStuntingList',
            'petugasList'
        ));
    }

    /**
     * UC-PUSK-06: Intervensi Store
     */
    public function intervensiStore(Request $request)
    {
        $validated = $request->validate([
            'id_anak' => 'required|exists:anak,id_anak',
            'jenis_intervensi' => 'required|in:PMT,Suplemen/Vitamin,Edukasi Gizi,Rujukan RS,Konseling,Lainnya',
            'deskripsi' => 'required|string|max:500',
            'tanggal_pelaksanaan' => 'required|date|before_or_equal:today',
            'dosis_jumlah' => 'nullable|string|max:100',
            'id_petugas' => 'required|exists:users,id_user',
            'status_tindak_lanjut' => 'required|in:Sedang Berjalan,Selesai,Perlu Rujukan Lanjutan',
            'catatan' => 'nullable|string|max:500',
            'file_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048'
        ], [
            'id_anak.required' => 'Nama anak harus dipilih',
            'jenis_intervensi.required' => 'Jenis intervensi harus dipilih',
            'deskripsi.required' => 'Deskripsi program harus diisi',
            'tanggal_pelaksanaan.required' => 'Tanggal pelaksanaan harus diisi',
            'tanggal_pelaksanaan.before_or_equal' => 'Tanggal pelaksanaan tidak boleh lebih dari hari ini',
            'id_petugas.required' => 'Petugas penanggung jawab harus dipilih',
            'status_tindak_lanjut.required' => 'Status tindak lanjut harus dipilih',
            'file_pendukung.mimes' => 'Format file harus: PDF, JPG, PNG, DOC, DOCX',
            'file_pendukung.max' => 'Ukuran file maksimal 2MB'
        ]);

        try {
            DB::beginTransaction();

            // Handle file upload
            $filePath = null;
            if ($request->hasFile('file_pendukung')) {
                $file = $request->file('file_pendukung');
                $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $filePath = $file->storeAs('intervensi', $fileName, 'public');
            }

            // Create intervensi
            $intervensi = IntervensiStunting::create([
                'id_anak' => $validated['id_anak'],
                'jenis_intervensi' => $validated['jenis_intervensi'],
                'deskripsi' => $validated['deskripsi'],
                'tanggal_pelaksanaan' => $validated['tanggal_pelaksanaan'],
                'dosis_jumlah' => $validated['dosis_jumlah'],
                'id_petugas' => $validated['id_petugas'],
                'status_tindak_lanjut' => $validated['status_tindak_lanjut'],
                'catatan' => $validated['catatan'],
                'file_pendukung' => $filePath,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Audit log
            AuditHelper::log(
                'create_intervensi',
                'IntervensiStunting',
                $intervensi->id_intervensi,
                null,
                $intervensi->toArray()
            );

            DB::commit();

            return redirect()->route('puskesmas.intervensi.index')
                ->with('success', 'Data intervensi berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete uploaded file if exists
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * UC-PUSK-06: Intervensi Edit Form
     */
    public function intervensiEdit($id)
    {
        $intervensi = IntervensiStunting::with(['anak.posyandu', 'petugas'])
            ->findOrFail($id);

        // Get petugas list
        $petugasList = User::whereIn('role', ['Petugas Posyandu', 'Petugas Puskesmas'])
            ->where('status', 'Aktif')
            ->orderBy('nama')
            ->get();

        return view('puskesmas.intervensi.edit', compact(
            'intervensi',
            'petugasList'
        ));
    }

    /**
     * UC-PUSK-06: Intervensi Update
     */
    public function intervensiUpdate(Request $request, $id)
    {
        $intervensi = IntervensiStunting::findOrFail($id);

        $validated = $request->validate([
            'jenis_intervensi' => 'required|in:PMT,Suplemen/Vitamin,Edukasi Gizi,Rujukan RS,Konseling,Lainnya',
            'deskripsi' => 'required|string|max:500',
            'tanggal_pelaksanaan' => 'required|date|before_or_equal:today',
            'dosis_jumlah' => 'nullable|string|max:100',
            'id_petugas' => 'required|exists:users,id_user',
            'status_tindak_lanjut' => 'required|in:Sedang Berjalan,Selesai,Perlu Rujukan Lanjutan',
            'catatan' => 'nullable|string|max:500',
            'file_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048'
        ], [
            'jenis_intervensi.required' => 'Jenis intervensi harus dipilih',
            'deskripsi.required' => 'Deskripsi program harus diisi',
            'tanggal_pelaksanaan.required' => 'Tanggal pelaksanaan harus diisi',
            'tanggal_pelaksanaan.before_or_equal' => 'Tanggal pelaksanaan tidak boleh lebih dari hari ini',
            'id_petugas.required' => 'Petugas penanggung jawab harus dipilih',
            'status_tindak_lanjut.required' => 'Status tindak lanjut harus dipilih',
            'file_pendukung.mimes' => 'Format file harus: PDF, JPG, PNG, DOC, DOCX',
            'file_pendukung.max' => 'Ukuran file maksimal 2MB'
        ]);

        try {
            DB::beginTransaction();

            // Store old data for audit
            $oldData = $intervensi->toArray();

            // Handle file upload
            if ($request->hasFile('file_pendukung')) {
                // Delete old file if exists
                if ($intervensi->file_pendukung && Storage::disk('public')->exists($intervensi->file_pendukung)) {
                    Storage::disk('public')->delete($intervensi->file_pendukung);
                }

                $file = $request->file('file_pendukung');
                $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $filePath = $file->storeAs('intervensi', $fileName, 'public');
                $validated['file_pendukung'] = $filePath;
            }

            // Update intervensi
            $intervensi->update($validated);

            // Audit log
            AuditHelper::log(
                'update_intervensi',
                'IntervensiStunting',
                $intervensi->id_intervensi,
                $oldData,
                $intervensi->fresh()->toArray()
            );

            DB::commit();

            return redirect()->route('puskesmas.intervensi.index')
                ->with('success', 'Data intervensi berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }
    
    // ========================================
    // UC-PUSK-03: MEMBUAT LAPORAN
    // ========================================
    
    /**
     * Halaman laporan
     */
    public function laporanIndex(Request $request)
    {
        $user = Auth::user();
        
        // Build query - only show reports created by current user or for their puskesmas
        $query = Laporan::where('id_pembuat', $user->id_user)
            ->with('pembuat');

        // Apply filters
        if ($request->filled('jenis_laporan')) {
            $query->where('jenis_laporan', $request->jenis_laporan);
        }

        if ($request->filled('tahun')) {
            $query->where('periode_tahun', $request->tahun);
        }

        if ($request->filled('bulan')) {
            $query->where('periode_bulan', $request->bulan);
        }

        // Order
        $order = $request->get('order', 'desc');
        $query->orderBy('created_at', $order);

        // Statistics
        $totalLaporan = Laporan::where('id_pembuat', $user->id_user)->count();
        
        $laporanBulanIni = Laporan::where('id_pembuat', $user->id_user)
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        $avgStunting = Laporan::where('id_pembuat', $user->id_user)
            ->avg('persentase_stunting') ?? 0;

        // Paginate
        $laporanList = $query->paginate(10)->withQueryString();

        return view('puskesmas.laporan.index', compact(
            'laporanList',
            'totalLaporan',
            'laporanBulanIni',
            'avgStunting'
        ));
    }

    /**
     * UC-PUSK-03: Laporan Create Form
     */
    public function laporanCreate()
    {
        return view('puskesmas.laporan.create');
    }

    /**
     * UC-PUSK-03: Preview Data (AJAX)
     */
    public function laporanPreviewData(Request $request)
    {
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        if (!$bulan || !$tahun) {
            return response()->json([
                'total_anak' => 0,
                'total_normal' => 0,
                'total_stunting' => 0
            ]);
        }

        // Get puskesmas
        $puskesmas = Puskesmas::where('status', 'Aktif')->first();
        if (!$puskesmas) {
            return response()->json(['error' => 'Puskesmas not found'], 404);
        }

        // Get posyandu IDs
        $posyanduIds = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
            ->pluck('id_posyandu')
            ->toArray();

        // Calculate stats for the period
        $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $totalAnak = DataPengukuran::whereIn('id_posyandu', $posyanduIds)
            ->whereBetween('tanggal_ukur', [$startDate, $endDate])
            ->distinct('id_anak')
            ->count('id_anak');

        $totalStunting = DataStunting::whereHas('pengukuran', function($q) use ($posyanduIds, $startDate, $endDate) {
                $q->whereIn('id_posyandu', $posyanduIds)
                  ->whereBetween('tanggal_ukur', [$startDate, $endDate]);
            })
            ->where('status_stunting', '!=', 'Normal')
            ->count();

        $totalNormal = $totalAnak - $totalStunting;

        return response()->json([
            'total_anak' => $totalAnak,
            'total_normal' => $totalNormal,
            'total_stunting' => $totalStunting
        ]);
    }

    /**
     * UC-PUSK-03: Laporan Store
     */
    public function laporanStore(Request $request)
    {
        $validated = $request->validate([
            'jenis_laporan' => 'required|in:Laporan Puskesmas,Laporan Daerah',
            'periode_bulan' => 'required|integer|between:1,12',
            'periode_tahun' => 'required|integer|min:2020|max:' . (date('Y') + 1)
        ], [
            'jenis_laporan.required' => 'Jenis laporan harus dipilih',
            'periode_bulan.required' => 'Bulan periode harus dipilih',
            'periode_tahun.required' => 'Tahun periode harus dipilih',
            'periode_tahun.max' => 'Tahun tidak valid'
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            
            // Get puskesmas
            $puskesmas = Puskesmas::where('status', 'Aktif')->first();
            if (!$puskesmas) {
                return redirect()->back()->with('error', 'Data Puskesmas tidak ditemukan');
            }

            // Get posyandu IDs
            $posyanduIds = Posyandu::where('id_puskesmas', $puskesmas->id_puskesmas)
                ->pluck('id_posyandu')
                ->toArray();

            // Calculate statistics for the period
            $startDate = Carbon::create($validated['periode_tahun'], $validated['periode_bulan'], 1)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();

            $totalAnak = DataPengukuran::whereIn('id_posyandu', $posyanduIds)
                ->whereBetween('tanggal_ukur', [$startDate, $endDate])
                ->distinct('id_anak')
                ->count('id_anak');

            $totalStunting = DataStunting::whereHas('pengukuran', function($q) use ($posyanduIds, $startDate, $endDate) {
                    $q->whereIn('id_posyandu', $posyanduIds)
                      ->whereBetween('tanggal_ukur', [$startDate, $endDate]);
                })
                ->where('status_stunting', '!=', 'Normal')
                ->count();

            $totalNormal = $totalAnak - $totalStunting;
            $persentaseStunting = $totalAnak > 0 ? round(($totalStunting / $totalAnak) * 100, 2) : 0;

            // Generate filename
            $filename = sprintf(
                'laporan_%s_%s_%s.pdf',
                strtolower(str_replace(' ', '_', $validated['jenis_laporan'])),
                $validated['periode_tahun'],
                str_pad($validated['periode_bulan'], 2, '0', STR_PAD_LEFT)
            );

            // Create laporan record
            $laporan = Laporan::create([
                'jenis_laporan' => $validated['jenis_laporan'],
                'id_pembuat' => $user->id_user,
                'periode_bulan' => $validated['periode_bulan'],
                'periode_tahun' => $validated['periode_tahun'],
                'id_wilayah' => $validated['jenis_laporan'] === 'Laporan Puskesmas' 
                    ? $puskesmas->id_puskesmas 
                    : 1, // Kabupaten/Kota ID
                'tipe_wilayah' => $validated['jenis_laporan'] === 'Laporan Puskesmas' 
                    ? 'Puskesmas' 
                    : 'Kabupaten',
                'total_anak' => $totalAnak,
                'total_stunting' => $totalStunting,
                'total_normal' => $totalNormal,
                'persentase_stunting' => $persentaseStunting,
                'file_laporan' => $filename,
                'tanggal_buat' => now(),
                'created_at' => now()
            ]);

            // Audit log
            AuditHelper::log(
                'create_laporan',
                'Laporan',
                $laporan->id_laporan,
                null,
                $laporan->toArray()
            );

            DB::commit();

            return redirect()->route('puskesmas.laporan.preview', $laporan->id_laporan)
                ->with('success', 'Laporan berhasil digenerate');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat laporan: ' . $e->getMessage());
        }
    }

    /**
     * UC-PUSK-03: Laporan Preview
     */
    public function laporanPreview($id)
    {
        $laporan = Laporan::with('pembuat')->findOrFail($id);

        // Check authorization
        if ($laporan->id_pembuat !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('puskesmas.laporan.preview', compact('laporan'));
    }

    /**
     * UC-PUSK-03: Laporan Download PDF
     */
    public function laporanDownload($id)
    {
        $laporan = Laporan::with('pembuat')->findOrFail($id);

        // Check authorization
        if ($laporan->id_pembuat !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Generate PDF
        $pdf = Pdf::loadView('puskesmas.laporan.pdf', compact('laporan'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        return $pdf->download($laporan->file_laporan);
    }
}