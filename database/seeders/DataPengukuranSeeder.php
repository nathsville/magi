<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Anak;
use App\Models\Posyandu;
use App\Models\User;
use Carbon\Carbon;

class DataPengukuranSeeder extends Seeder
{
    /**
     * WHO Growth Standards Reference Data (simplified)
     * Based on WHO Child Growth Standards 2006
     */
    private function getWHOStandard($umurBulan, $jenisKelamin)
    {
        // Simplified WHO standards (median values)
        // Format: [Berat Badan (kg), Tinggi Badan (cm), Lingkar Kepala (cm), Lingkar Lengan (cm)]
        
        $standards = [
            'L' => [
                0 => [3.3, 49.9, 34.5, 11.5],
                3 => [6.0, 61.4, 40.5, 14.0],
                6 => [7.9, 67.6, 43.3, 14.5],
                9 => [8.9, 72.0, 45.0, 15.0],
                12 => [9.6, 75.7, 46.1, 15.3],
                18 => [10.9, 82.3, 47.6, 15.8],
                24 => [12.2, 87.8, 48.4, 16.0],
                36 => [14.3, 96.1, 49.6, 16.5],
                48 => [16.3, 103.3, 50.4, 17.0],
                60 => [18.3, 110.0, 51.0, 17.5]
            ],
            'P' => [
                0 => [3.2, 49.1, 33.9, 11.0],
                3 => [5.6, 59.8, 39.5, 13.5],
                6 => [7.3, 65.7, 42.2, 14.0],
                9 => [8.2, 70.1, 43.8, 14.5],
                12 => [8.9, 74.0, 44.9, 14.8],
                18 => [10.2, 80.7, 46.2, 15.3],
                24 => [11.5, 86.4, 47.0, 15.6],
                36 => [13.9, 95.1, 48.1, 16.0],
                48 => [15.9, 102.7, 49.0, 16.5],
                60 => [17.9, 109.4, 49.7, 17.0]
            ]
        ];

        $jk = $jenisKelamin === 'L' ? 'L' : 'P';
        
        // Find closest age group
        $ageGroups = array_keys($standards[$jk]);
        $closestAge = $ageGroups[0];
        
        foreach ($ageGroups as $age) {
            if ($umurBulan >= $age) {
                $closestAge = $age;
            }
        }

        return $standards[$jk][$closestAge];
    }

    /**
     * Generate realistic measurement with variation
     */
    private function generateMeasurement($umurBulan, $jenisKelamin, $statusTarget)
    {
        $standard = $this->getWHOStandard($umurBulan, $jenisKelamin);
        
        // [BB, TB, LK, LL]
        $bb = $standard[0];
        $tb = $standard[1];
        $lk = $standard[2];
        $ll = $standard[3];

        // Add realistic variation based on status target
        switch ($statusTarget) {
            case 'Normal':
                // ±5% variation
                $bb += $bb * (rand(-5, 5) / 100);
                $tb += $tb * (rand(-3, 3) / 100);
                $lk += $lk * (rand(-2, 2) / 100);
                $ll += $ll * (rand(-3, 3) / 100);
                break;
                
            case 'Stunting':
                // Tinggi badan significantly lower (-15% to -20%)
                $tb -= $tb * (rand(15, 20) / 100);
                $bb -= $bb * (rand(10, 15) / 100);
                $lk -= $lk * (rand(5, 8) / 100);
                $ll -= $ll * (rand(8, 12) / 100);
                break;
                
            case 'Wasting':
                // Berat badan significantly lower
                $bb -= $bb * (rand(15, 25) / 100);
                $tb += $tb * (rand(-2, 2) / 100);
                $ll -= $ll * (rand(10, 15) / 100);
                break;
        }

        return [
            'berat_badan' => round($bb, 2),
            'tinggi_badan' => round($tb, 2),
            'lingkar_kepala' => round($lk, 2),
            'lingkar_lengan' => round($ll, 2)
        ];
    }

    public function run(): void
    {
        $anakList = Anak::all();
        
        if ($anakList->isEmpty()) {
            $this->command->warn('No Anak data found. Please run AnakSeeder first.');
            return;
        }

        // Get petugas posyandu
        $petugasList = User::where('role', 'Petugas Posyandu')
            ->where('status', 'Aktif')
            ->pluck('id_user')
            ->toArray();

        if (empty($petugasList)) {
            $this->command->warn('No Petugas Posyandu found.');
            return;
        }

        $pengukuranData = [];
        $counter = 1;

        foreach ($anakList as $anak) {
            // Determine status target distribution
            // 70% Normal, 20% Stunting, 10% Wasting
            $rand = rand(1, 100);
            if ($rand <= 70) {
                $statusTarget = 'Normal';
                $measurementCount = rand(3, 6); // 3-6 measurements
            } elseif ($rand <= 90) {
                $statusTarget = 'Stunting';
                $measurementCount = rand(4, 8); // More monitoring for stunting
            } else {
                $statusTarget = 'Wasting';
                $measurementCount = rand(3, 5);
            }

            // Get anak's current age
            $currentAge = Carbon::parse($anak->tanggal_lahir)->diffInMonths(now());
            
            // Create measurements over time (retroactive)
            for ($i = 0; $i < $measurementCount; $i++) {
                // Calculate measurement date (going back in time)
                $monthsAgo = $measurementCount - $i - 1;
                $tanggalUkur = Carbon::now()->subMonths($monthsAgo);
                $umurBulan = max(0, $currentAge - $monthsAgo);

                // Skip if age would be negative
                if ($umurBulan < 0) continue;

                // Generate measurement
                $measurement = $this->generateMeasurement($umurBulan, $anak->jenis_kelamin, $statusTarget);

                // Determine cara_ukur based on age
                $caraUkur = $umurBulan < 24 ? 'Berbaring' : 'Berdiri';

                $pengukuranData[] = [
                    'id_pengukuran' => $counter++,
                    'id_anak' => $anak->id_anak,
                    'id_posyandu' => $anak->id_posyandu,
                    'id_petugas' => $petugasList[array_rand($petugasList)],
                    'tanggal_ukur' => $tanggalUkur->format('Y-m-d'),
                    'umur_bulan' => $umurBulan,
                    'berat_badan' => $measurement['berat_badan'],
                    'tinggi_badan' => $measurement['tinggi_badan'],
                    'cara_ukur' => $caraUkur,
                    'lingkar_kepala' => $measurement['lingkar_kepala'],
                    'lingkar_lengan' => $measurement['lingkar_lengan'],
                    'status_gizi' => null, // Will be calculated by Z-Score engine
                    'catatan' => null,
                    'created_at' => $tanggalUkur,
                    'updated_at' => $tanggalUkur
                ];

                // Insert in batches of 100
                if (count($pengukuranData) >= 100) {
                    DB::table('data_pengukuran')->insert($pengukuranData);
                    $pengukuranData = [];
                }
            }
        }

        // Insert remaining data
        if (!empty($pengukuranData)) {
            DB::table('data_pengukuran')->insert($pengukuranData);
        }

        $totalRecords = DB::table('data_pengukuran')->count();
        $this->command->info("✅ Created {$totalRecords} Data Pengukuran records");
    }
}