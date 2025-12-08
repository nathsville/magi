<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrangTua;
use App\Models\Anak;
use App\Models\DataPengukuran;
use App\Models\DataStunting;
use App\Models\Notifikasi;
use Carbon\Carbon;

class OrangTuaController extends Controller
{
    /**
     * UC-OT-01: Dashboard Orang Tua
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get orang tua profile
        $orangTua = OrangTua::where('id_user', $user->id_user)->first();
        
        if (!$orangTua) {
            return redirect()->route('login')->with('error', 'Profil orang tua tidak ditemukan');
        }
        
        // Get all children
        $anakList = Anak::where('id_orangtua', $orangTua->id_orangtua)
            ->with(['posyandu', 'pengukuranTerakhir', 'stuntingTerakhir'])
            ->get();
        
        // Statistics
        $totalAnak = $anakList->count();
        $anakNormal = $anakList->filter(function($anak) {
            return $anak->stuntingTerakhir && $anak->stuntingTerakhir->status_stunting === 'Normal';
        })->count();
        $anakStunting = $anakList->filter(function($anak) {
            return $anak->stuntingTerakhir && $anak->stuntingTerakhir->status_stunting !== 'Normal';
        })->count();
        
        // Unread notifications count
        $unreadNotifications = Notifikasi::where('id_user', $user->id_user)
            ->where('status_baca', 'Belum Dibaca')
            ->count();
        
        // Latest notifications (5 items)
        $latestNotifications = Notifikasi::where('id_user', $user->id_user)
            ->orderBy('tanggal_kirim', 'desc')
            ->limit(5)
            ->get();
        
        // Educational tips (random 3)
        $edukasiTips = [
            [
                'icon' => '🥛',
                'title' => 'ASI Eksklusif',
                'description' => 'Berikan ASI eksklusif selama 6 bulan pertama untuk nutrisi optimal.'
            ],
            [
                'icon' => '🍎',
                'title' => 'Makanan Bergizi',
                'description' => 'Berikan MPASI dengan 4 bintang: karbohidrat, protein hewani, protein nabati, sayur/buah.'
            ],
            [
                'icon' => '🏥',
                'title' => 'Imunisasi Lengkap',
                'description' => 'Pastikan anak mendapat imunisasi lengkap sesuai jadwal Posyandu.'
            ],
            [
                'icon' => '🧼',
                'title' => 'Kebersihan',
                'description' => 'Jaga kebersihan lingkungan dan biasakan cuci tangan sebelum makan.'
            ],
            [
                'icon' => '📏',
                'title' => 'Pantau Pertumbuhan',
                'description' => 'Rutin mengukur berat dan tinggi badan anak di Posyandu setiap bulan.'
            ],
            [
                'icon' => '💊',
                'title' => 'Vitamin & Mineral',
                'description' => 'Berikan suplemen vitamin A dan zat besi sesuai anjuran petugas kesehatan.'
            ]
        ];
        
        // Shuffle and take 3
        shuffle($edukasiTips);
        $edukasiTips = array_slice($edukasiTips, 0, 3);
        
        return view('orangtua.dashboard', compact(
            'orangTua',
            'anakList',
            'totalAnak',
            'anakNormal',
            'anakStunting',
            'unreadNotifications',
            'latestNotifications',
            'edukasiTips'
        ));
    }

    // Data Anak Index
    public function anakIndex(Request $request)
    {
        $user = Auth::user();
        $orangTua = OrangTua::where('id_user', $user->id_user)->first();

        if (!$orangTua) {
            return redirect()->route('login')->with('error', 'Profil orang tua tidak ditemukan');
        }

        // Get all children with latest status
        $query = Anak::where('id_orangtua', $orangTua->id_orangtua)
            ->with(['posyandu', 'pengukuranTerakhir', 'stuntingTerakhir']);

        // Filter by status
        if ($request->filled('status')) {
            $query->whereHas('stuntingTerakhir', function($q) use ($request) {
                if ($request->status === 'Normal') {
                    $q->where('status_stunting', 'Normal');
                } else {
                    $q->where('status_stunting', '!=', 'Normal');
                }
            });
        }

        // Search by name
        if ($request->filled('search')) {
            $query->where('nama_anak', 'like', '%' . $request->search . '%');
        }

        $anakList = $query->get();

        // Statistics
        $totalAnak = $anakList->count();
        $anakNormal = $anakList->filter(function($anak) {
            return $anak->stuntingTerakhir && $anak->stuntingTerakhir->status_stunting === 'Normal';
        })->count();
        $anakStunting = $anakList->filter(function($anak) {
            return $anak->stuntingTerakhir && $anak->stuntingTerakhir->status_stunting !== 'Normal';
        })->count();

        return view('orangtua.anak.index', compact(
            'anakList',
            'totalAnak',
            'anakNormal',
            'anakStunting'
        ));
    }

    /**
     * UC-OT-02: Data Anak Detail with Growth Charts
     */
    public function anakDetail($id)
    {
        $user = Auth::user();
        $orangTua = OrangTua::where('id_user', $user->id_user)->first();

        if (!$orangTua) {
            return redirect()->route('login')->with('error', 'Profil orang tua tidak ditemukan');
        }

        // Get anak with authorization check
        $anak = Anak::where('id_anak', $id)
            ->where('id_orangtua', $orangTua->id_orangtua)
            ->with(['posyandu', 'pengukuranTerakhir', 'stuntingTerakhir'])
            ->firstOrFail();

        // Get measurement history (last 12 months or all if less)
        $riwayatPengukuran = DataPengukuran::where('id_anak', $anak->id_anak)
            ->with('stunting')
            ->orderBy('tanggal_ukur', 'desc')
            ->limit(12)
            ->get()
            ->reverse(); // Reverse to show oldest first for charts

        // Get interventions
        $intervensiList = IntervensiStunting::where('id_anak', $anak->id_anak)
            ->with('petugas')
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->limit(5)
            ->get();

        // Calculate age in months
        $umurBulan = Carbon::parse($anak->tanggal_lahir)->diffInMonths(Carbon::now());

        // Prepare chart data
        $chartData = $this->prepareChartData($riwayatPengukuran, $anak);

        // Get WHO standard ranges for reference
        $whoStandards = $this->getWHOStandards($anak->jenis_kelamin, $umurBulan);

        // Calculate statistics
        $totalPengukuran = $riwayatPengukuran->count();
        $pengukuranTerakhir = $riwayatPengukuran->last();
        $statusTerakhir = $pengukuranTerakhir ? $pengukuranTerakhir->stunting : null;

        return view('orangtua.anak.detail', compact(
            'anak',
            'umurBulan',
            'riwayatPengukuran',
            'intervensiList',
            'chartData',
            'whoStandards',
            'totalPengukuran',
            'statusTerakhir'
        ));
    }

    /**
     * Helper: Prepare chart data for Chart.js
     */
    private function prepareChartData($riwayatPengukuran, $anak)
    {
        $labels = [];
        $beratBadanData = [];
        $tinggiBadanData = [];
        $lingkarKepalaData = [];
        $lingkarLenganData = [];
        $statusColors = [];

        foreach ($riwayatPengukuran as $pengukuran) {
            $labels[] = Carbon::parse($pengukuran->tanggal_ukur)->format('M Y');
            $beratBadanData[] = (float) $pengukuran->berat_badan;
            $tinggiBadanData[] = (float) $pengukuran->tinggi_badan;
            $lingkarKepalaData[] = (float) $pengukuran->lingkar_kepala;
            $lingkarLenganData[] = (float) $pengukuran->lingkar_lengan;

            // Status colors for point styling
            if ($pengukuran->stunting) {
                $status = $pengukuran->stunting->status_stunting;
                $statusColors[] = $status === 'Normal' ? '#10b981' : '#f59e0b';
            } else {
                $statusColors[] = '#6b7280';
            }
        }

        return [
            'labels' => $labels,
            'beratBadan' => $beratBadanData,
            'tinggiBadan' => $tinggiBadanData,
            'lingkarKepala' => $lingkarKepalaData,
            'lingkarLengan' => $lingkarLenganData,
            'statusColors' => $statusColors
        ];
    }

    /**
     * Helper: Get WHO standard ranges (simplified)
     */
    private function getWHOStandards($jenisKelamin, $umurBulan)
    {
        // Simplified WHO standards - in production, use complete WHO tables
        $standards = [
            'L' => [ // Laki-laki
                'bb_min' => 2.5 + ($umurBulan * 0.3),
                'bb_median' => 3.5 + ($umurBulan * 0.4),
                'bb_max' => 4.5 + ($umurBulan * 0.5),
                'tb_min' => 45 + ($umurBulan * 1.2),
                'tb_median' => 50 + ($umurBulan * 1.4),
                'tb_max' => 55 + ($umurBulan * 1.6),
            ],
            'P' => [ // Perempuan
                'bb_min' => 2.4 + ($umurBulan * 0.28),
                'bb_median' => 3.3 + ($umurBulan * 0.38),
                'bb_max' => 4.2 + ($umurBulan * 0.48),
                'tb_min' => 44 + ($umurBulan * 1.1),
                'tb_median' => 49 + ($umurBulan * 1.3),
                'tb_max' => 54 + ($umurBulan * 1.5),
            ]
        ];

        return $standards[$jenisKelamin] ?? $standards['L'];
    }

    /**
     * API: Get chart data (AJAX endpoint for dynamic updates)
     */
    public function getChartData($id)
    {
        $user = Auth::user();
        $orangTua = OrangTua::where('id_user', $user->id_user)->first();

        if (!$orangTua) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $anak = Anak::where('id_anak', $id)
            ->where('id_orangtua', $orangTua->id_orangtua)
            ->firstOrFail();

        $riwayatPengukuran = DataPengukuran::where('id_anak', $anak->id_anak)
            ->with('stunting')
            ->orderBy('tanggal_ukur', 'asc')
            ->get();

        $chartData = $this->prepareChartData($riwayatPengukuran, $anak);

        return response()->json($chartData);
    }

    /**
     * UC-OT-03: Notifikasi Index
     */
    public function notifikasiIndex(Request $request)
    {
        $user = Auth::user();

        // Build query
        $query = Notifikasi::where('id_user', $user->id_user);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_baca', $request->status);
        }

        // Filter by type
        if ($request->filled('tipe')) {
            $query->where('tipe_notifikasi', $request->tipe);
        }

        // Order by date (newest first)
        $query->orderBy('tanggal_kirim', 'desc');

        // Paginate
        $notifikasiList = $query->paginate(15)->withQueryString();

        // Statistics
        $totalNotifikasi = Notifikasi::where('id_user', $user->id_user)->count();
        $belumDibaca = Notifikasi::where('id_user', $user->id_user)
            ->where('status_baca', 'Belum Dibaca')
            ->count();
        $sudahDibaca = Notifikasi::where('id_user', $user->id_user)
            ->where('status_baca', 'Sudah Dibaca')
            ->count();

        // Count by type
        $peringatan = Notifikasi::where('id_user', $user->id_user)
            ->where('tipe_notifikasi', 'Peringatan')
            ->count();

        return view('orangtua.notifikasi.index', compact(
            'notifikasiList',
            'totalNotifikasi',
            'belumDibaca',
            'sudahDibaca',
            'peringatan'
        ));
    }

    /**
     * UC-OT-03: Notifikasi Show (Detail)
     */
    public function notifikasiShow($id)
    {
        $user = Auth::user();

        $notifikasi = Notifikasi::where('id_notifikasi', $id)
            ->where('id_user', $user->id_user)
            ->with('stunting.pengukuran.anak')
            ->firstOrFail();

        // Mark as read automatically when opened
        if ($notifikasi->status_baca === 'Belum Dibaca') {
            $notifikasi->update(['status_baca' => 'Sudah Dibaca']);
        }

        // Get related anak if available
        $anak = null;
        if ($notifikasi->stunting && $notifikasi->stunting->pengukuran) {
            $anak = $notifikasi->stunting->pengukuran->anak;
        }

        return view('orangtua.notifikasi.show', compact('notifikasi', 'anak'));
    }

    /**
     * UC-OT-03: Mark Notification as Read (AJAX)
     */
    public function notifikasiMarkRead($id)
    {
        $user = Auth::user();

        $notifikasi = Notifikasi::where('id_notifikasi', $id)
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        $notifikasi->update(['status_baca' => 'Sudah Dibaca']);

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sebagai dibaca'
        ]);
    }

    /**
     * UC-OT-03: Mark All as Read
     */
    public function notifikasiMarkAllRead()
    {
        $user = Auth::user();

        Notifikasi::where('id_user', $user->id_user)
            ->where('status_baca', 'Belum Dibaca')
            ->update(['status_baca' => 'Sudah Dibaca']);

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca');
    }

    /**
     * UC-OT-03: Delete Notification
     */
    public function notifikasiDelete($id)
    {
        $user = Auth::user();

        $notifikasi = Notifikasi::where('id_notifikasi', $id)
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        $notifikasi->delete();

        return redirect()->route('orangtua.notifikasi.index')
            ->with('success', 'Notifikasi berhasil dihapus');
    }

    /**
     * UC-OT-04: Edukasi Index
     */
    public function edukasiIndex(Request $request)
    {
        // Get all educational content
        $edukasiContent = $this->getEdukasiContent();

        // Filter by category
        if ($request->filled('kategori')) {
            $edukasiContent = collect($edukasiContent)->filter(function($item) use ($request) {
                return $item['kategori'] === $request->kategori;
            })->values()->all();
        }

        // Search by keyword
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $edukasiContent = collect($edukasiContent)->filter(function($item) use ($search) {
                return str_contains(strtolower($item['judul']), $search) ||
                       str_contains(strtolower($item['ringkasan']), $search);
            })->values()->all();
        }

        // Categories for filter
        $categories = [
            'Gizi Seimbang',
            'ASI & MPASI',
            'Tumbuh Kembang',
            'Pencegahan Stunting',
            'Pola Asuh',
            'Kesehatan Umum'
        ];

        return view('orangtua.edukasi.index', compact('edukasiContent', 'categories'));
    }

    /**
     * UC-OT-04: Edukasi Show (Detail)
     */
    public function edukasiShow($slug)
    {
        $edukasiContent = $this->getEdukasiContent();

        // Find content by slug
        $artikel = collect($edukasiContent)->firstWhere('slug', $slug);

        if (!$artikel) {
            abort(404, 'Artikel tidak ditemukan');
        }

        // Get related articles (same category, exclude current)
        $relatedArticles = collect($edukasiContent)
            ->where('kategori', $artikel['kategori'])
            ->where('slug', '!=', $slug)
            ->take(3)
            ->all();

        return view('orangtua.edukasi.show', compact('artikel', 'relatedArticles'));
    }

    /**
     * Helper: Get Educational Content Database
     */
    private function getEdukasiContent()
    {
        return [
            [
                'slug' => 'pentingnya-asi-eksklusif',
                'judul' => 'Pentingnya ASI Eksklusif untuk Mencegah Stunting',
                'kategori' => 'ASI & MPASI',
                'icon' => '🍼',
                'gambar' => 'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?w=800',
                'ringkasan' => 'ASI eksklusif selama 6 bulan adalah investasi terbaik untuk mencegah stunting dan memberikan nutrisi optimal bagi bayi.',
                'konten' => [
                    'paragraf' => [
                        'ASI (Air Susu Ibu) eksklusif adalah pemberian ASI saja kepada bayi tanpa makanan atau minuman lain, bahkan air putih, selama 6 bulan pertama kehidupan. WHO dan UNICEF merekomendasikan ASI eksklusif sebagai standar emas pemberian makan bayi.',
                        'ASI mengandung semua nutrisi yang dibutuhkan bayi untuk tumbuh kembang optimal, termasuk protein, lemak, karbohidrat, vitamin, mineral, dan antibodi yang melindungi dari infeksi. Kandungan ASI secara alami menyesuaikan dengan kebutuhan bayi seiring bertambahnya usia.',
                        'Penelitian menunjukkan bahwa bayi yang mendapat ASI eksklusif memiliki risiko stunting 50% lebih rendah dibandingkan yang tidak. ASI juga meningkatkan kecerdasan anak dan mengurangi risiko obesitas di masa depan.',
                    ],
                    'tips' => [
                        'Mulai menyusui dalam 1 jam pertama setelah lahir (Inisiasi Menyusu Dini)',
                        'Susui bayi sesering mungkin, minimal 8-12 kali sehari',
                        'Jangan berikan makanan atau minuman lain, termasuk air putih',
                        'Konsumsi makanan bergizi seimbang untuk menjaga produksi ASI',
                        'Istirahat cukup dan kelola stres dengan baik',
                        'Konsultasi dengan konselor laktasi jika mengalami kesulitan'
                    ],
                    'fakta' => [
                        'ASI mengandung lebih dari 200 komponen bioaktif',
                        'Komposisi ASI berubah sesuai kebutuhan bayi',
                        'ASI pertama (kolostrum) kaya antibodi dan disebut "vaksin alami"',
                        'Menyusui membakar 500 kalori per hari untuk ibu'
                    ]
                ],
                'tanggal' => '2024-01-15',
                'durasi_baca' => 5
            ],
            [
                'slug' => 'menu-mpasi-4-bintang',
                'judul' => 'Panduan Lengkap MPASI 4 Bintang untuk Cegah Stunting',
                'kategori' => 'ASI & MPASI',
                'icon' => '🍽️',
                'gambar' => 'https://images.unsplash.com/photo-1607013251379-e6eecfffe234?w=800',
                'ringkasan' => 'MPASI 4 bintang adalah metode pemberian makanan pendamping ASI yang lengkap dan seimbang untuk mendukung pertumbuhan optimal bayi.',
                'konten' => [
                    'paragraf' => [
                        'MPASI (Makanan Pendamping ASI) 4 bintang adalah konsep pemberian makanan bayi usia 6 bulan ke atas yang terdiri dari 4 komponen utama: karbohidrat, protein hewani, protein nabati, dan sayur/buah. Kombinasi ini memastikan bayi mendapat nutrisi lengkap.',
                        'Periode 6-24 bulan adalah masa emas (golden period) pertumbuhan anak. Pemberian MPASI yang tepat pada periode ini sangat krusial untuk mencegah stunting. Kekurangan gizi pada masa ini dapat berdampak permanen pada pertumbuhan fisik dan perkembangan otak.',
                        'Protein hewani seperti telur, ikan, daging, dan hati ayam sangat penting karena mengandung asam amino esensial dan zat besi yang mudah diserap. Kombinasikan dengan karbohidrat (nasi, kentang), protein nabati (tahu, tempe), dan sayur/buah untuk nutrisi optimal.',
                    ],
                    'tips' => [
                        'Mulai MPASI tepat di usia 6 bulan, jangan terlalu dini atau terlambat',
                        'Berikan 1 jenis makanan baru setiap 3-5 hari untuk mendeteksi alergi',
                        'Tekstur bertahap: mulai halus (puree), lalu kasar (mashed), hingga makanan keluarga',
                        'Frekuensi makan: 2-3x sehari usia 6-8 bulan, 3-4x sehari usia 9-24 bulan',
                        'Tetap berikan ASI sesuai permintaan bayi',
                        'Variasikan menu agar tidak bosan dan nutrisi beragam',
                        'Hindari gula, garam, dan MSG berlebihan'
                    ],
                    'contoh_menu' => [
                        '6-8 bulan: Bubur saring ayam + wortel + tempe',
                        '9-11 bulan: Nasi tim ikan + bayam + tahu',
                        '12-24 bulan: Nasi lembek + telur + brokoli + alpukat'
                    ],
                    'fakta' => [
                        '1 butir telur setara dengan 100g daging dalam kandungan protein',
                        'Zat besi dari daging diserap 7x lebih baik dari sayur',
                        'Lemak penting untuk perkembangan otak bayi',
                        'Hati ayam kaya zat besi dan vitamin A'
                    ]
                ],
                'tanggal' => '2024-01-20',
                'durasi_baca' => 7
            ],
            [
                'slug' => 'tanda-tanda-stunting',
                'judul' => 'Kenali Tanda-Tanda Stunting Sejak Dini',
                'kategori' => 'Tumbuh Kembang',
                'icon' => '📏',
                'gambar' => 'https://images.unsplash.com/photo-1476703993599-0035a21b17a9?w=800',
                'ringkasan' => 'Mengenali tanda-tanda stunting sejak dini sangat penting agar dapat segera melakukan intervensi yang tepat.',
                'konten' => [
                    'paragraf' => [
                        'Stunting adalah kondisi gagal tumbuh pada anak akibat kekurangan gizi kronis, terutama dalam 1000 hari pertama kehidupan (sejak kehamilan hingga usia 2 tahun). Stunting tidak hanya membuat anak pendek, tetapi juga berdampak pada perkembangan otak dan kecerdasan.',
                        'Tanda utama stunting adalah tinggi badan anak berada di bawah standar WHO untuk usianya (Z-score TB/U < -2 SD). Namun, ada tanda-tanda lain yang bisa diamati sejak dini sebelum kondisi menjadi parah.',
                        'Deteksi dini sangat penting karena stunting yang terjadi pada 1000 hari pertama kehidupan sulit diperbaiki setelah anak berusia 2 tahun. Oleh karena itu, pemantauan rutin pertumbuhan anak di Posyandu sangat dianjurkan.',
                    ],
                    'tanda' => [
                        'Tinggi badan lebih pendek dari anak seusianya',
                        'Pertumbuhan tinggi badan melambat atau stagnan',
                        'Berat badan tidak naik atau naik sangat lambat',
                        'Proporsi tubuh tidak seimbang (kepala lebih besar dibanding badan)',
                        'Perkembangan motorik terlambat (telat duduk, berjalan, bicara)',
                        'Mudah sakit dan lama sembuh',
                        'Kurang aktif dan sering terlihat lesu',
                        'Performa akademik rendah di usia sekolah'
                    ],
                    'pencegahan' => [
                        'Penuhi kebutuhan gizi ibu hamil (konsumsi tablet tambah darah)',
                        'ASI eksklusif 6 bulan dilanjutkan hingga 2 tahun',
                        'MPASI bergizi lengkap dan seimbang (4 bintang)',
                        'Imunisasi lengkap sesuai jadwal',
                        'Timbang anak rutin setiap bulan di Posyandu',
                        'Sanitasi dan kebersihan lingkungan yang baik',
                        'Pola asuh yang responsif dan penuh kasih sayang'
                    ],
                    'fakta' => [
                        'Stunting bersifat permanen jika terjadi sebelum usia 2 tahun',
                        '1 dari 3 anak Indonesia mengalami stunting',
                        'Stunting menurunkan IQ hingga 10-15 poin',
                        'Anak stunting berisiko 5x lebih besar terkena penyakit kronis'
                    ]
                ],
                'tanggal' => '2024-02-01',
                'durasi_baca' => 6
            ],
            [
                'slug' => 'imunisasi-lengkap',
                'judul' => 'Pentingnya Imunisasi Lengkap untuk Cegah Stunting',
                'kategori' => 'Kesehatan Umum',
                'icon' => '💉',
                'gambar' => 'https://images.unsplash.com/photo-1631815588090-d4bfec5b1ccb?w=800',
                'ringkasan' => 'Imunisasi lengkap melindungi anak dari penyakit infeksi yang dapat menghambat pertumbuhan dan menyebabkan stunting.',
                'konten' => [
                    'paragraf' => [
                        'Imunisasi adalah cara paling efektif mencegah penyakit infeksi berbahaya pada anak. Anak yang sering sakit akan mengalami gangguan penyerapan nutrisi dan kehilangan nafsu makan, yang pada akhirnya dapat menyebabkan stunting.',
                        'Program imunisasi dasar lengkap di Indonesia mencakup vaksin Hepatitis B, Polio, BCG, DPT-HB-Hib, Campak, dan Rubella. Imunisasi lanjutan diberikan pada usia tertentu untuk mempertahankan kekebalan tubuh anak.',
                        'Penelitian menunjukkan bahwa anak yang tidak mendapat imunisasi lengkap memiliki risiko stunting 2-3 kali lebih tinggi karena lebih rentan terhadap infeksi berulang yang mengganggu pertumbuhan.',
                    ],
                    'jadwal' => [
                        '0 bulan: Hepatitis B (HB-0)',
                        '1 bulan: BCG, Polio 1',
                        '2 bulan: DPT-HB-Hib 1, Polio 2',
                        '3 bulan: DPT-HB-Hib 2, Polio 3',
                        '4 bulan: DPT-HB-Hib 3, Polio 4, IPV',
                        '9 bulan: Campak-Rubella (MR)',
                        '18 bulan: DPT-HB-Hib booster, Campak-Rubella booster'
                    ],
                    'tips' => [
                        'Catat jadwal imunisasi dan patuhi waktunya',
                        'Bawa buku KIA (Kesehatan Ibu dan Anak) setiap ke Posyandu',
                        'Perhatikan kondisi anak sebelum imunisasi (tidak demam tinggi)',
                        'Kompres hangat jika terjadi bengkak di bekas suntikan',
                        'Berikan ASI/minum lebih banyak setelah imunisasi',
                        'Jangan takut efek samping ringan (demam, rewel) - ini normal',
                        'Konsultasi dengan petugas jika ada reaksi tidak biasa'
                    ],
                    'fakta' => [
                        'Imunisasi telah menyelamatkan 2-3 juta jiwa setiap tahun',
                        'Vaksin aman dan sudah melalui uji klinis ketat',
                        'Efek samping serius sangat jarang (kurang dari 1:1.000.000)',
                        'Kekebalan alami dari sakit lebih berbahaya dari imunisasi'
                    ]
                ],
                'tanggal' => '2024-02-10',
                'durasi_baca' => 5
            ],
            [
                'slug' => 'pola-asuh-responsif',
                'judul' => 'Pola Asuh Responsif untuk Dukung Tumbuh Kembang Optimal',
                'kategori' => 'Pola Asuh',
                'icon' => '👨‍👩‍👧',
                'gambar' => 'https://images.unsplash.com/photo-1476703993599-0035a21b17a9?w=800',
                'ringkasan' => 'Pola asuh responsif yang penuh kasih sayang sama pentingnya dengan nutrisi untuk mencegah stunting dan mendukung perkembangan anak.',
                'konten' => [
                    'paragraf' => [
                        'Pola asuh responsif adalah cara mengasuh anak dengan merespons kebutuhan fisik, emosional, dan sosial anak secara cepat, tepat, dan penuh kasih sayang. Pola asuh ini terbukti mendukung pertumbuhan dan perkembangan anak secara optimal.',
                        'Stunting tidak hanya disebabkan oleh kekurangan gizi, tetapi juga pola asuh yang tidak responsif. Anak yang kurang mendapat stimulasi, perhatian, dan kasih sayang akan mengalami stres kronis yang menghambat pertumbuhan (psychosocial dwarfism).',
                        'Interaksi positif antara orang tua dan anak, seperti berbicara, bermain, memeluk, dan merespons tangisan anak, sangat penting untuk perkembangan otak. Otak anak berkembang paling pesat di 2 tahun pertama kehidupan.',
                    ],
                    'prinsip' => [
                        'Respons cepat terhadap kebutuhan anak (lapar, haus, tidak nyaman)',
                        'Berikan perhatian penuh saat berinteraksi dengan anak',
                        'Ajak bicara dan nyanyikan lagu untuk anak',
                        'Bermain bersama dengan mainan edukatif',
                        'Berikan pujian dan dorongan positif',
                        'Hindari kekerasan fisik maupun verbal',
                        'Ciptakan lingkungan yang aman dan nyaman',
                        'Libatkan ayah dalam pengasuhan anak'
                    ],
                    'stimulasi' => [
                        '0-6 bulan: Tatap mata, ajak bicara, goyangkan mainan warna-warni',
                        '6-12 bulan: Cilukba, tepuk tangan, panggil nama, ajak duduk',
                        '12-24 bulan: Ajak jalan, bicara 2 kata, makan sendiri, main bola',
                        '2-3 tahun: Mewarnai, bermain puzzle sederhana, belajar menghitung'
                    ],
                    'fakta' => [
                        'Anak yang diasuh responsif memiliki IQ 10-20 poin lebih tinggi',
                        'Stres kronis pada anak menghambat hormon pertumbuhan',
                        'Interaksi positif membentuk koneksi neuron di otak',
                        'Kasih sayang sama pentingnya dengan nutrisi'
                    ]
                ],
                'tanggal' => '2024-02-15',
                'durasi_baca' => 6
            ],
            [
                'slug' => 'kebersihan-dan-sanitasi',
                'judul' => 'Peran Kebersihan dan Sanitasi dalam Pencegahan Stunting',
                'kategori' => 'Pencegahan Stunting',
                'icon' => '🧼',
                'gambar' => 'https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?w=800',
                'ringkasan' => 'Lingkungan bersih dan sanitasi yang baik mencegah infeksi berulang yang dapat menghambat penyerapan nutrisi dan menyebabkan stunting.',
                'konten' => [
                    'paragraf' => [
                        'Kebersihan dan sanitasi yang buruk adalah salah satu penyebab utama stunting di Indonesia. Infeksi berulang seperti diare dan cacingan menyebabkan anak kehilangan nutrisi dan mengganggu penyerapan gizi.',
                        'Diare pada anak di bawah 2 tahun sangat berbahaya karena menyebabkan dehidrasi dan kehilangan nutrisi penting. Anak yang sering diare memiliki risiko stunting 2-3 kali lebih tinggi.',
                        'Perilaku Hidup Bersih dan Sehat (PHBS) di rumah tangga, seperti cuci tangan pakai sabun, penggunaan jamban sehat, dan air bersih, terbukti menurunkan kejadian infeksi hingga 50%.',
                    ],
                    'praktik_phbs' => [
                        'Cuci tangan pakai sabun dengan 6 langkah yang benar',
                        'Gunakan jamban sehat, jangan buang air besar sembarangan',
                        'Konsumsi air bersih yang sudah dimasak',
                        'Tutup makanan agar tidak dihinggapi lalat',
                        'Buang sampah pada tempatnya',
                        'Bersihkan lingkungan rumah secara rutin',
                        'Jemur kasur dan bantal secara berkala',
                        'Potong kuku anak secara rutin'
                    ],
                    'waktu_cuci_tangan' => [
                        'Sebelum makan dan menyiapkan makanan',
                        'Setelah buang air besar/kecil',
                        'Setelah mengganti popok bayi',
                        'Setelah menyentuh hewan',
                        'Setelah batuk/bersin/buang ingus',
                        'Sebelum menyusui atau memberikan makan anak'
                    ],
                    'fakta' => [
                        'Cuci tangan menurunkan risiko diare hingga 45%',
                        '1 gram tinja mengandung 10 juta virus dan 1 juta bakteri',
                        'Cacingan menyebabkan kehilangan zat besi dan protein',
                        'Air yang tercemar adalah sumber 80% penyakit anak'
                    ]
                ],
                'tanggal' => '2024-02-20',
                'durasi_baca' => 5
            ],
        ];
    }

}