<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Puskesmas;
use App\Models\User;
use Carbon\Carbon;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        $puskesmas = Puskesmas::where('status', 'Aktif')->first();
        
        if (!$puskesmas) {
            $this->command->warn('No Puskesmas found.');
            return;
        }

        // Get pembuat laporan (Petugas Puskesmas & DPPKB)
        $pembuatList = User::whereIn('role', ['Petugas Puskesmas', 'Petugas DPPKB'])
            ->where('status', 'Aktif')
            ->pluck('id_user')
            ->toArray();

        if (empty($pembuatList)) {
            $this->command->warn('No report creators found.');
            return;
        }

        $laporanData = [];
        $counter = 1;

        // Generate reports for last 12 months
        for ($i = 0; $i < 12; $i++) {
            $periodeBulan = Carbon::now()->subMonths($i)->month;
            $periodeTahun = Carbon::now()->subMonths($i)->year;
            $tanggalBuat = Carbon::create($periodeTahun, $periodeBulan, 1)->addDays(rand(25, 28));

            // Get stats for this period
            $startDate = Carbon::create($periodeTahun, $periodeBulan, 1);
            $endDate = $startDate->copy()->endOfMonth();

            // Query actual data
            $totalAnak = DB::table('data_pengukuran')
                ->whereBetween('tanggal_ukur', [$startDate, $endDate])
                ->distinct('id_anak')
                ->count('id_anak');

            $totalStunting = DB::table('data_stunting')
                ->join('data_pengukuran', 'data_stunting.id_pengukuran', '=', 'data_pengukuran.id_pengukuran')
                ->whereBetween('data_pengukuran.tanggal_ukur', [$startDate, $endDate])
                ->where('data_stunting.status_stunting', '!=', 'Normal')
                ->count();

            $totalNormal = $totalAnak - $totalStunting;
            $persentaseStunting = $totalAnak > 0 ? round(($totalStunting / $totalAnak) * 100, 2) : 0;

            // Laporan Puskesmas
            $laporanData[] = [
                'id_laporan' => $counter++,
                'jenis_laporan' => 'Laporan Puskesmas',
                'id_pembuat' => $pembuatList[array_rand($pembuatList)],
                'periode_bulan' => $periodeBulan,
                'periode_tahun' => $periodeTahun,
                'id_wilayah' => $puskesmas->id_puskesmas,
                'tipe_wilayah' => 'Puskesmas',
                'total_anak' => $totalAnak,
                'total_stunting' => $totalStunting,
                'total_normal' => $totalNormal,
                'persentase_stunting' => $persentaseStunting,
                'file_laporan' => "laporan_puskesmas_{$periodeTahun}_{$periodeBulan}.pdf",
                'tanggal_buat' => $tanggalBuat,
                'created_at' => $tanggalBuat
            ];

            // Laporan Daerah (every 3 months)
            if ($i % 3 == 0) {
                $laporanData[] = [
                    'id_laporan' => $counter++,
                    'jenis_laporan' => 'Laporan Daerah',
                    'id_pembuat' => $pembuatList[array_rand($pembuatList)],
                    'periode_bulan' => $periodeBulan,
                    'periode_tahun' => $periodeTahun,
                    'id_wilayah' => 1, // ID Kabupaten/Kota
                    'tipe_wilayah' => 'Kabupaten',
                    'total_anak' => $totalAnak,
                    'total_stunting' => $totalStunting,
                    'total_normal' => $totalNormal,
                    'persentase_stunting' => $persentaseStunting,
                    'file_laporan' => "laporan_daerah_{$periodeTahun}_Q" . ceil($periodeBulan/3) . ".pdf",
                    'tanggal_buat' => $tanggalBuat->copy()->addDays(5),
                    'created_at' => $tanggalBuat->copy()->addDays(5)
                ];
            }
        }

        // Insert data
        DB::table('laporan')->insert($laporanData);

        $totalLaporan = count($laporanData);
        $this->command->info("✅ Created {$totalLaporan} Laporan records");
        $this->command->info("   - Laporan Puskesmas: 12 bulan");
        $this->command->info("   - Laporan Daerah: 4 kuartal");
    }
}