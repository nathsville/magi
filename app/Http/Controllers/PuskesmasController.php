<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataStunting;
use App\Models\DataPengukuran;
use App\Models\Anak;
use App\Models\Posyandu;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PuskesmasController extends Controller
{
    public function dashboard()
    {
        $totalAnak = Anak::count();
        $totalStunting = DataStunting::whereIn('status_stunting', ['Stunting Ringan', 'Stunting Sedang', 'Stunting Berat'])->count();
        $persentaseStunting = $totalAnak > 0 ? round(($totalStunting / $totalAnak) * 100, 2) : 0;
        $totalPosyandu = Posyandu::where('status', 'Aktif')->count();

        // Data per posyandu
        $dataPosyandu = Posyandu::withCount([
            'dataPengukuran as total_anak' => function($query) {
                $query->distinct('id_anak');
            }
        ])->get();

        // Laporan stunting
        $laporanStunting = $this->getLaporanStunting();

        // Intervensi stunting
        $intervensiStunting = $this->getIntervensiStunting();

        return view('puskesmas.dashboard', compact(
            'totalAnak',
            'totalStunting',
            'persentaseStunting',
            'totalPosyandu',
            'dataPosyandu',
            'laporanStunting',
            'intervensiStunting'
        ));
    }

    public function validasi()
    {
        $dataValidasi = DataStunting::with(['dataPengukuran.anak'])
            ->where('status_validasi', 'Pending')
            ->paginate(15);

        return view('puskesmas.validasi', compact('dataValidasi'));
    }

    public function validasiDetail($id)
    {
        $data = DataStunting::with(['dataPengukuran.anak.orangTua'])
            ->findOrFail($id);

        // Riwayat pengukuran anak
        $riwayat = DataPengukuran::where('id_anak', $data->dataPengukuran->id_anak)
            ->with('dataStunting')
            ->orderBy('tanggal_ukur', 'desc')
            ->get();

        return view('puskesmas.validasi-detail', compact('data', 'riwayat'));
    }

    public function validasiStore(Request $request, $id)
    {
        $request->validate([
            'status_validasi' => 'required|in:Validated,Rejected',
            'catatan_validasi' => 'nullable',
        ]);

        $data = DataStunting::findOrFail($id);
        $data->update([
            'status_validasi' => $request->status_validasi,
            'id_validator' => Auth::id(),
            'tanggal_validasi' => now(),
            'catatan_validasi' => $request->catatan_validasi,
        ]);

        return redirect()->route('puskesmas.validasi')
            ->with('success', 'Data berhasil divalidasi');
    }

    public function monitoring()
    {
        $dataPengukuran = DataPengukuran::with(['anak', 'dataStunting', 'posyandu'])
            ->latest('tanggal_ukur')
            ->paginate(20);

        return view('puskesmas.monitoring', compact('dataPengukuran'));
    }

    public function laporan()
    {
        $laporan = Laporan::where('id_pembuat', Auth::id())
            ->orWhere('tipe_wilayah', 'Puskesmas')
            ->latest('tanggal_buat')
            ->paginate(15);

        return view('puskesmas.laporan', compact('laporan'));
    }

    public function laporanGenerate(Request $request)
    {
        $request->validate([
            'periode_bulan' => 'required|integer|min:1|max:12',
            'periode_tahun' => 'required|integer',
        ]);

        // Hitung statistik
        $totalAnak = Anak::count();
        $totalStunting = DataStunting::whereIn('status_stunting', ['Stunting Ringan', 'Stunting Sedang', 'Stunting Berat'])->count();
        $totalNormal = DataStunting::where('status_stunting', 'Normal')->count();
        $persentaseStunting = $totalAnak > 0 ? round(($totalStunting / $totalAnak) * 100, 2) : 0;

        // Generate PDF
        $pdf = Pdf::loadView('puskesmas.laporan-pdf', compact(
            'totalAnak',
            'totalStunting',
            'totalNormal',
            'persentaseStunting'
        ));

        $filename = 'laporan_' . $request->periode_bulan . '_' . $request->periode_tahun . '.pdf';
        $path = 'laporan/' . $filename;

        // Simpan file
        \Storage::put('public/' . $path, $pdf->output());

        // Simpan record laporan
        Laporan::create([
            'jenis_laporan' => 'Laporan Puskesmas',
            'id_pembuat' => Auth::id(),
            'periode_bulan' => $request->periode_bulan,
            'periode_tahun' => $request->periode_tahun,
            'id_wilayah' => 1, // ID Puskesmas
            'tipe_wilayah' => 'Puskesmas',
            'total_anak' => $totalAnak,
            'total_stunting' => $totalStunting,
            'total_normal' => $totalNormal,
            'persentase_stunting' => $persentaseStunting,
            'file_laporan' => $path,
            'tanggal_buat' => now(),
        ]);

        return redirect()->route('puskesmas.laporan')
            ->with('success', 'Laporan berhasil dibuat');
    }

    private function getLaporanStunting()
    {
        return [
            ['periode' => 'Oktober 2023', 'jenis_laporan' => 'Laporan Bulanan', 'status' => 'Selesai', 'aksi' => 'Lihat'],
            ['periode' => 'September 2023', 'jenis_laporan' => 'Laporan Triwulan', 'status' => 'Selesai', 'aksi' => 'Lihat'],
            ['periode' => 'Agustus 2023', 'jenis_laporan' => 'Laporan Bulanan', 'status' => 'Dalam', 'aksi' => 'Lihat'],
        ];
    }

    private function getIntervensiStunting()
    {
        return [
            'pemberian_makanan_tambahan' => 'Program PMT untuk anak dengan gizi buruk',
            'edukasi_gizi' => 'Penyuluhan gizi seimbang untuk orang tua',
        ];
    }
}