<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WhoStandard;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class WhoStandardSeeder extends Seeder
{
    public function run(): void
    {
        // Path ke folder CSV
        $path = storage_path('app/who_standards');
        
        // 1. Cek Folder
        if (!File::isDirectory($path)) {
            $this->command->error("❌ Folder tidak ditemukan: $path");
            $this->command->info("   Pastikan Anda telah membuat folder 'storage/app/who_standards' dan memasukkan file CSV.");
            return;
        }
        
        $files = File::files($path);
        
        // 2. Cek Isi Folder
        if (empty($files)) {
            $this->command->error("❌ Folder ditemukan tapi KOSONG: $path");
            return;
        }
        
        $this->command->info("🚀 Memulai proses di folder: $path");
        $this->command->info("🔍 Jumlah file dalam folder: " . count($files));

        // 3. Bersihkan data lama
        $this->command->info("🗑️  Mengosongkan tabel who_standards...");
        WhoStandard::truncate();
        
        DB::beginTransaction();
        
        try {
            $totalImported = 0;
            $processedFiles = 0;
            
            foreach ($files as $file) {
                $filename = $file->getFilename();
                
                // DEBUG: Tampilkan setiap file yang ditemukan
                // Gunakan strtolower agar tidak masalah dengan .CSV atau .csv
                if (strtolower($file->getExtension()) !== 'csv') {
                    $this->command->warn("⚠️  SKIP (Bukan CSV): $filename");
                    continue;
                }
                
                $this->command->info("📄 Processing: $filename");
                
                $handle = fopen($file->getRealPath(), 'r');
                fgetcsv($handle); // Skip header
                
                // Deteksi Gender & Tipe
                $gender = $this->determineGender($filename);
                $type = $this->determineType($filename);
                
                if (!$gender || !$type) {
                    $this->command->warn("   ⚠️  SKIP (Format nama tidak dikenali): $filename");
                    fclose($handle);
                    continue;
                }
                
                $batchData = [];
                $rowCount = 0;
                
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    // Validasi kolom minimal
                    if (count($data) < 4) continue;
                    
                    $batchData[] = [
                        'gender' => $gender,
                        'type' => $type,
                        'measure_value' => (float) $data[0],
                        'l' => (float) $data[1],
                        'm' => (float) $data[2],
                        's' => (float) $data[3],
                    ];
                    
                    $rowCount++;
                    
                    // Batch insert per 500 baris
                    if (count($batchData) >= 500) {
                        WhoStandard::insert($batchData);
                        $batchData = [];
                    }
                }
                
                // Insert sisa data
                if (!empty($batchData)) {
                    WhoStandard::insert($batchData);
                }
                
                fclose($handle);
                $totalImported += $rowCount;
                $processedFiles++;
                $this->command->info("   ✅ OK: $rowCount data");
            }
            
            DB::commit();
            
            $this->command->newLine();
            if ($processedFiles === 0) {
                $this->command->error("❌ TIDAK ADA FILE YANG BERHASIL DIPROSES.");
                $this->command->warn("👉 Cek kembali nama file CSV Anda.");
            } else {
                $this->command->info("✅ SUCCESS! Total imported: $totalImported rows from $processedFiles files.");
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("❌ ERROR EXCEPTION: " . $e->getMessage());
        }
    }
    
    private function determineGender(string $filename): ?string
    {
        $name = strtolower($filename);
        if (str_contains($name, 'boys')) return 'L';
        if (str_contains($name, 'girls')) return 'P';
        return null;
    }
    
    private function determineType(string $filename): ?string
    {
        $name = strtolower($filename);
        if (str_starts_with($name, 'wfa')) return 'bbu';
        if (str_starts_with($name, 'lhfa')) return 'tbu';
        if (str_starts_with($name, 'wfl')) return 'wfl';
        if (str_starts_with($name, 'wfh')) return 'wfh';
        return null;
    }
}