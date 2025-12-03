<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Posyandu;

class PosyanduSeeder extends Seeder
{
    public function run(): void
    {
        $posyandu = [
            // Posyandu di bawah Puskesmas Lumpue (id: 1)
            [
                'nama_posyandu' => 'Posyandu Melati',
                'id_puskesmas' => 1,
                'alamat' => 'Kelurahan Lumpue',
                'kelurahan' => 'Lumpue',
                'kecamatan' => 'Bacukiki',
                'status' => 'Aktif',
            ],
            [
                'nama_posyandu' => 'Posyandu Mawar',
                'id_puskesmas' => 1,
                'alamat' => 'Kelurahan Galung Maloang',
                'kelurahan' => 'Galung Maloang',
                'kecamatan' => 'Bacukiki',
                'status' => 'Aktif',
            ],
            
            // Posyandu di bawah Puskesmas Lakessi (id: 2)
            [
                'nama_posyandu' => 'Posyandu Anggrek',
                'id_puskesmas' => 2,
                'alamat' => 'Kelurahan Lakessi',
                'kelurahan' => 'Lakessi',
                'kecamatan' => 'Bacukiki Barat',
                'status' => 'Aktif',
            ],
            [
                'nama_posyandu' => 'Posyandu Dahlia',
                'id_puskesmas' => 2,
                'alamat' => 'Kelurahan Bukit Harapan',
                'kelurahan' => 'Bukit Harapan',
                'kecamatan' => 'Bacukiki Barat',
                'status' => 'Aktif',
            ],
            
            // Posyandu di bawah Puskesmas Cempae (id: 3)
            [
                'nama_posyandu' => 'Posyandu Kenanga',
                'id_puskesmas' => 3,
                'alamat' => 'Kelurahan Cempae',
                'kelurahan' => 'Cempae',
                'kecamatan' => 'Soreang',
                'status' => 'Aktif',
            ],
            [
                'nama_posyandu' => 'Posyandu Teratai',
                'id_puskesmas' => 3,
                'alamat' => 'Kelurahan Soreang',
                'kelurahan' => 'Soreang',
                'kecamatan' => 'Soreang',
                'status' => 'Aktif',
            ],
        ];

        foreach ($posyandu as $data) {
            Posyandu::create($data);
        }
    }
}