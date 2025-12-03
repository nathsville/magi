<?php

namespace App\Services;

class ZScoreService
{
    /**
     * Hitung Z-Score menggunakan Python engine
     */
    public static function calculate($jenisKelamin, $umurBulan, $beratBadan, $tinggiBadan)
    {
        // Untuk saat ini, kita gunakan perhitungan sederhana
        // Nanti akan di-integrate dengan Python service
        
        // Standar WHO (simplified)
        $median = self::getMedian($jenisKelamin, $umurBulan);
        $sd = self::getSD($jenisKelamin, $umurBulan);
        
        $zscore_tb_u = ($tinggiBadan - $median['tb']) / $sd['tb'];
        $zscore_bb_u = ($beratBadan - $median['bb']) / $sd['bb'];
        $zscore_bb_tb = 0; // Simplified, perlu tabel WHO lengkap
        
        // Tentukan status stunting berdasarkan Z-Score TB/U
        $status_stunting = self::determineStatus($zscore_tb_u);
        
        return [
            'zscore_tb_u' => round($zscore_tb_u, 2),
            'zscore_bb_u' => round($zscore_bb_u, 2),
            'zscore_bb_tb' => round($zscore_bb_tb, 2),
            'status_stunting' => $status_stunting,
        ];
    }
    
    private static function getMedian($jenisKelamin, $umurBulan)
    {
        // Data median WHO (simplified - perlu data lengkap)
        // Contoh untuk umur 12 bulan
        if ($jenisKelamin === 'L') {
            return ['tb' => 75.7, 'bb' => 9.6];
        } else {
            return ['tb' => 74.0, 'bb' => 9.0];
        }
    }
    
    private static function getSD($jenisKelamin, $umurBulan)
    {
        // Standard Deviation WHO (simplified)
        return ['tb' => 3.0, 'bb' => 1.2];
    }
    
    private static function determineStatus($zscore)
    {
        if ($zscore >= -2) {
            return 'Normal';
        } elseif ($zscore >= -3 && $zscore < -2) {
            return 'Stunting Ringan';
        } elseif ($zscore >= -4 && $zscore < -3) {
            return 'Stunting Sedang';
        } else {
            return 'Stunting Berat';
        }
    }
}