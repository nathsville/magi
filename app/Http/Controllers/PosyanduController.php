<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anak;
use App\Models\DataPengukuran;
use App\Models\DataStunting;
use App\Models\OrangTua;
use App\Services\ZScoreService;
use Illuminate\Support\Facades\Auth;

class PosyanduController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Statistik
        $totalAnak = Anak::whereHas('dataPengukuran', function($query) use ($user) {
            // Filter berdasarkan posyandu petugas jika ada
        })->count();
        
        $totalStunting = DataStunting::whereIn('status_stunting', ['Stunting Ringan', 'Stunting Sedang', 'Stunting Berat'])
            ->count();
        
        $persentaseStunting = $totalAnak > 0 ? round(($totalStunting / $totalAnak) * 100, 2) : 0;
        
        $pengukuranBulanIni = DataPengukuran::whereMonth('tanggal_ukur', date('m'))
            ->whereYear('tanggal_ukur', date('Y'))
            ->count();

        // Data pengukuran terbaru
        $pengukuranTerbaru = DataPengukuran::with(['anak', 'dataStunting'])
            ->latest('tanggal_ukur')
            ->take(5)
            ->get();

        // Anak yang perlu perhatian
        $anakPerluPerhatian = Anak::whereHas('dataPengukuran.dataStunting', function($query) {
            $query->whereIn('status_stunting', ['Stunting Ringan', 'Stunting Sedang', 'Stunting Berat']);
        })->take(5)->get();

        return view('posyandu.dashboard', compact(
            'totalAnak',
            'totalStunting',
            'persentaseStunting',
            'pengukuranBulanIni',
            'pengukuranTerbaru',
            'anakPerluPerhatian'
        ));
    }

    public function inputData()
    {
        $anak = Anak::with('orangTua')->get();
        return view('posyandu.input-data', compact('anak'));
    }

    public function storeData(Request $request)
    {
        $request->validate([
            'id_anak' => 'required|exists:anak,id_anak',
            'tanggal_ukur' => 'required|date',
            'berat_badan' => 'required|numeric|min:2|max:30',
            'tinggi_badan' => 'required|numeric|min:45|max:120',
            'lingkar_kepala' => 'required|numeric|min:30|max:60',
            'lingkar_lengan' => 'required|numeric|min:10|max:30',
            'catatan' => 'nullable',
        ]);

        $anak = Anak::findOrFail($request->id_anak);
        
        // Hitung umur dalam bulan
        $umurBulan = \Carbon\Carbon::parse($anak->tanggal_lahir)
            ->diffInMonths($request->tanggal_ukur);

        // Simpan data pengukuran
        $pengukuran = DataPengukuran::create([
            'id_anak' => $request->id_anak,
            'id_posyandu' => 1, // Nanti disesuaikan dengan posyandu petugas
            'id_petugas' => Auth::id(),
            'tanggal_ukur' => $request->tanggal_ukur,
            'umur_bulan' => $umurBulan,
            'berat_badan' => $request->berat_badan,
            'tinggi_badan' => $request->tinggi_badan,
            'lingkar_kepala' => $request->lingkar_kepala,
            'lingkar_lengan' => $request->lingkar_lengan,
            'catatan' => $request->catatan,
        ]);

        // Hitung Z-Score (simplified - nanti diganti dengan service Python)
        $zscoreResult = ZScoreService::calculate(
            $anak->jenis_kelamin,
            $umurBulan,
            $request->berat_badan,
            $request->tinggi_badan
        );

        // Simpan data stunting
        DataStunting::create([
            'id_pengukuran' => $pengukuran->id_pengukuran,
            'status_stunting' => $zscoreResult['status_stunting'],
            'zscore_tb_u' => $zscoreResult['zscore_tb_u'],
            'zscore_bb_u' => $zscoreResult['zscore_bb_u'],
            'zscore_bb_tb' => $zscoreResult['zscore_bb_tb'],
            'status_validasi' => 'Pending',
        ]);

        return redirect()->route('posyandu.dashboard')
            ->with('success', 'Data pengukuran berhasil disimpan');
    }

    public function dataAnak()
    {
        $anak = Anak::with(['orangTua', 'dataPengukuran'])->paginate(15);
        return view('posyandu.data-anak', compact('anak'));
    }

    public function monitoring()
    {
        $dataPengukuran = DataPengukuran::with(['anak', 'dataStunting'])
            ->latest('tanggal_ukur')
            ->paginate(20);

        return view('posyandu.monitoring', compact('dataPengukuran'));
    }
}