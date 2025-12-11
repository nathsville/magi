<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DataStunting;
use App\Models\DataPengukuran;
use App\Models\Anak;
use App\Models\Puskesmas;
use App\Models\Posyandu;
use App\Models\Laporan;
use App\Models\Notifikasi;
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
    
    // ==================== MONITORING ====================
    public function monitoring()
    {
        $kecamatanList = ['Bacukiki', 'Bacukiki Barat', 'Ujung', 'Soreang'];
        
        return view('dppkb.monitoring.index', compact('kecamatanList'));
    }
    
    public function monitoringData(Request $request)
    {
        $kecamatan = $request->input('kecamatan');
        $periode = $request->input('periode', 'bulan_ini');
        
        // Date range berdasarkan periode
        $dateRange = $this->getDateRange($periode);
        
        $query = DataPengukuran::with(['anak.posyandu', 'dataStunting'])
            ->whereBetween('tanggal_ukur', [$dateRange['start'], $dateRange['end']]);
        
        if ($kecamatan) {
            $query->whereHas('anak.posyandu', function($q) use ($kecamatan) {
                $q->where('kecamatan', $kecamatan);
            });
        }
        
        $data = $query->get()->groupBy('anak.posyandu.kecamatan');
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'periode' => $periode,
            'date_range' => $dateRange
        ]);
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
    
    // ==================== VALIDASI FINAL ====================
    public function validasi()
    {
        return view('dppkb.validasi.index');
    }
    
    public function validasiData(Request $request)
    {
        $status = $request->input('status', 'Validated'); // Validated dari Puskesmas
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
        
        $data = $query->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return response()->json([
            'success' => true,
            'data' => $data
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
            
            // Update status ke Final (Approved by DPPKB)
            $stunting->update([
                'status_validasi' => 'Final',
                'id_validator' => Auth::id(),
                'tanggal_validasi' => now(),
                'catatan_validasi' => $request->catatan_validasi ?? 'Disetujui oleh DPPKB'
            ]);
            
            // Kirim notifikasi ke Puskesmas
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
            
            // Kembalikan status ke Pending untuk klarifikasi
            $stunting->update([
                'status_validasi' => 'Pending',
                'catatan_validasi' => 'KLARIFIKASI DPPKB: ' . $request->alasan
            ]);
            
            // Kirim notifikasi urgent ke Puskesmas
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
        
        // Riwayat pengukuran anak (5 terakhir)
        $riwayatPengukuran = DataPengukuran::where('id_anak', $stunting->dataPengukuran->id_anak)
            ->with('dataStunting')
            ->orderBy('tanggal_ukur', 'desc')
            ->limit(5)
            ->get();
        
        return view('dppkb.validasi.detail', compact('stunting', 'riwayatPengukuran'));
    }
    
    // ==================== LAPORAN DAERAH ====================
    public function laporan()
    {
        $laporan = Laporan::where('jenis_laporan', 'Laporan Daerah')
            ->where('id_pembuat', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('dppkb.laporan.index', compact('laporan'));
    }
    
    public function generateLaporan(Request $request)
    {
        $request->validate([
            'periode_bulan' => 'required|integer|between:1,12',
            'periode_tahun' => 'required|integer|min:2020',
            'kecamatan' => 'nullable|string'
        ]);
        
        try {
            DB::beginTransaction();
            
            // Hitung statistik
            $stats = $this->calculateStatistics(
                $request->periode_bulan,
                $request->periode_tahun,
                $request->kecamatan
            );
            
            // Generate PDF (akan diimplementasikan dengan library PDF)
            $filename = 'Laporan_Daerah_' . $request->periode_bulan . '_' . $request->periode_tahun . '.pdf';
            
            // Simpan record laporan
            $laporan = Laporan::create([
                'jenis_laporan' => 'Laporan Daerah',
                'id_pembuat' => Auth::id(),
                'periode_bulan' => $request->periode_bulan,
                'periode_tahun' => $request->periode_tahun,
                'id_wilayah' => 0, // 0 untuk seluruh kota
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
            ->with('dataStunting');
        
        if ($kecamatan) {
            $query->whereHas('anak.posyandu', function($q) use ($kecamatan) {
                $q->where('kecamatan', $kecamatan);
            });
        }
        
        $data = $query->get();
        $totalAnak = $data->unique('id_anak')->count();
        $totalStunting = $data->filter(function($item) {
            return $item->dataStunting && $item->dataStunting->status_stunting != 'Normal';
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