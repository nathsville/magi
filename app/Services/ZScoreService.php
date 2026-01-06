<?php

namespace App\Services;

use App\Models\WhoStandard;
use Illuminate\Support\Facades\Cache;

/**
 * Service untuk perhitungan Z-Score berdasarkan Standar WHO
 * Menggunakan metode LMS (Lambda-Mu-Sigma) dengan Interpolasi Linear
 * 
 * Referensi:
 * - WHO Child Growth Standards (2006)
 * - WHO Anthro Software Documentation
 * - Permenkes No. 2 Tahun 2020 (Standar Antropometri Anak)
 */
class ZScoreService
{
    /**
     * Hitung semua indikator Z-Score untuk seorang anak
     * 
     * @param string $jenisKelamin 'L' atau 'P' (atau 'Laki-laki'/'Perempuan')
     * @param int $umurBulan Umur dalam bulan (0-60)
     * @param float $beratBadan Berat badan dalam kg
     * @param float $tinggiBadan Tinggi/panjang badan dalam cm
     * @return array [zscore_tb_u, zscore_bb_u, zscore_bb_tb, status_stunting, status_berat_badan, status_gizi]
     */
    public static function calculate($jenisKelamin, $umurBulan, $beratBadan, $tinggiBadan)
    {
        // Normalisasi jenis kelamin
        $gender = self::normalizeGender($jenisKelamin);
        
        // 1. BB/U - Berat Badan menurut Umur (Weight-for-Age)
        // Indikator: Berat Badan Kurang / Underweight
        $zscore_bb_u = self::calculateIndicator($gender, 'bbu', $umurBulan, $beratBadan);
        
        // 2. TB/U - Tinggi Badan menurut Umur (Length/Height-for-Age)
        // Indikator: STUNTING (Pendek/Sangat Pendek)
        $zscore_tb_u = self::calculateIndicator($gender, 'tbu', $umurBulan, $tinggiBadan);
        
        // 3. BB/TB - Berat Badan menurut Tinggi Badan (Weight-for-Length/Height)
        // Indikator: Gizi Buruk/Kurang (Wasting) atau Obesitas
        // Catatan: Gunakan WFL untuk <24 bulan, WFH untuk >=24 bulan
        $type_bbtb = ($umurBulan < 24) ? 'wfl' : 'wfh';
        $zscore_bb_tb = self::calculateIndicator($gender, $type_bbtb, $tinggiBadan, $beratBadan);
        
        return [
            'zscore_tb_u' => round($zscore_tb_u, 2),
            'zscore_bb_u' => round($zscore_bb_u, 2),
            'zscore_bb_tb' => round($zscore_bb_tb, 2),
            'status_stunting' => self::determineStatusTB_U($zscore_tb_u),
            'status_berat_badan' => self::determineStatusBB_U($zscore_bb_u),
            'status_gizi' => self::determineStatusBB_TB($zscore_bb_tb),
        ];
    }
    
    /**
     * Perhitungan Z-Score menggunakan Metode LMS
     * 
     * Formula: Z = ((X/M)^L - 1) / (L * S)
     * Jika L ≈ 0, gunakan: Z = ln(X/M) / S
     * 
     * @param string $gender 'L' atau 'P'
     * @param string $type 'bbu', 'tbu', 'wfl', atau 'wfh'
     * @param float $measureValue Umur (bulan) atau Tinggi (cm)
     * @param float $observedValue Nilai yang diamati (BB atau TB)
     * @return float Z-Score
     */
    private static function calculateIndicator($gender, $type, $measureValue, $observedValue)
    {
        // Ambil parameter LMS dari database (dengan interpolasi jika perlu)
        $lms = self::getLMSFromDB($gender, $type, $measureValue);
        
        if (!$lms) {
            // Data di luar range tabel WHO (sangat ekstrim)
            return 0;
        }
        
        $L = $lms['l'];
        $M = $lms['m'];
        $S = $lms['s'];
        
        // Validasi nilai observasi tidak boleh 0 atau negatif
        if ($observedValue <= 0) {
            return 0;
        }
        
        // Implementasi rumus LMS
        if (abs($L) < 0.01) {
            // Jika L mendekati nol, gunakan formula logaritma
            $zscore = log($observedValue / $M) / $S;
        } else {
            // Formula LMS standar
            $zscore = (pow(($observedValue / $M), $L) - 1) / ($L * $S);
        }
        
        return $zscore;
    }
    
    /**
     * Ambil nilai L, M, S dari database dengan INTERPOLASI LINEAR
     * 
     * Interpolasi diperlukan karena:
     * - Data tinggi badan bisa bernilai desimal (misal: 85.3 cm)
     * - Tabel WHO hanya menyediakan nilai bulat atau interval tertentu
     * 
     * @param string $gender
     * @param string $type
     * @param float $value
     * @return array|null ['l' => float, 'm' => float, 's' => float]
     */
    private static function getLMSFromDB($gender, $type, $value)
    {
        // Cache key untuk performa (opsional, tapi sangat direkomendasikan)
        $cacheKey = "who_lms_{$gender}_{$type}_{$value}";
        
        return Cache::remember($cacheKey, 3600, function () use ($gender, $type, $value) {
            
            // Cek apakah ada nilai EXACT (pas persis)
            $exact = WhoStandard::where('gender', $gender)
                ->where('type', $type)
                ->where('measure_value', $value)
                ->first();
            
            if ($exact) {
                return [
                    'l' => $exact->l,
                    'm' => $exact->m,
                    's' => $exact->s
                ];
            }
            
            // Jika tidak ada yang exact match, lakukan INTERPOLASI
            
            // Ambil batas BAWAH (nilai terbesar yang <= target)
            $lower = WhoStandard::where('gender', $gender)
                ->where('type', $type)
                ->where('measure_value', '<=', $value)
                ->orderBy('measure_value', 'desc')
                ->first();
            
            // Ambil batas ATAS (nilai terkecil yang >= target)
            $upper = WhoStandard::where('gender', $gender)
                ->where('type', $type)
                ->where('measure_value', '>=', $value)
                ->orderBy('measure_value', 'asc')
                ->first();
            
            // Kasus ekstrim: Nilai di luar range tabel
            if (!$lower && !$upper) {
                return null; // Tidak ada data sama sekali
            }
            
            if (!$lower) {
                // Nilai terlalu kecil, gunakan batas bawah tabel
                return [
                    'l' => $upper->l,
                    'm' => $upper->m,
                    's' => $upper->s
                ];
            }
            
            if (!$upper) {
                // Nilai terlalu besar, gunakan batas atas tabel
                return [
                    'l' => $lower->l,
                    'm' => $lower->m,
                    's' => $lower->s
                ];
            }
            
            // INTERPOLASI LINEAR
            // Formula: Y = Y1 + (X - X1) * ((Y2 - Y1) / (X2 - X1))
            
            $fraction = ($value - $lower->measure_value) / 
                        ($upper->measure_value - $lower->measure_value);
            
            $l = $lower->l + $fraction * ($upper->l - $lower->l);
            $m = $lower->m + $fraction * ($upper->m - $lower->m);
            $s = $lower->s + $fraction * ($upper->s - $lower->s);
            
            return [
                'l' => $l,
                'm' => $m,
                's' => $s
            ];
        });
    }
    
    /**
     * Normalisasi input jenis kelamin
     */
    private static function normalizeGender($jenisKelamin): string
    {
        $jk = strtoupper(trim($jenisKelamin));
        
        if (in_array($jk, ['L', 'LAKI-LAKI', 'MALE', 'M', 'BOY'])) {
            return 'L';
        }
        
        if (in_array($jk, ['P', 'PEREMPUAN', 'FEMALE', 'F', 'GIRL'])) {
            return 'P';
        }
        
        // Default fallback
        return 'L';
    }
    
    // ========================================================================
    // STATUS DETERMINATION - Berdasarkan Permenkes No. 2 Tahun 2020
    // ========================================================================
    
    /**
     * Tentukan status TB/U (Stunting)
     * 
     * Kategori:
     * - Sangat Pendek: Z-Score < -3 SD
     * - Pendek: -3 SD <= Z-Score < -2 SD
     * - Normal: -2 SD <= Z-Score <= +3 SD
     * - Tinggi: Z-Score > +3 SD
     */
    private static function determineStatusTB_U($zscore): string
    {
        if ($zscore < -3) {
            return 'Sangat Pendek (Severely Stunted)';
        }
        
        if ($zscore < -2) {
            return 'Pendek (Stunted)';
        }
        
        if ($zscore > 3) {
            return 'Tinggi';
        }
        
        return 'Normal';
    }
    
    /**
     * Tentukan status BB/U (Berat Badan)
     * 
     * Kategori:
     * - Berat Badan Sangat Kurang: Z-Score < -3 SD
     * - Berat Badan Kurang: -3 SD <= Z-Score < -2 SD
     * - Berat Badan Normal: -2 SD <= Z-Score <= +1 SD
     * - Risiko Berat Badan Lebih: Z-Score > +1 SD
     */
    private static function determineStatusBB_U($zscore): string
    {
        if ($zscore < -3) {
            return 'Berat Badan Sangat Kurang';
        }
        
        if ($zscore < -2) {
            return 'Berat Badan Kurang';
        }
        
        if ($zscore > 1) {
            return 'Risiko Berat Badan Lebih';
        }
        
        return 'Berat Badan Normal';
    }
    
    /**
     * Tentukan status BB/TB (Status Gizi)
     * 
     * Kategori:
     * - Gizi Buruk (Severely Wasted): Z-Score < -3 SD
     * - Gizi Kurang (Wasted): -3 SD <= Z-Score < -2 SD
     * - Gizi Baik (Normal): -2 SD <= Z-Score <= +1 SD
     * - Berisiko Gizi Lebih: +1 SD < Z-Score <= +2 SD
     * - Gizi Lebih (Overweight): +2 SD < Z-Score <= +3 SD
     * - Obesitas: Z-Score > +3 SD
     */
    private static function determineStatusBB_TB($zscore): string
    {
        if ($zscore < -3) {
            return 'Gizi Buruk (Severely Wasted)';
        }
        
        if ($zscore < -2) {
            return 'Gizi Kurang (Wasted)';
        }
        
        if ($zscore > 3) {
            return 'Obesitas';
        }
        
        if ($zscore > 2) {
            return 'Gizi Lebih (Overweight)';
        }
        
        if ($zscore > 1) {
            return 'Berisiko Gizi Lebih';
        }
        
        return 'Gizi Baik (Normal)';
    }
    
    /**
     * Helper: Clear cache untuk testing
     */
    public static function clearCache(): void
    {
        Cache::flush();
    }
}