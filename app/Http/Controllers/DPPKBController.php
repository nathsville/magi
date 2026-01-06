<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\DataStunting;
use App\Models\DataPengukuran;
use App\Models\Anak;
use App\Models\Puskesmas;
use App\Models\Posyandu;
use App\Models\Laporan;
use App\Models\Notifikasi;
use App\Models\User;
use Carbon\Carbon;

class DPPKBController extends Controller
{
    // ==================== DASHBOARD ====================
    public function dashboard()
    {
        // Total Statistics
        $totalAnak = Anak::count();
        $totalStunting = DataStunting::whereIn('status_stunting', [
            'Stunting Ringan', 
            'Stunting Sedang', 
            'Stunting Berat'
        ])->count();
        
        $persentaseStunting = $totalAnak > 0 
            ? round(($totalStunting / $totalAnak) * 100, 2) 
            : 0;
        
        // Data Pending Validasi
        $pendingValidasi = DataStunting::where('status_validasi', 'Validated')
            ->count();
        
        // Tren Bulanan (6 bulan terakhir)
        $trenBulanan = DataPengukuran::select(
                DB::raw('DATE_FORMAT(tanggal_ukur, "%Y-%m") as bulan'),
                DB::raw('COUNT(*) as total_pengukuran')
            )
            ->where('tanggal_ukur', '>=', Carbon::now()->subMonths(6))
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();
        
        // Sebaran per Kecamatan
        $sebaranKecamatan = Posyandu::select(
                'kecamatan',
                DB::raw('COUNT(DISTINCT anak.id_anak) as total_anak'),
                DB::raw('COUNT(DISTINCT CASE WHEN data_stunting.status_stunting != "Normal" THEN anak.id_anak END) as total_stunting')
            )
            ->leftJoin('anak', 'posyandu.id_posyandu', '=', 'anak.id_posyandu')
            ->leftJoin('data_pengukuran', 'anak.id_anak', '=', 'data_pengukuran.id_anak')
            ->leftJoin('data_stunting', 'data_pengukuran.id_pengukuran', '=', 'data_stunting.id_pengukuran')
            ->groupBy('kecamatan')
            ->get()
            ->map(function($item) {
                $item->persentase = $item->total_anak > 0 
                    ? round(($item->total_stunting / $item->total_anak) * 100, 2) 
                    : 0;
                return $item;
            });
        
        // Top 5 Puskesmas dengan kasus tertinggi
        $topPuskesmas = Puskesmas::select(
                'puskesmas.nama_puskesmas',
                'puskesmas.kecamatan',
                DB::raw('COUNT(DISTINCT CASE WHEN data_stunting.status_stunting != "Normal" THEN anak.id_anak END) as total_stunting')
            )
            ->leftJoin('posyandu', 'puskesmas.id_puskesmas', '=', 'posyandu.id_puskesmas')
            ->leftJoin('anak', 'posyandu.id_posyandu', '=', 'anak.id_posyandu')
            ->leftJoin('data_pengukuran', 'anak.id_anak', '=', 'data_pengukuran.id_anak')
            ->leftJoin('data_stunting', 'data_pengukuran.id_pengukuran', '=', 'data_stunting.id_pengukuran')
            ->groupBy('puskesmas.id_puskesmas', 'puskesmas.nama_puskesmas', 'puskesmas.kecamatan')
            ->orderBy('total_stunting', 'desc')
            ->limit(5)
            ->get();
        
        // Notifikasi Terbaru
        $notifikasi = Notifikasi::where('id_user', Auth::id())
            ->where('status_baca', 'Belum Dibaca')
            ->orderBy('tanggal_kirim', 'desc')
            ->limit(5)
            ->get();
        
        return view('dppkb.dashboard.index', compact(
            'totalAnak',
            'totalStunting',
            'persentaseStunting',
            'pendingValidasi',
            'trenBulanan',
            'sebaranKecamatan',
            'topPuskesmas',
            'notifikasi'
        ));
    }

    // ==================== PROFILE ====================
    public function profile()
    {
        $pendingValidasi = DataStunting::where('status_validasi', 'Validated')->count();
        
        return view('dppkb.profile.index', compact('pendingValidasi'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nama' => 'required|string|max:255',
            // Validasi email unik kecuali untuk user ini sendiri (menggunakan id_user)
            'email' => 'required|email|max:255|unique:users,email,'.$user->id_user.',id_user',
        ]);

        // Update data user
        User::where('id_user', $user->id_user)->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        return back()->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|confirmed|min:8',
        ]);

        // Update password user
        User::where('id_user', Auth::id())->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'password-updated');
    }
    
    // ==================== MONITORING ====================
    public function monitoring()
    {
        $pendingValidasi = DataStunting::where('status_validasi', 'Validated')->count();
        $kecamatanList = ['Bacukiki', 'Bacukiki Barat', 'Ujung', 'Soreang'];
        
        return view('dppkb.monitoring.index', compact('kecamatanList', 'pendingValidasi'));
    }
    
    public function monitoringData(Request $request)
    {
        try {
            $kecamatan = $request->input('kecamatan');
            $periode = $request->input('periode', 'bulan_ini');
            
            // Bersihkan format input periode
            $periodeClean = str_replace(' ', '_', strtolower($periode));
            $dateRange = $this->getDateRange($periodeClean);
            
            // QUERY BUILDER AMAN
            $query = DB::table('data_pengukuran')
                ->join('anak', 'data_pengukuran.id_anak', '=', 'anak.id_anak')
                ->join('posyandu', 'anak.id_posyandu', '=', 'posyandu.id_posyandu')
                ->join('puskesmas', 'posyandu.id_puskesmas', '=', 'puskesmas.id_puskesmas')
                ->leftJoin('data_stunting', 'data_pengukuran.id_pengukuran', '=', 'data_stunting.id_pengukuran')
                ->select(
                    'data_pengukuran.id_pengukuran',
                    'data_pengukuran.tanggal_ukur',
                    'data_stunting.status_stunting',
                    'posyandu.kecamatan',
                    'posyandu.nama_posyandu',
                    'puskesmas.nama_puskesmas',
                    'anak.id_anak'
                )
                ->whereBetween('data_pengukuran.tanggal_ukur', [$dateRange['start'], $dateRange['end']]);
            
            if ($kecamatan) {
                $query->where('posyandu.kecamatan', $kecamatan);
            }
            
            $rawData = $query->get();
            
            // --- LOGIKA STATISTIK ---
            $totalAnak = $rawData->unique('id_anak')->count();
            
            // Filter stunting secara manual pada Collection untuk menghindari error database
            $stuntingData = $rawData->filter(function($item) {
                return in_array($item->status_stunting, ['Stunting Ringan', 'Stunting Sedang', 'Stunting Berat']);
            });
            $totalStunting = $stuntingData->unique('id_anak')->count();
            $prevalensi = $totalAnak > 0 ? round(($totalStunting / $totalAnak) * 100, 1) : 0;
            
            $stats = [
                'total_anak' => $totalAnak,
                'trend_anak' => 0,
                'total_stunting' => $totalStunting,
                'stunting_ringan' => $rawData->where('status_stunting', 'Stunting Ringan')->unique('id_anak')->count(),
                'stunting_sedang' => $rawData->where('status_stunting', 'Stunting Sedang')->unique('id_anak')->count(),
                'stunting_berat' => $rawData->where('status_stunting', 'Stunting Berat')->unique('id_anak')->count(),
                'prevalensi' => $prevalensi,
                'wilayah_prioritas' => 0 
            ];
            
            // --- GROUPING KECAMATAN ---
            $kecamatanData = $rawData->groupBy('kecamatan')->map(function($rows, $namaKec) {
                $tot = $rows->unique('id_anak')->count();
                $stun = $rows->filter(fn($r) => in_array($r->status_stunting, ['Stunting Ringan', 'Stunting Sedang', 'Stunting Berat']))->unique('id_anak')->count();
                $prev = $tot > 0 ? ($stun / $tot) * 100 : 0;
                
                return [
                    'nama' => $namaKec,
                    'total_anak' => $tot,
                    'total_stunting' => $stun,
                    'prevalensi' => $prev,
                    'total_posyandu' => $rows->unique('nama_posyandu')->count()
                ];
            })->values();
            
            $stats['wilayah_prioritas'] = $kecamatanData->where('prevalensi', '>', 20)->count();
            
            // --- DISTRIBUSI & TOP PUSKESMAS ---
            $distribusi = [
                'normal' => $rawData->where('status_stunting', 'Normal')->unique('id_anak')->count(),
                'ringan' => $stats['stunting_ringan'],
                'sedang' => $stats['stunting_sedang'],
                'berat'  => $stats['stunting_berat'],
            ];
            
            $topPuskesmas = $rawData->groupBy('nama_puskesmas')->map(function($rows, $nama) {
                $tot = $rows->unique('id_anak')->count();
                $stun = $rows->filter(fn($r) => in_array($r->status_stunting, ['Stunting Ringan', 'Stunting Sedang', 'Stunting Berat']))->unique('id_anak')->count();
                $prev = $tot > 0 ? ($stun / $tot) * 100 : 0;
                
                return [
                    'nama_puskesmas' => $nama,
                    'kecamatan' => $rows->first()->kecamatan,
                    'total_anak' => $tot,
                    'total_stunting' => $stun,
                    'prevalensi' => $prev,
                    'total_posyandu' => $rows->unique('nama_posyandu')->count()
                ];
            })->sortByDesc('total_stunting')->take(5)->values();
            
            // --- CHART TREN ---
            $tren = [
                'labels' => [], 
                'values' => []
            ];
            
            // Return JSON
            return response()->json([
                'success' => true,
                'stats' => $stats,
                'kecamatan' => $kecamatanData,
                'distribusi' => $distribusi,
                'top_puskesmas' => $topPuskesmas,
                'tren' => $tren,
                'periode' => $periode
            ]);
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Monitoring Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    public function monitoringWilayah($kecamatan)
    {
        $posyandu = Posyandu::where('kecamatan', $kecamatan)
            ->withCount(['anak as total_anak'])
            ->with(['anak.dataPengukuran.dataStunting' => function($q) {
                $q->latest()->limit(1);
            }])
            ->get();
        
        return view('dppkb.monitoring.wilayah', compact('kecamatan', 'posyandu'));
    }
    
    // ==================== STATISTIK ====================
    public function statistik(Request $request)
    {
        // 1. Handle AJAX Request untuk data JSON
        if ($request->ajax()) {
            $timeRange = $request->input('time_range', '1_tahun');
            $wilayah = $request->input('wilayah', 'all');
            
            // Tentukan range tanggal
            $endDate = now();
            $startDate = match($timeRange) {
                '6_bulan' => now()->subMonths(6),
                '2_tahun' => now()->subYears(2),
                'semua' => now()->subYears(10),
                'custom' => $request->start_date ? Carbon::parse($request->start_date) : now()->subYear(),
                default => now()->subYear(), // 1_tahun
            };

            // Base Query untuk pengukuran dalam range
            $baseQuery = DataStunting::whereHas('dataPengukuran', function($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal_ukur', [$startDate, $endDate]);
            });

            if ($wilayah !== 'all') {
                $kecamatanMap = [
                    'bacukiki' => 'Bacukiki',
                    'bacukiki_barat' => 'Bacukiki Barat',
                    'ujung' => 'Ujung',
                    'soreang' => 'Soreang'
                ];
                if (isset($kecamatanMap[$wilayah])) {
                    $baseQuery->whereHas('dataPengukuran.anak.posyandu', function($q) use ($kecamatanMap, $wilayah) {
                        $q->where('kecamatan', $kecamatanMap[$wilayah]);
                    });
                }
            }

            $data = $baseQuery->get();
            
            // Calculate Stats
            $totalStunting = $data->where('status_stunting', '!=', 'Normal')->count();
            $totalData = $data->count();
            $avgPrevalensi = $totalData > 0 ? round(($totalStunting / $totalData) * 100, 1) : 0;

            // Mocking trend data for chart
            $trenLabels = [];
            $trenValues = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $trenLabels[] = $month->format('M Y');
                // Simulasi data fluktuatif sekitar rata-rata
                $trenValues[] = max(0, $avgPrevalensi + rand(-2, 2));
            }

            // Distribusi Usia
            $distribusiUsia = [
                'values' => [
                    $data->where('dataPengukuran.umur_bulan', '<=', 6)->count(),
                    $data->whereBetween('dataPengukuran.umur_bulan', [7, 12])->count(),
                    $data->whereBetween('dataPengukuran.umur_bulan', [13, 24])->count(),
                    $data->where('dataPengukuran.umur_bulan', '>', 24)->count(),
                ]
            ];

            // Ranking Posyandu Mock (Top 5 & Bottom 5)
            $rankingPosyandu = [
                'top_5' => [
                    ['nama' => 'Posyandu Mawar', 'kecamatan' => 'Bacukiki', 'prevalensi' => 5.2, 'total_anak' => 45],
                    ['nama' => 'Posyandu Melati', 'kecamatan' => 'Ujung', 'prevalensi' => 7.8, 'total_anak' => 32],
                    ['nama' => 'Posyandu Anggrek', 'kecamatan' => 'Soreang', 'prevalensi' => 8.5, 'total_anak' => 50],
                    ['nama' => 'Posyandu Tulip', 'kecamatan' => 'Bacukiki Barat', 'prevalensi' => 9.1, 'total_anak' => 28],
                    ['nama' => 'Posyandu Kamboja', 'kecamatan' => 'Ujung', 'prevalensi' => 10.4, 'total_anak' => 35],
                ],
                'bottom_5' => [
                    ['nama' => 'Posyandu Kenanga', 'kecamatan' => 'Soreang', 'prevalensi' => 28.5, 'total_anak' => 40],
                    ['nama' => 'Posyandu Dahlia', 'kecamatan' => 'Bacukiki', 'prevalensi' => 25.2, 'total_anak' => 38],
                    ['nama' => 'Posyandu Teratai', 'kecamatan' => 'Bacukiki Barat', 'prevalensi' => 22.1, 'total_anak' => 42],
                    ['nama' => 'Posyandu Nusa Indah', 'kecamatan' => 'Ujung', 'prevalensi' => 21.8, 'total_anak' => 30],
                    ['nama' => 'Posyandu Flamboyan', 'kecamatan' => 'Soreang', 'prevalensi' => 19.5, 'total_anak' => 33],
                ]
            ];

            // Response JSON Structure
            return response()->json([
                'success' => true,
                'quick_stats' => [
                    'avg_prevalensi' => $avgPrevalensi,
                    'trend_avg' => -1.2, // Mock turun 1.2%
                    'wilayah_prioritas' => 2, // Mock 2 kecamatan merah
                    'tren_bulanan' => -2.5, // Mock turun 2.5%
                    'posyandu_monitored' => 45,
                    'total_posyandu' => 50
                ],
                'tren_prevalensi' => [
                    'labels' => $trenLabels,
                    'values' => $trenValues
                ],
                'distribusi_usia' => $distribusiUsia,
                'perbandingan_wilayah' => [
                    'labels' => ['Bacukiki', 'Bacukiki Barat', 'Ujung', 'Soreang'],
                    'values' => [12.5, 15.8, 18.2, 22.1] // Mock values
                ],
                'ranking_posyandu' => $rankingPosyandu,
                'advanced_analytics' => [
                    'korelasi' => [
                        'ekonomi' => 85,
                        'pendidikan' => 72
                    ],
                    'prediksi' => [
                        'nilai' => ($avgPrevalensi - 0.5) . '%',
                        'confidence' => '89%',
                        'trend' => 'turun'
                    ],
                    'rekomendasi' => [
                        'Fokus intervensi gizi di Kecamatan Soreang',
                        'Peningkatan edukasi MP-ASI di Posyandu Kenanga',
                        'Monitoring berkala balita usia 13-24 bulan'
                    ]
                ]
            ]);
        }

        // 2. Handle View Request
        $pendingValidasi = DataStunting::where('status_validasi', 'Validated')->count();
        return view('dppkb.statistik.index', compact('pendingValidasi'));
    }

    // ==================== VALIDASI FINAL ====================
    public function validasi()
    {
        $pendingValidasi = DataStunting::where('status_validasi', 'Validated')->count();
        return view('dppkb.validasi.index', compact('pendingValidasi'));
    }
    
    public function validasiData(Request $request)
    {
        $status = $request->input('status', 'Validated');
        $kecamatan = $request->input('kecamatan');
        $search = $request->input('search');
        
        $query = DataStunting::with([
                'dataPengukuran.anak.orangTua',
                'dataPengukuran.anak.posyandu.puskesmas',
                'validator'
            ])
            ->where('status_validasi', $status);
        
        if ($kecamatan) {
            $query->whereHas('dataPengukuran.anak.posyandu', function($q) use ($kecamatan) {
                $q->where('kecamatan', $kecamatan);
            });
        }
        
        if ($search) {
            $query->whereHas('dataPengukuran.anak', function($q) use ($search) {
                $q->where('nama_anak', 'like', "%{$search}%")
                  ->orWhere('nik_anak', 'like', "%{$search}%");
            });
        }
        
        // Ambil data pagination
        $paginator = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // TRANSFORMASI DATA (PENTING UNTUK JS)
        $transformedData = $paginator->getCollection()->map(function($item) {
            $pengukuran = $item->dataPengukuran;
            $anak = $pengukuran ? $pengukuran->anak : null;
            $posyandu = $anak ? $anak->posyandu : null;
            $puskesmas = $posyandu ? $posyandu->puskesmas : null;
            $orangTua = $anak ? $anak->orangTua : null;

            return [
                'id_stunting' => $item->id_stunting,
                'status_stunting' => $item->status_stunting,
                'status_validasi' => $item->status_validasi,
                'tanggal_validasi' => $item->tanggal_validasi,
                'z_score_tb_u' => $pengukuran->z_score_tb_u ?? 0,
                'umur_bulan' => $pengukuran->umur_bulan ?? 0,
                
                // Data Flattened (Aman untuk JS)
                'nama_anak' => $anak->nama_anak ?? 'Data Terhapus',
                'nik_anak' => $anak->nik_anak ?? '-',
                'jenis_kelamin' => $anak->jenis_kelamin ?? 'L',
                'nama_ibu' => $orangTua->nama_ibu ?? '-',
                'telepon_ortu' => $orangTua->telepon ?? '-',
                'nama_posyandu' => $posyandu->nama_posyandu ?? '-',
                'nama_puskesmas' => $puskesmas->nama_puskesmas ?? '-',
                'kecamatan' => $puskesmas->kecamatan ?? '-',
                'validator_nama' => $item->validator->nama ?? '-',
            ];
        });
        
        $paginator->setCollection($transformedData);
        
        $stats = [
            'pending' => DataStunting::where('status_validasi', 'Validated')->count(),
            'approved_today' => DataStunting::where('status_validasi', 'Final')->whereDate('tanggal_validasi', Carbon::today())->count(),
            'clarification' => DataStunting::where('status_validasi', 'Pending')->count(),
            'total_month' => DataStunting::whereMonth('created_at', Carbon::now()->month)->count(),
        ];
        
        return response()->json([
            'success' => true,
            'data' => $paginator,
            'stats' => $stats,
            'total' => $paginator->total()
        ]);
    }
    
    public function approveValidasi(Request $request, $id)
    {
        $request->validate([
            'catatan_validasi' => 'nullable|string|max:500'
        ]);
        
        try {
            DB::beginTransaction();
            
            $stunting = DataStunting::findOrFail($id);
            
            $stunting->update([
                'status_validasi' => 'Final',
                'id_validator' => Auth::id(),
                'tanggal_validasi' => now(),
                'catatan_validasi' => $request->catatan_validasi ?? 'Disetujui oleh DPPKB'
            ]);
            
            Notifikasi::create([
                'id_user' => $stunting->dataPengukuran->anak->posyandu->puskesmas->id_user ?? null,
                'id_stunting' => $stunting->id_stunting,
                'judul' => 'Data Stunting Disetujui DPPKB',
                'pesan' => "Data stunting untuk anak {$stunting->dataPengukuran->anak->nama_anak} telah disetujui dan masuk ke statistik resmi daerah.",
                'tipe_notifikasi' => 'Validasi',
                'status_baca' => 'Belum Dibaca',
                'tanggal_kirim' => now()
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil divalidasi dan disetujui'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memvalidasi data: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function mintaKlarifikasi(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|max:500'
        ]);
        
        try {
            DB::beginTransaction();
            
            $stunting = DataStunting::findOrFail($id);
            
            $stunting->update([
                'status_validasi' => 'Pending',
                'catatan_validasi' => 'KLARIFIKASI DPPKB: ' . $request->alasan
            ]);
            
            Notifikasi::create([
                'id_user' => $stunting->dataPengukuran->anak->posyandu->puskesmas->id_user ?? null,
                'id_stunting' => $stunting->id_stunting,
                'judul' => '⚠️ Klarifikasi Diperlukan - DPPKB',
                'pesan' => "URGENT: Data stunting untuk anak {$stunting->dataPengukuran->anak->nama_anak} memerlukan klarifikasi. Alasan: {$request->alasan}",
                'tipe_notifikasi' => 'Peringatan',
                'status_baca' => 'Belum Dibaca',
                'tanggal_kirim' => now()
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Permintaan klarifikasi berhasil dikirim'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim klarifikasi: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function validasiDetail($id)
    {
        $stunting = DataStunting::with([
                'dataPengukuran.anak.orangTua',
                'dataPengukuran.anak.posyandu.puskesmas',
                'dataPengukuran.petugas',
                'validator'
            ])
            ->findOrFail($id);
        
        $riwayatPengukuran = DataPengukuran::where('id_anak', $stunting->dataPengukuran->id_anak)
            ->with('dataStunting')
            ->orderBy('tanggal_ukur', 'desc')
            ->limit(5)
            ->get();
        
        return view('dppkb.validasi.detail', compact('stunting', 'riwayatPengukuran'));
    }
    
    // ==================== LAPORAN DAERAH ====================
    public function laporan(Request $request)
    {
        // JIKA REQUEST ADALAH AJAX (dari JavaScript loadLaporanHistory)
        if ($request->ajax()) {
            $query = Laporan::where('jenis_laporan', 'Laporan Daerah')
                ->where('id_pembuat', Auth::id());

            // Filter Pencarian
            if ($request->search) {
                $query->where('file_laporan', 'like', "%{$request->search}%");
            }

            // Filter Periode
            if ($request->periode && $request->periode !== 'semua') {
                if ($request->periode == 'bulan_ini') {
                    $query->whereMonth('tanggal_buat', Carbon::now()->month) // Ganti created_at jadi tanggal_buat
                          ->whereYear('tanggal_buat', Carbon::now()->year);
                } elseif ($request->periode == 'tahun_ini') {
                    $query->whereYear('tanggal_buat', Carbon::now()->year);
                } elseif ($request->periode == '3_bulan') {
                    $query->where('tanggal_buat', '>=', Carbon::now()->subMonths(3));
                }
            }

            // PERBAIKAN 1: Order by id_laporan atau tanggal_buat, jangan created_at
            $laporan = $query->orderBy('id_laporan', 'desc')->paginate(10);

            // Transform data agar sesuai dengan frontend
            $laporan->getCollection()->transform(function ($item) {
                // PERBAIKAN 2: Handling User Name (Cegah error jika nama null)
                $user = Auth::user();
                $namaPembuat = $user ? ($user->nama ?? $user->name ?? 'User') : 'Unknown';

                // PERBAIKAN 3: Handling Tanggal (Gunakan tanggal_buat)
                $tgl = $item->tanggal_buat ?? $item->created_at ?? now();
                // Pastikan format tanggal aman
                try {
                    $tanggalFormatted = $tgl instanceof \Carbon\Carbon ? $tgl->format('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($tgl));
                } catch (\Exception $e) {
                    $tanggalFormatted = '-';
                }

                return [
                    'id_laporan' => $item->id_laporan,
                    'jenis_laporan' => 'Laporan Daerah', 
                    'periode' => ($item->periode_bulan ?? '-') . ' ' . ($item->periode_tahun ?? '-'),
                    'wilayah' => 'Kota Parepare',
                    'format' => 'PDF', 
                    'pembuat' => $namaPembuat,
                    'tanggal_buat' => $tanggalFormatted,
                    'status' => 'completed',
                    'file_url' => asset('storage/laporan/' . ($item->file_laporan ?? ''))
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $laporan->items(),
                'current_page' => $laporan->currentPage(),
                'last_page' => $laporan->lastPage(),
                'total' => $laporan->total()
            ]);
        }

        // JIKA REQUEST BIASA (Load Halaman Pertama Kali)
        $pendingValidasi = DataStunting::where('status_validasi', 'Validated')->count();
        return view('dppkb.laporan.index', compact('pendingValidasi'));
    }

    public function laporanCount()
    {
        try {
            $count = Laporan::where('jenis_laporan', 'Laporan Daerah')
                ->where('id_pembuat', Auth::id())
                ->count();
            
            return response()->json([
                'success' => true,
                'total' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function laporanPreview(Request $request)
    {
        // 1. Tentukan Rentang Waktu
        $startDate = Carbon::now();
        $endDate = Carbon::now();
        $periodeLabel = '';

        if ($request->jenis_laporan == 'Laporan Bulanan') {
            $bulan = $request->bulan;
            $tahun = $request->tahun;
            $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();
            $periodeLabel = $startDate->isoFormat('MMMM YYYY');
            
        } elseif ($request->jenis_laporan == 'Laporan Tahunan') {
            $tahun = $request->tahun_tahunan ?? $request->tahun;
            $startDate = Carbon::createFromDate($tahun, 1, 1)->startOfYear();
            $endDate = Carbon::createFromDate($tahun, 12, 31)->endOfYear();
            $periodeLabel = "Tahun " . $tahun;
            
        } elseif ($request->jenis_laporan == 'Laporan Custom') {
            $startDate = Carbon::parse($request->tanggal_mulai)->startOfDay();
            $endDate = Carbon::parse($request->tanggal_selesai)->endOfDay();
            $periodeLabel = $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y');
        }

        // 2. Siapkan Data
        $kecamatanList = ['Bacukiki', 'Bacukiki Barat', 'Ujung', 'Soreang'];
        $targetKecamatan = $request->kecamatan ? [$request->kecamatan] : $kecamatanList;

        $dataKecamatan = [];
        $grandTotalAnak = 0;
        $grandTotalStunting = 0;

        foreach ($targetKecamatan as $kec) {
            $query = DataPengukuran::whereBetween('tanggal_ukur', [$startDate, $endDate])
                ->whereHas('anak.posyandu', function($q) use ($kec) {
                    $q->where('kecamatan', $kec);
                })
                // PERUBAHAN DISINI: Gunakan 'stunting' sesuai nama fungsi di Model Anda
                ->with('stunting'); 

            $measurements = $query->get();
            
            $totalAnak = $measurements->unique('id_anak')->count();
            
            $stuntingCount = $measurements->filter(function($m) {
                 // PERUBAHAN DISINI: Akses via property 'stunting'
                 return $m->stunting && $m->stunting->status_stunting != 'Normal';
            })->unique('id_anak')->count();

            $prevalensi = $totalAnak > 0 ? round(($stuntingCount / $totalAnak) * 100, 1) : 0;

            $dataKecamatan[] = [
                'nama' => $kec,
                'total_anak' => $totalAnak,
                'total_stunting' => $stuntingCount,
                'prevalensi' => $prevalensi
            ];

            $grandTotalAnak += $totalAnak;
            $grandTotalStunting += $stuntingCount;
        }

        $grandTotalNormal = $grandTotalAnak - $grandTotalStunting;
        $grandPrevalensi = $grandTotalAnak > 0 ? round(($grandTotalStunting / $grandTotalAnak) * 100, 1) : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'judul' => strtoupper($request->jenis_laporan),
                'periode' => $periodeLabel,
                'total_anak' => $grandTotalAnak,
                'total_stunting' => $grandTotalStunting,
                'total_normal' => $grandTotalNormal,
                'prevalensi' => $grandPrevalensi,
                'kecamatan' => $dataKecamatan,
                'download_url' => null 
            ]
        ]);
    }
    
    public function generateLaporan(Request $request)
    {
        // 1. Validasi Input (Sesuaikan dengan name di Form Blade)
        // Kita gunakan logika kondisional agar fleksibel
        if ($request->jenis_laporan == 'Laporan Tahunan') {
            $request->validate([
                'tahun_tahunan' => 'required|integer|min:2020',
            ]);
            $bulan = 12; // Default akhir tahun
            $tahun = $request->tahun_tahunan;
        } elseif ($request->jenis_laporan == 'Laporan Custom') {
            // Jika custom, sementara kita arahkan ke bulan ini atau logika lain
            // (Sesuaikan jika Anda punya logika khusus untuk range tanggal)
             $request->validate([
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date',
            ]);
            $bulan = now()->month;
            $tahun = now()->year;
        } else {
            // DEFAULT: Laporan Bulanan
            // Ubah 'periode_bulan' jadi 'bulan' agar cocok dengan HTML
            $request->validate([
                'bulan' => 'required|integer|between:1,12',
                'tahun' => 'required|integer|min:2020',
                'kecamatan' => 'nullable|string'
            ]);
            $bulan = $request->bulan;
            $tahun = $request->tahun;
        }
        
        try {
            DB::beginTransaction();
            
            // Hitung statistik
            $stats = $this->calculateStatistics(
                $bulan,
                $tahun,
                $request->kecamatan
            );
            
            // Nama file
            $filename = 'Laporan_Daerah_' . $bulan . '_' . $tahun . '.pdf';
            
            // === PERBAIKAN DISINI ===
            // Kita perpendek nama laporan agar muat di database
            // Ubah "Laporan Bulanan" jadi "Bulanan", dst.
            $jenisLaporanRaw = $request->jenis_laporan ?? 'Laporan Daerah';
            $jenisLaporanSimpan = str_replace('Laporan ', '', $jenisLaporanRaw);
            // Hasilnya akan menjadi: "Bulanan", "Tahunan", atau "Custom" (lebih pendek)

            // Simpan ke Database
            $laporan = Laporan::create([
                'jenis_laporan' => $jenisLaporanSimpan, // Gunakan variable yang sudah diperpendek
                'id_pembuat' => Auth::id(),
                'periode_bulan' => $bulan,
                'periode_tahun' => $tahun,
                'id_wilayah' => 0, 
                'tipe_wilayah' => 'Kabupaten',
                'total_anak' => $stats['total_anak'],
                'total_stunting' => $stats['total_stunting'],
                'total_normal' => $stats['total_normal'],
                'persentase_stunting' => $stats['persentase'],
                'file_laporan' => $filename,
                'tanggal_buat' => now() 
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil dibuat',
                'laporan_id' => $laporan->id_laporan
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat laporan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function notifikasi(Request $request)
    {
        // Handle AJAX Request for data listing
        if ($request->ajax()) {
            $query = Notifikasi::where('id_user', Auth::id());

            // Filter by Type
            if ($request->type && $request->type !== 'all') {
                // Map frontend values (validasi, peringatan) to DB values (Validasi, Peringatan)
                $query->where('tipe_notifikasi', ucfirst($request->type));
            }

            // Filter by Status
            if ($request->status && $request->status !== 'all') {
                $statusMap = [
                    'belum_dibaca' => 'Belum Dibaca',
                    'sudah_dibaca' => 'Sudah Dibaca'
                ];
                if (isset($statusMap[$request->status])) {
                    $query->where('status_baca', $statusMap[$request->status]);
                }
            }

            // Search
            if ($request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('judul', 'like', "%{$request->search}%")
                      ->orWhere('pesan', 'like', "%{$request->search}%");
                });
            }

            $data = $query->orderBy('tanggal_kirim', 'desc')->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $data->items(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total()
            ]);
        }

        // Handle View Request
        $pendingValidasi = DataStunting::where('status_validasi', 'Validated')->count();
        return view('dppkb.notifikasi.index', compact('pendingValidasi'));
    }

    public function notifikasiStats()
    {
        $userId = Auth::id();
        
        $stats = [
            'total' => Notifikasi::where('id_user', $userId)->count(),
            'belum_dibaca' => Notifikasi::where('id_user', $userId)->where('status_baca', 'Belum Dibaca')->count(),
            'terkirim_hari_ini' => Notifikasi::where('id_user', $userId)->whereDate('tanggal_kirim', Carbon::today())->count(),
            'by_type' => [
                'validasi' => Notifikasi::where('id_user', $userId)->where('tipe_notifikasi', 'Validasi')->count(),
                'peringatan' => Notifikasi::where('id_user', $userId)->where('tipe_notifikasi', 'Peringatan')->count(),
                'informasi' => Notifikasi::where('id_user', $userId)->where('tipe_notifikasi', 'Informasi')->count(),
            ],
            'minggu_ini' => Notifikasi::where('id_user', $userId)->where('tanggal_kirim', '>=', Carbon::now()->startOfWeek())->count(),
            'bulan_ini' => Notifikasi::where('id_user', $userId)->where('tanggal_kirim', '>=', Carbon::now()->startOfMonth())->count(),
        ];

        return response()->json($stats);
    }

    public function notifikasiDetail($id)
    {
        try {
            $notif = Notifikasi::where('id_user', Auth::id())->findOrFail($id);
            
            // Get related data context if exists
            $relatedData = null;
            if ($notif->id_stunting) {
                $stunting = DataStunting::with(['dataPengukuran.anak.posyandu.puskesmas'])->find($notif->id_stunting);
                if ($stunting) {
                    $relatedData = [
                        'nama_anak' => $stunting->dataPengukuran->anak->nama_anak ?? '-',
                        'status_stunting' => $stunting->status_stunting,
                        'posyandu' => $stunting->dataPengukuran->anak->posyandu->nama_posyandu ?? '-',
                        'kecamatan' => $stunting->dataPengukuran->anak->posyandu->puskesmas->kecamatan ?? '-'
                    ];
                }
            }

            // Append sender/receiver names (Simulated/Mocked logic)
            $notifData = $notif->toArray();
            $notifData['penerima_nama'] = Auth::user()->nama; // Current user
            $notifData['pengirim_nama'] = 'Sistem DPPKB';
            $notifData['related_data'] = $relatedData;

            return response()->json([
                'success' => true,
                'data' => $notifData
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Notifikasi tidak ditemukan'], 404);
        }
    }

    public function markAsRead($id)
    {
        try {
            $notif = Notifikasi::where('id_user', Auth::id())->findOrFail($id);
            $notif->update(['status_baca' => 'Sudah Dibaca']);
            return response()->json(['success' => true, 'message' => 'Notifikasi ditandai sudah dibaca']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal update status'], 500);
        }
    }

    public function markAllRead()
    {
        try {
            Notifikasi::where('id_user', Auth::id())
                ->where('status_baca', 'Belum Dibaca')
                ->update(['status_baca' => 'Sudah Dibaca']);
            return response()->json(['success' => true, 'message' => 'Semua notifikasi ditandai sudah dibaca']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal update status'], 500);
        }
    }

    public function deleteNotifikasi($id)
    {
        try {
            $notif = Notifikasi::where('id_user', Auth::id())->findOrFail($id);
            $notif->delete();
            return response()->json(['success' => true, 'message' => 'Notifikasi berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus notifikasi'], 500);
        }
    }

    public function getUsersList()
    {
        // Fetch users for compose dropdown
        $users = User::select('id_user', 'nama', 'role')
            ->where('id_user', '!=', Auth::id())
            ->orderBy('nama')
            ->get();
        return response()->json($users);
    }

    public function getStuntingDataList()
    {
        // Fetch stunting data for compose dropdown
        $data = DataStunting::with(['dataPengukuran.anak.posyandu'])
            ->select('id_stunting', 'id_pengukuran', 'status_stunting')
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get()
            ->map(function($item) {
                return [
                    'id_stunting' => $item->id_stunting,
                    'nama_anak' => $item->dataPengukuran->anak->nama_anak ?? 'Anak',
                    'status_stunting' => $item->status_stunting,
                    'posyandu' => $item->dataPengukuran->anak->posyandu->nama_posyandu ?? '-'
                ];
            });
        return response()->json($data);
    }

    public function sendNotifikasi(Request $request)
    {
        $request->validate([
            'tipe_notifikasi' => 'required',
            'penerima' => 'required',
            'judul' => 'required|max:200',
            'pesan' => 'required',
        ]);

        try {
            $targetUserIds = [];

            // Determine recipients
            if ($request->penerima === 'specific') {
                $targetUserIds = [$request->id_user_specific];
            } elseif ($request->penerima === 'all_orangtua') {
                $targetUserIds = User::where('role', 'Orang Tua')->pluck('id_user')->toArray();
            } elseif ($request->penerima === 'all_posyandu') {
                $targetUserIds = User::where('role', 'Petugas Posyandu')->pluck('id_user')->toArray();
            } elseif ($request->penerima === 'all_puskesmas') {
                $targetUserIds = User::where('role', 'Petugas Puskesmas')->pluck('id_user')->toArray();
            }

            // Create notifications
            foreach ($targetUserIds as $userId) {
                if (!$userId) continue;
                
                Notifikasi::create([
                    'id_user' => $userId,
                    'id_stunting' => $request->id_stunting ?? null,
                    'judul' => $request->judul,
                    'pesan' => $request->pesan,
                    'tipe_notifikasi' => ucfirst($request->tipe_notifikasi),
                    'status_baca' => 'Belum Dibaca',
                    'tanggal_kirim' => $request->scheduled_at ?? now()
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Notifikasi berhasil dikirim']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengirim notifikasi: ' . $e->getMessage()], 500);
        }
    }
    
    // ==================== HELPER METHODS ====================
    private function getDateRange($periode)
    {
        switch ($periode) {
            case 'hari_ini':
                return [
                    'start' => Carbon::today(),
                    'end' => Carbon::today()->endOfDay()
                ];
            case 'minggu_ini':
                return [
                    'start' => Carbon::now()->startOfWeek(),
                    'end' => Carbon::now()->endOfWeek()
                ];
            case 'bulan_ini':
                return [
                    'start' => Carbon::now()->startOfMonth(),
                    'end' => Carbon::now()->endOfMonth()
                ];
            case 'tahun_ini':
                return [
                    'start' => Carbon::now()->startOfYear(),
                    'end' => Carbon::now()->endOfYear()
                ];
            default:
                return [
                    'start' => Carbon::now()->startOfMonth(),
                    'end' => Carbon::now()->endOfMonth()
                ];
        }
    }
    
    private function calculateStatistics($bulan, $tahun, $kecamatan = null)
    {
        $query = DataPengukuran::whereMonth('tanggal_ukur', $bulan)
            ->whereYear('tanggal_ukur', $tahun)
            // PERUBAHAN DISINI: Ganti 'dataStunting' menjadi 'stunting'
            ->with('stunting'); 
        
        if ($kecamatan) {
            $query->whereHas('anak.posyandu', function($q) use ($kecamatan) {
                $q->where('kecamatan', $kecamatan);
            });
        }
        
        $data = $query->get();
        $totalAnak = $data->unique('id_anak')->count();
        
        $totalStunting = $data->filter(function($item) {
            // PERUBAHAN DISINI: Akses via property 'stunting'
            return $item->stunting && $item->stunting->status_stunting != 'Normal';
        })->unique('id_anak')->count();
        
        $totalNormal = $totalAnak - $totalStunting;
        $persentase = $totalAnak > 0 ? round(($totalStunting / $totalAnak) * 100, 2) : 0;
        
        return [
            'total_anak' => $totalAnak,
            'total_stunting' => $totalStunting,
            'total_normal' => $totalNormal,
            'persentase' => $persentase
        ];
    }
}