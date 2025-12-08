<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\DataPengukuran;
use App\Models\User;
use Carbon\Carbon;

class DataStuntingSeeder extends Seeder
{
    /**
     * Simplified Z-Score calculation
     * Real implementation should use WHO LMS tables
     */
    private function calculateZScore($measurement, $umurBulan, $jenisKelamin)
    {
        // Simplified Z-Score formula: Z = (X - M) / SD
        // Using approximate values for demonstration
        
        $bb = $measurement->berat_badan;
        $tb = $measurement->tinggi_badan;
        
        // Approximate WHO medians and SD for demonstration
        // In production, use actual WHO LMS tables
        $medianBB = $jenisKelamin === 'L' ? (3.3 + ($umurBulan * 0.3)) : (3.2 + ($umurBulan * 0.28));
        $medianTB = $jenisKelamin === 'L' ? (49.9 + ($umurBulan * 1.2)) : (49.1 + ($umurBulan * 1.15));
        
        $sdBB = 1.5;
        $sdTB = 3.5;
        
        // Calculate Z-Scores
        $zScoreBBU = ($bb - $medianBB) / $sdBB;
        $zScoreTBU = ($tb - $medianTB) / $sdTB;
        
        // WHZ (Weight-for-Height) - simplified
        $expectedBB = ($tb / 100) * ($tb / 100) * 22; // Simplified BMI-based
        $zScoreBBTB = ($bb - $expectedBB) / ($expectedBB * 0.15);
        
        return [
            'zscore_bb_u' => round($zScoreBBU, 2),
            'zscore_tb_u' => round($zScoreTBU, 2),
            'zscore_bb_tb' => round($zScoreBBTB, 2)
        ];
    }

    /**
     * Determine stunting status based on Z-Score
     */
    private function determineStatus($zScores)
    {
        $tbU = $zScores['zscore_tb_u'];
        
        // WHO Classification
        if ($tbU >= -2) {
            return 'Normal';
        } elseif ($tbU >= -3 && $tbU < -2) {
            return 'Stunting Ringan';
        } elseif ($tbU >= -4 && $tbU < -3) {
            return 'Stunting Sedang';
        } else {
            return 'Stunting Berat';
        }
    }

    public function run(): void
    {
        $pengukuranList = DataPengukuran::with('anak')->get();
        
        if ($pengukuranList->isEmpty()) {
            $this->command->warn('No Data Pengukuran found. Please run DataPengukuranSeeder first.');
            return;
        }

        // Get validators (Petugas Puskesmas & DPPKB)
        $validatorList = User::whereIn('role', ['Petugas Puskesmas', 'Petugas DPPKB'])
            ->where('status', 'Aktif')
            ->pluck('id_user')
            ->toArray();

        if (empty($validatorList)) {
            $this->command->warn('No validators found.');
            return;
        }

        $stuntingData = [];
        $counter = 1;

        foreach ($pengukuranList as $pengukuran) {
            $anak = $pengukuran->anak;
            
            // Calculate Z-Scores
            $zScores = $this->calculateZScore(
                $pengukuran, 
                $pengukuran->umur_bulan, 
                $anak->jenis_kelamin
            );

            // Determine status
            $status = $this->determineStatus($zScores);

            // Determine validation status
            // 80% Validated, 15% Pending, 5% Rejected
            $rand = rand(1, 100);
            if ($rand <= 80) {
                $statusValidasi = 'Validated';
                $validator = $validatorList[array_rand($validatorList)];
                $tanggalValidasi = Carbon::parse($pengukuran->tanggal_ukur)->addDays(rand(1, 7));
                $catatanValidasi = $status !== 'Normal' 
                    ? 'Data telah diverifikasi dan memerlukan program intervensi' 
                    : 'Data valid, pertumbuhan normal';
            } elseif ($rand <= 95) {
                $statusValidasi = 'Pending';
                $validator = null;
                $tanggalValidasi = null;
                $catatanValidasi = null;
            } else {
                $statusValidasi = 'Rejected';
                $validator = $validatorList[array_rand($validatorList)];
                $tanggalValidasi = Carbon::parse($pengukuran->tanggal_ukur)->addDays(rand(1, 3));
                $catatanValidasi = 'Data tidak wajar, perlu pengukuran ulang';
            }

            $stuntingData[] = [
                'id_stunting' => $counter++,
                'id_pengukuran' => $pengukuran->id_pengukuran,
                'status_stunting' => $status,
                'zscore_tb_u' => $zScores['zscore_tb_u'],
                'zscore_bb_u' => $zScores['zscore_bb_u'],
                'zscore_bb_tb' => $zScores['zscore_bb_tb'],
                'status_validasi' => $statusValidasi,
                'id_validator' => $validator,
                'tanggal_validasi' => $tanggalValidasi,
                'catatan_validasi' => $catatanValidasi,
                'created_at' => $pengukuran->tanggal_ukur,
                'updated_at' => $tanggalValidasi ?? $pengukuran->tanggal_ukur
            ];

            // Batch insert
            if (count($stuntingData) >= 100) {
                DB::table('data_stunting')->insert($stuntingData);
                $stuntingData = [];
            }
        }

        // Insert remaining
        if (!empty($stuntingData)) {
            DB::table('data_stunting')->insert($stuntingData);
        }

        // Statistics
        $totalRecords = DB::table('data_stunting')->count();
        $normalCount = DB::table('data_stunting')->where('status_stunting', 'Normal')->count();
        $stuntingCount = DB::table('data_stunting')->where('status_stunting', '!=', 'Normal')->count();
        $pendingCount = DB::table('data_stunting')->where('status_validasi', 'Pending')->count();

        $this->command->info("✅ Created {$totalRecords} Data Stunting records");
        $this->command->info("   - Normal: {$normalCount}");
        $this->command->info("   - Stunting: {$stuntingCount}");
        $this->command->info("   - Pending Validation: {$pendingCount}");
    }
}