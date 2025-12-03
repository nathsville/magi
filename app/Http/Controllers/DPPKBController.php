<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataStunting;
use App\Models\Anak;
use App\Models\DataPengukuran;

class DPPKBController extends Controller
{
    public function dashboard()
    {
        $totalValidasi = DataStunting::where('status_validasi', 'Pending')->count();
        $totalStunting = DataStunting::whereIn('status_stunting', ['Stunting Ringan', 'Stunting Sedang', 'Stunting Berat'])->count();
        $persentaseStunting = Anak::count() > 0 ? round(($totalStunting / Anak::count()) * 100, 2) : 0;

        // Data validasi stunting
        $validasiData = DataStunting::with(['dataPengukuran.anak'])
            ->where('status_validasi', 'Pending')
            ->latest()
            ->take(5)
            ->get();

        // Monitoring data stunting
        $monitoringData = $this->getMonitoringData();

        // Wilayah dengan stunting tertinggi
        $wilayahStuntingTertinggi = $this->getWilayahStuntingTertinggi();

        return view('dppkb.dashboard', compact(
            'totalValidasi',
            'totalStunting',
            'persentaseStunting',
            'validasiData',
            'monitoringData',
            'wilayahStuntingTertinggi'
        ));
    }

    public function validasi()
    {
        $dataValidasi = DataStunting::with(['dataPengukuran.anak.orangTua'])
            ->where('status_validasi', 'Pending')
            ->paginate(15);

        return view('dppkb.validasi', compact('dataValidasi'));
    }

    public function validasiDetail($id)
    {
        $data = DataStunting::with(['dataPengukuran.anak.orangTua'])
            ->findOrFail($id);

        $riwayat = DataPengukuran::where('id_anak', $data->dataPengukuran->id_anak)
            ->with('dataStunting')
            ->orderBy('tanggal_ukur', 'desc')
            ->get();

        return view('dppkb.validasi-detail', compact('data', 'riwayat'));
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
            'id_validator' => auth()->id(),
            'tanggal_validasi' => now(),
            'catatan_validasi' => $request->catatan_validasi,
        ]);

        return redirect()->route('dppkb.validasi')
            ->with('success', 'Validasi berhasil disimpan');
    }

    public function monitoring()
    {
        $dataPengukuran = DataPengukuran::with(['anak', 'dataStunting', 'posyandu.puskesmas'])
            ->latest('tanggal_ukur')
            ->paginate(20);

        return view('dppkb.monitoring', compact('dataPengukuran'));
    }

    public function laporan()
    {
        $laporan = \App\Models\Laporan::latest('tanggal_buat')->paginate(15);
        return view('dppkb.laporan', compact('laporan'));
    }

    private function getMonitoringData()
    {
        return 'Grafik Prevalensi Stunting per Kecamatan';
    }

    private function getWilayahStuntingTertinggi()
    {
        return [
            ['kecamatan' => 'Bacukiki', 'kasus' => 45, 'persentase' => '18.5%'],
            ['kecamatan' => 'Andir', 'kasus' => 38, 'persentase' => '16.2%'],
            ['kecamatan' => 'Cakung', 'kasus' => 32, 'persentase' => '15.6%'],
        ];
    }
}