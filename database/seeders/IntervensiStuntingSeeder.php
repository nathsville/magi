<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Anak;
use App\Models\User;
use Carbon\Carbon;

class IntervensiStuntingSeeder extends Seeder
{
    public function run(): void
    {
        // Get anak yang stunting
        $anakStunting = Anak::whereHas('dataPengukuran.dataStunting', function($q) {
            $q->where('status_stunting', '!=', 'Normal');
        })->get();

        // Get petugas
        $petugasList = User::whereIn('role', ['Petugas Posyandu', 'Petugas Puskesmas'])
            ->where('status', 'Aktif')
            ->pluck('id_user')
            ->toArray();

        $jenisIntervensi = ['PMT', 'Suplemen/Vitamin', 'Edukasi Gizi', 'Rujukan RS', 'Konseling', 'Lainnya'];
        $statusList = ['Sedang Berjalan', 'Selesai', 'Perlu Rujukan Lanjutan'];

        $deskripsiTemplate = [
            'PMT' => 'Pemberian makanan tambahan tinggi protein dan kalori',
            'Suplemen/Vitamin' => 'Pemberian suplemen vitamin A dan zat besi',
            'Edukasi Gizi' => 'Edukasi pola makan sehat kepada orang tua',
            'Rujukan RS' => 'Rujukan ke rumah sakit untuk penanganan lanjutan',
            'Konseling' => 'Konseling gizi dan pola asuh kepada orang tua',
            'Lainnya' => 'Program intervensi tambahan sesuai kebutuhan'
        ];

        foreach ($anakStunting as $anak) {
            // Create 1-2 intervensi per anak
            $count = rand(1, 2);
            
            for ($i = 0; $i < $count; $i++) {
                $jenis = $jenisIntervensi[array_rand($jenisIntervensi)];
                $status = $statusList[array_rand($statusList)];
                
                DB::table('intervensi_stunting')->insert([
                    'id_anak' => $anak->id_anak,
                    'jenis_intervensi' => $jenis,
                    'deskripsi' => $deskripsiTemplate[$jenis],
                    'tanggal_pelaksanaan' => Carbon::now()->subDays(rand(1, 90)),
                    'dosis_jumlah' => in_array($jenis, ['PMT', 'Suplemen/Vitamin']) 
                        ? (rand(1, 3) . ' kali sehari') 
                        : null,
                    'id_petugas' => $petugasList[array_rand($petugasList)],
                    'status_tindak_lanjut' => $status,
                    'catatan' => $status === 'Selesai' ? 'Program telah diselesaikan dengan baik' : null,
                    'file_pendukung' => null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}