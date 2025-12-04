<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Anak;

class AnakSeeder extends Seeder
{
    public function run(): void
    {
        $anak = [
            // Anak dari Orang Tua 1 (Budi Santoso)
            [
                'id_orangtua' => 1,
                'id_posyandu' => 1, // <-- Menambahkan ID Posyandu
                'nama_anak' => 'Ahmad Fauzi',
                'nik_anak' => '7371010101210001',
                'tanggal_lahir' => '2021-03-15',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Parepare',
                'anak_ke' => 1,
            ],
            [
                'id_orangtua' => 1,
                'id_posyandu' => 1,
                'nama_anak' => 'Fatimah Azzahra',
                'nik_anak' => '7371010101230002',
                'tanggal_lahir' => '2023-06-20',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Parepare',
                'anak_ke' => 2,
            ],
            
            // Anak dari Orang Tua 2 (Siti Aminah)
            [
                'id_orangtua' => 2,
                'id_posyandu' => 2, // <-- Variasi ke Posyandu 2
                'nama_anak' => 'Rina Septiani',
                'nik_anak' => '7371010101220003',
                'tanggal_lahir' => '2022-01-10',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Parepare',
                'anak_ke' => 1,
            ],
            
            // Anak dari Orang Tua 3 (Andi Rahman)
            [
                'id_orangtua' => 3,
                'id_posyandu' => 1,
                'nama_anak' => 'Dimas Pratama',
                'nik_anak' => '7371010101200004',
                'tanggal_lahir' => '2020-08-05',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Parepare',
                'anak_ke' => 1,
            ],
            [
                'id_orangtua' => 3,
                'id_posyandu' => 1,
                'nama_anak' => 'Siti Nurhaliza',
                'nik_anak' => '7371010101220005',
                'tanggal_lahir' => '2022-11-12',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Parepare',
                'anak_ke' => 2,
            ],
            
            // Anak dari Orang Tua 4 (Dewi Lestari)
            [
                'id_orangtua' => 4,
                'id_posyandu' => 2,
                'nama_anak' => 'Budi Setiawan',
                'nik_anak' => '7371010101210006',
                'tanggal_lahir' => '2021-05-25',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Parepare',
                'anak_ke' => 1,
            ],
            
            // Anak dari Orang Tua 5 (Muhammad Ridwan)
            [
                'id_orangtua' => 5,
                'id_posyandu' => 2,
                'nama_anak' => 'Zahra Amelia',
                'nik_anak' => '7371010101230007',
                'tanggal_lahir' => '2023-02-14',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Parepare',
                'anak_ke' => 1,
            ],
            [
                'id_orangtua' => 5,
                'id_posyandu' => 2,
                'nama_anak' => 'Rizky Ramadhan',
                'nik_anak' => '7371010101240008',
                'tanggal_lahir' => '2024-09-30',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Parepare',
                'anak_ke' => 2,
            ],
        ];

        foreach ($anak as $data) {
            Anak::create($data);
        }
    }
}