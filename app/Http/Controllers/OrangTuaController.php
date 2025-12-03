<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anak;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class OrangTuaController extends Controller
{
    public function dashboard()
    {
        $orangTua = Auth::user()->orangTua;
        
        if (!$orangTua) {
            return redirect()->route('login')->with('error', 'Profil orang tua tidak ditemukan');
        }

        $anak = $orangTua->anak;
        
        // Notifikasi stunting
        $notifikasiStunting = Notifikasi::where('id_user', Auth::id())
            ->where('tipe_notifikasi', 'Peringatan')
            ->latest()
            ->take(3)
            ->get();

        // Tips kesehatan
        $tipsKesehatan = $this->getTipsKesehatan();

        return view('orangtua.dashboard', compact('anak', 'notifikasiStunting', 'tipsKesehatan'));
    }

    public function dataAnak()
    {
        $orangTua = Auth::user()->orangTua;
        $anak = $orangTua->anak;

        return view('orangtua.data-anak', compact('anak'));
    }

    public function dataAnakDetail($id)
    {
        $anak = Anak::with(['dataPengukuran.dataStunting'])
            ->where('id_orangtua', Auth::user()->orangTua->id_orangtua)
            ->findOrFail($id);

        $riwayatPengukuran = $anak->dataPengukuran()
            ->with('dataStunting')
            ->orderBy('tanggal_ukur', 'desc')
            ->get();

        return view('orangtua.data-anak-detail', compact('anak', 'riwayatPengukuran'));
    }

    public function notifikasi()
    {
        $notifikasi = Notifikasi::where('id_user', Auth::id())
            ->latest('tanggal_kirim')
            ->paginate(15);

        // Mark all as read
        Notifikasi::where('id_user', Auth::id())
            ->where('status_baca', 'Belum Dibaca')
            ->update(['status_baca' => 'Sudah Dibaca']);

        return view('orangtua.notifikasi', compact('notifikasi'));
    }

    public function riwayat()
    {
        $orangTua = Auth::user()->orangTua;
        $riwayat = \App\Models\DataPengukuran::whereHas('anak', function($query) use ($orangTua) {
            $query->where('id_orangtua', $orangTua->id_orangtua);
        })
        ->with(['anak', 'dataStunting'])
        ->latest('tanggal_ukur')
        ->paginate(20);

        return view('orangtua.riwayat', compact('riwayat'));
    }

    private function getTipsKesehatan()
    {
        return [
            [
                'judul' => 'Pola Makan Seimbang',
                'isi' => 'Pastikan anak mendapat asupan gizi seimbang dengan variasi makanan.',
            ],
            [
                'judul' => 'Stimulasi Tumbuh Kembang',
                'isi' => 'Lakukan stimulasi sesuai usia untuk mendukung pertumbuhan anak.',
            ],
        ];
    }
}