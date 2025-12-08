<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\DataStunting;
use App\Models\User;
use Carbon\Carbon;

class NotifikasiSeeder extends Seeder
{
    /**
     * Generate notification message based on status
     */
    private function generateMessage($status, $namaAnak)
    {
        $messages = [
            'Stunting Ringan' => [
                'judul' => '⚠️ Peringatan: Anak Terindikasi Stunting Ringan',
                'pesan' => "Hasil pemeriksaan menunjukkan {$namaAnak} terindikasi stunting ringan. Segera konsultasikan dengan petugas kesehatan untuk mendapatkan program intervensi yang tepat. Perbaiki asupan gizi dan pola makan anak."
            ],
            'Stunting Sedang' => [
                'judul' => '⚠️ Perhatian: Stunting Sedang Terdeteksi',
                'pesan' => "Anak Anda {$namaAnak} mengalami stunting sedang. Diperlukan penanganan segera melalui program PMT (Pemberian Makanan Tambahan) dan konseling gizi. Silakan datang ke Posyandu/Puskesmas terdekat."
            ],
            'Stunting Berat' => [
                'judul' => '🚨 URGENT: Stunting Berat - Perlu Tindakan Segera',
                'pesan' => "PERHATIAN! {$namaAnak} mengalami stunting berat dan memerlukan penanganan medis segera. Harap segera datang ke Puskesmas atau fasilitas kesehatan terdekat untuk mendapatkan rujukan dan program intensif."
            ]
        ];

        return $messages[$status] ?? [
            'judul' => 'Informasi Kesehatan Anak',
            'pesan' => "Update kesehatan untuk {$namaAnak}"
        ];
    }

    public function run(): void
    {
        // Get stunting cases that need notification (not Normal)
        $stuntingCases = DataStunting::with(['pengukuran.anak.orangTua.user'])
            ->where('status_stunting', '!=', 'Normal')
            ->where('status_validasi', 'Validated')
            ->get();

        if ($stuntingCases->isEmpty()) {
            $this->command->warn('No validated stunting cases found.');
            return;
        }

        $notifikasiData = [];
        $counter = 1;

        foreach ($stuntingCases as $stunting) {
            $anak = $stunting->pengukuran->anak;
            $orangTua = $anak->orangTua;
            
            if (!$orangTua || !$orangTua->user) {
                continue;
            }

            $message = $this->generateMessage($stunting->status_stunting, $anak->nama_anak);

            // Create notification for parent
            $notifikasiData[] = [
                'id_notifikasi' => $counter++,
                'id_user' => $orangTua->user->id_user,
                'id_stunting' => $stunting->id_stunting,
                'judul' => $message['judul'],
                'pesan' => $message['pesan'],
                'tipe_notifikasi' => 'Peringatan',
                'status_baca' => rand(0, 100) > 70 ? 'Sudah Dibaca' : 'Belum Dibaca',
                'tanggal_kirim' => Carbon::parse($stunting->tanggal_validasi)->addHours(rand(1, 6)),
                'created_at' => now()
            ];

            // Also create info notification about next checkup
            if (rand(1, 100) > 50) {
                $notifikasiData[] = [
                    'id_notifikasi' => $counter++,
                    'id_user' => $orangTua->user->id_user,
                    'id_stunting' => $stunting->id_stunting,
                    'judul' => '📅 Jadwal Pemeriksaan Selanjutnya',
                    'pesan' => "Jangan lupa membawa {$anak->nama_anak} untuk pemeriksaan rutin bulan depan. Monitoring berkala sangat penting untuk memantau perkembangan anak.",
                    'tipe_notifikasi' => 'Informasi',
                    'status_baca' => 'Belum Dibaca',
                    'tanggal_kirim' => Carbon::parse($stunting->tanggal_validasi)->addDays(rand(7, 14)),
                    'created_at' => now()
                ];
            }

            // Batch insert
            if (count($notifikasiData) >= 100) {
                DB::table('notifikasi')->insert($notifikasiData);
                $notifikasiData = [];
            }
        }

        // Add some general education notifications
        $orangTuaUsers = User::where('role', 'Orang Tua')
            ->where('status', 'Aktif')
            ->limit(30)
            ->pluck('id_user');

        $edukasiMessages = [
            [
                'judul' => '💡 Tips Gizi Seimbang untuk Balita',
                'pesan' => 'Pastikan anak mendapat asupan 4 sehat 5 sempurna setiap hari. Variasikan menu dengan protein (telur, ikan, daging), sayuran berwarna, dan buah-buahan segar.'
            ],
            [
                'judul' => '🥛 Pentingnya ASI Eksklusif',
                'pesan' => 'ASI eksklusif 6 bulan pertama sangat penting untuk tumbuh kembang optimal. Lanjutkan pemberian ASI hingga 2 tahun disertai MPASI bergizi.'
            ],
            [
                'judul' => '🏥 Jadwal Imunisasi Lengkap',
                'pesan' => 'Lengkapi imunisasi anak sesuai jadwal. Imunisasi melindungi anak dari berbagai penyakit berbahaya yang dapat menghambat pertumbuhan.'
            ]
        ];

        foreach ($orangTuaUsers as $userId) {
            $eduMsg = $edukasiMessages[array_rand($edukasiMessages)];
            
            $notifikasiData[] = [
                'id_notifikasi' => $counter++,
                'id_user' => $userId,
                'id_stunting' => null,
                'judul' => $eduMsg['judul'],
                'pesan' => $eduMsg['pesan'],
                'tipe_notifikasi' => 'Informasi',
                'status_baca' => rand(0, 100) > 60 ? 'Sudah Dibaca' : 'Belum Dibaca',
                'tanggal_kirim' => Carbon::now()->subDays(rand(1, 30)),
                'created_at' => now()
            ];
        }

        // Insert remaining
        if (!empty($notifikasiData)) {
            DB::table('notifikasi')->insert($notifikasiData);
        }

        $totalNotif = DB::table('notifikasi')->count();
        $this->command->info("✅ Created {$totalNotif} Notifikasi records");
    }
}