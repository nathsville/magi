<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Core Data
            UserSeeder::class,
            PuskesmasSeeder::class,
            PosyanduSeeder::class,
            DataMasterSeeder::class,
            
            // Anak & Orang Tua
            // OrangTuaSeeder::class,
            AnakSeeder::class,
            
            // Pengukuran & Stunting
            DataPengukuranSeeder::class,
            DataStuntingSeeder::class,
            
            // Intervensi (NEW)
            IntervensiStuntingSeeder::class,
            
            // Supporting Data
            NotifikasiSeeder::class,
            LaporanSeeder::class,
        ]);
    }
}