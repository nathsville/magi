<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Puskesmas;

class PuskesmasSeeder extends Seeder
{
    public function run(): void
    {
        $puskesmas = [
            [
                'nama_puskesmas' => 'Puskesmas Lumpue',
                'alamat' => 'Jl. Jend. Sudirman No. 1, Parepare',
                'kecamatan' => 'Bacukiki',
                'kabupaten' => 'Parepare',
                'no_telepon' => '0421-21234',
                'status' => 'Aktif',
            ],
            [
                'nama_puskesmas' => 'Puskesmas Lakessi',
                'alamat' => 'Jl. Bau Massepe No. 5, Parepare',
                'kecamatan' => 'Bacukiki Barat',
                'kabupaten' => 'Parepare',
                'no_telepon' => '0421-21235',
                'status' => 'Aktif',
            ],
            [
                'nama_puskesmas' => 'Puskesmas Cempae',
                'alamat' => 'Jl. Andi Makkasau No. 10, Parepare',
                'kecamatan' => 'Soreang',
                'kabupaten' => 'Parepare',
                'no_telepon' => '0421-21236',
                'status' => 'Aktif',
            ],
        ];

        foreach ($puskesmas as $data) {
            Puskesmas::create($data);
        }
    }
}