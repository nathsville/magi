<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataMaster;

class DataMasterSeeder extends Seeder
{
    public function run(): void
    {
        $dataMaster = [
            // Kriteria Stunting
            [
                'tipe_data' => 'Kriteria Stunting',
                'kode' => 'NORMAL',
                'nilai' => 'Normal',
                'deskripsi' => 'Z-Score >= -2 SD',
                'status' => 'Aktif',
            ],
            [
                'tipe_data' => 'Kriteria Stunting',
                'kode' => 'STUNTING_RINGAN',
                'nilai' => 'Stunting Ringan',
                'deskripsi' => 'Z-Score -3 SD sampai < -2 SD',
                'status' => 'Aktif',
            ],
            [
                'tipe_data' => 'Kriteria Stunting',
                'kode' => 'STUNTING_SEDANG',
                'nilai' => 'Stunting Sedang',
                'deskripsi' => 'Z-Score -4 SD sampai < -3 SD',
                'status' => 'Aktif',
            ],
            [
                'tipe_data' => 'Kriteria Stunting',
                'kode' => 'STUNTING_BERAT',
                'nilai' => 'Stunting Berat',
                'deskripsi' => 'Z-Score < -4 SD',
                'status' => 'Aktif',
            ],
            
            // Status Gizi
            [
                'tipe_data' => 'Status Gizi',
                'kode' => 'GIZI_BURUK',
                'nilai' => 'Gizi Buruk',
                'deskripsi' => 'Status gizi buruk',
                'status' => 'Aktif',
            ],
            [
                'tipe_data' => 'Status Gizi',
                'kode' => 'GIZI_KURANG',
                'nilai' => 'Gizi Kurang',
                'deskripsi' => 'Status gizi kurang',
                'status' => 'Aktif',
            ],
            [
                'tipe_data' => 'Status Gizi',
                'kode' => 'GIZI_BAIK',
                'nilai' => 'Gizi Baik',
                'deskripsi' => 'Status gizi baik',
                'status' => 'Aktif',
            ],
            [
                'tipe_data' => 'Status Gizi',
                'kode' => 'GIZI_LEBIH',
                'nilai' => 'Gizi Lebih',
                'deskripsi' => 'Status gizi lebih',
                'status' => 'Aktif',
            ],
            
            // Jenis Laporan
            [
                'tipe_data' => 'Jenis Laporan',
                'kode' => 'BULANAN',
                'nilai' => 'Laporan Bulanan',
                'deskripsi' => 'Laporan periode bulanan',
                'status' => 'Aktif',
            ],
            [
                'tipe_data' => 'Jenis Laporan',
                'kode' => 'TRIWULAN',
                'nilai' => 'Laporan Triwulan',
                'deskripsi' => 'Laporan periode 3 bulan',
                'status' => 'Aktif',
            ],
            [
                'tipe_data' => 'Jenis Laporan',
                'kode' => 'TAHUNAN',
                'nilai' => 'Laporan Tahunan',
                'deskripsi' => 'Laporan periode tahunan',
                'status' => 'Aktif',
            ],
        ];

        foreach ($dataMaster as $data) {
            DataMaster::create($data);
        }
    }
}