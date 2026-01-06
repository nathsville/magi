<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Models\OrangTua;
use App\Models\Anak;
use App\Models\DataPengukuran;
use App\Models\DataStunting;
use App\Models\Notifikasi;
use App\Models\IntervensiStunting;
use App\Models\User;
use Carbon\Carbon;

class OrangTuaController extends Controller
{
    /**
     * Helper: Ambil jumlah notifikasi belum dibaca
     * Digunakan agar sidebar di semua halaman memiliki data badge notifikasi
     */
    private function getUnreadNotifications($userId)
    {
        return Notifikasi::where('id_user', $userId)
            ->where('status_baca', 'Belum Dibaca')
            ->count();
    }

    // =========================================================================
    // 1. DASHBOARD
    // =========================================================================
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get orang tua profile
        $orangTua = OrangTua::where('id_user', $user->id_user)->first();
        
        if (!$orangTua) {
            // Jika data orang tua belum lengkap, arahkan ke halaman profil/settings atau logout
            return redirect()->route('orangtua.profile')->with('warning', 'Silakan lengkapi data profil Anda terlebih dahulu.');
        }
        
        // Get all children with relations
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
        $unreadNotifications = $this->getUnreadNotifications($user->id_user);
        
        // Latest notifications (5 items)
        $latestNotifications = Notifikasi::where('id_user', $user->id_user)
            ->orderBy('tanggal_kirim', 'desc')
            ->limit(5)
            ->get();
        
        // Educational tips
        $edukasiTips = $this->getEdukasiTipsData();
        
        return view('orangtua.dashboard.index', compact(
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

    // =========================================================================
    // 2. DATA ANAK
    // =========================================================================
    public function anakIndex(Request $request)
    {
        $user = Auth::user();
        $orangTua = OrangTua::where('id_user', $user->id_user)->firstOrFail();

        $query = Anak::where('id_orangtua', $orangTua->id_orangtua)
            ->with(['posyandu', 'pengukuranTerakhir', 'stuntingTerakhir']);

        // Filter Status Gizi
        if ($request->filled('status')) {
            $query->whereHas('stuntingTerakhir', function($q) use ($request) {
                if ($request->status === 'Normal') {
                    $q->where('status_stunting', 'Normal');
                } else {
                    $q->where('status_stunting', '!=', 'Normal');
                }
            });
        }

        // Filter Pencarian Nama
        if ($request->filled('search')) {
            $query->where('nama_anak', 'like', '%' . $request->search . '%');
        }

        $anakList = $query->get();

        // Statistik untuk header halaman anak
        $totalAnak = $anakList->count();
        $anakNormal = $anakList->filter(function($anak) {
            return $anak->stuntingTerakhir && $anak->stuntingTerakhir->status_stunting === 'Normal';
        })->count();
        $anakStunting = $anakList->filter(function($anak) {
            return $anak->stuntingTerakhir && $anak->stuntingTerakhir->status_stunting !== 'Normal';
        })->count();

        $unreadNotifications = $this->getUnreadNotifications($user->id_user);

        return view('orangtua.anak.index', compact(
            'anakList',
            'totalAnak',
            'anakNormal',
            'anakStunting',
            'unreadNotifications' 
        ));
    }

    public function anakDetail($id)
    {
        $user = Auth::user();
        $orangTua = OrangTua::where('id_user', $user->id_user)->firstOrFail();

        $anak = Anak::where('id_anak', $id)
            ->where('id_orangtua', $orangTua->id_orangtua)
            ->with(['posyandu', 'pengukuranTerakhir', 'stuntingTerakhir'])
            ->firstOrFail();

        // Riwayat Pengukuran (12 Terakhir)
        $riwayatPengukuran = DataPengukuran::where('id_anak', $anak->id_anak)
            ->with('dataStunting') 
            ->orderBy('tanggal_ukur', 'desc')
            ->limit(12)
            ->get()
            ->reverse(); // Urutkan dari lama ke baru untuk chart

        // Riwayat Intervensi
        $intervensiList = IntervensiStunting::where('id_anak', $anak->id_anak)
            ->with('petugas')
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->limit(5)
            ->get();

        $umurBulan = Carbon::parse($anak->tanggal_lahir)->diffInMonths(Carbon::now());
        
        // Data untuk Grafik Chart.js
        $chartData = $this->prepareChartData($riwayatPengukuran, $anak);
        $whoStandards = $this->getWHOStandards($anak->jenis_kelamin, $umurBulan);

        $totalPengukuran = $riwayatPengukuran->count();
        $pengukuranTerakhir = $riwayatPengukuran->last();
        $statusTerakhir = $pengukuranTerakhir ? $pengukuranTerakhir->dataStunting : null;

        $unreadNotifications = $this->getUnreadNotifications($user->id_user);

        return view('orangtua.anak.detail', compact(
            'anak',
            'umurBulan',
            'riwayatPengukuran',
            'intervensiList',
            'chartData',
            'whoStandards',
            'totalPengukuran',
            'statusTerakhir',
            'unreadNotifications'
        ));
    }
    
    // AJAX Endpoint untuk memuat data chart jika diperlukan dinamis
    public function getChartData($id)
    {
        $anak = Anak::findOrFail($id);
        // Pastikan anak milik orang tua yang login
        if ($anak->orangTua->id_user !== Auth::id()) {
            abort(403);
        }

        $riwayat = DataPengukuran::where('id_anak', $id)
            ->with('dataStunting')
            ->orderBy('tanggal_ukur', 'asc')
            ->get();

        return response()->json($this->prepareChartData($riwayat, $anak));
    }

    // =========================================================================
    // 3. NOTIFIKASI
    // =========================================================================
    public function notifikasiIndex(Request $request)
    {
        $user = Auth::user();
        $query = Notifikasi::where('id_user', $user->id_user);

        // Filter Status Baca
        if ($request->filled('status')) {
            $query->where('status_baca', $request->status);
        }

        // Filter Tipe Notifikasi
        if ($request->filled('tipe')) {
            $query->where('tipe_notifikasi', $request->tipe);
        }

        $query->orderBy('tanggal_kirim', 'desc');
        $notifikasiList = $query->paginate(15)->withQueryString();

        // Statistik Notifikasi
        $totalNotifikasi = Notifikasi::where('id_user', $user->id_user)->count();
        $belumDibaca = Notifikasi::where('id_user', $user->id_user)
            ->where('status_baca', 'Belum Dibaca')
            ->count();
        $sudahDibaca = Notifikasi::where('id_user', $user->id_user)
            ->where('status_baca', 'Sudah Dibaca')
            ->count();
        $peringatan = Notifikasi::where('id_user', $user->id_user)
            ->where('tipe_notifikasi', 'Peringatan')
            ->count();

        $unreadNotifications = $belumDibaca;

        return view('orangtua.notifikasi.index', compact(
            'notifikasiList',
            'totalNotifikasi',
            'belumDibaca',
            'sudahDibaca',
            'peringatan',
            'unreadNotifications'
        ));
    }

    public function notifikasiShow($id)
    {
        $user = Auth::user();

        // Ambil notifikasi dengan relasi ke stunting -> pengukuran -> anak
        // Sesuaikan relasi 'stunting' dengan model Notifikasi Anda
        $notifikasi = Notifikasi::where('id_notifikasi', $id)
            ->where('id_user', $user->id_user)
            ->with(['stunting.dataPengukuran.anak']) 
            ->firstOrFail();

        // Tandai dibaca
        if ($notifikasi->status_baca === 'Belum Dibaca') {
            $notifikasi->update(['status_baca' => 'Sudah Dibaca']);
        }

        // Coba ambil data anak terkait jika ada
        $anak = null;
        if ($notifikasi->stunting && $notifikasi->stunting->dataPengukuran) {
            $anak = $notifikasi->stunting->dataPengukuran->anak;
        }

        $unreadNotifications = $this->getUnreadNotifications($user->id_user);

        return view('orangtua.notifikasi.show', compact('notifikasi', 'anak', 'unreadNotifications'));
    }

    public function notifikasiMarkRead($id) 
    {
        Notifikasi::where('id_notifikasi', $id)
            ->where('id_user', Auth::id())
            ->update(['status_baca' => 'Sudah Dibaca']);
            
        // Respon Hybrid: JSON untuk AJAX, Redirect untuk Form Biasa
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function notifikasiMarkAllRead() 
    {
        Notifikasi::where('id_user', Auth::id())
            ->where('status_baca', 'Belum Dibaca')
            ->update(['status_baca' => 'Sudah Dibaca']);
            
        return back()->with('success', 'Semua notifikasi telah ditandai sudah dibaca');
    }

    public function notifikasiDelete($id) 
    {
        Notifikasi::where('id_notifikasi', $id)
            ->where('id_user', Auth::id())
            ->delete();
            
        return redirect()->route('orangtua.notifikasi.index')->with('success', 'Notifikasi berhasil dihapus');
    }

    // =========================================================================
    // 4. EDUKASI
    // =========================================================================
    public function edukasiIndex(Request $request)
    {
        $edukasiContent = $this->getEdukasiContent();

        // Filter Kategori
        if ($request->filled('kategori')) {
            $edukasiContent = collect($edukasiContent)->filter(function($item) use ($request) {
                return $item['kategori'] === $request->kategori;
            })->values()->all();
        }

        // Filter Pencarian
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $edukasiContent = collect($edukasiContent)->filter(function($item) use ($search) {
                return str_contains(strtolower($item['judul']), $search) ||
                       str_contains(strtolower($item['ringkasan']), $search);
            })->values()->all();
        }

        $categories = [
            'Gizi Seimbang', 'ASI & MPASI', 'Tumbuh Kembang', 
            'Pencegahan Stunting', 'Pola Asuh', 'Kesehatan Umum'
        ];

        $unreadNotifications = $this->getUnreadNotifications(Auth::id());

        return view('orangtua.edukasi.index', compact('edukasiContent', 'categories', 'unreadNotifications'));
    }

    public function edukasiShow($slug)
    {
        $edukasiContent = $this->getEdukasiContent();
        $artikel = collect($edukasiContent)->firstWhere('slug', $slug);

        if (!$artikel) {
            abort(404, 'Artikel tidak ditemukan');
        }

        $relatedArticles = collect($edukasiContent)
            ->where('kategori', $artikel['kategori'])
            ->where('slug', '!=', $slug)
            ->take(3)
            ->all();

        $unreadNotifications = $this->getUnreadNotifications(Auth::id());

        return view('orangtua.edukasi.show', compact('artikel', 'relatedArticles', 'unreadNotifications'));
    }

    // =========================================================================
    // 5. PROFIL & PENGATURAN
    // =========================================================================
    public function profile()
    {
        $userId = Auth::id();
        $user = User::with('orangTua')->findOrFail($userId);
        $orangTua = $user->orangTua;
        
        // Data statistik profil
        $jumlahAnak = 0;
        $totalPengukuran = 0;
        $lastActivity = null;

        if ($orangTua) {
            $jumlahAnak = Anak::where('id_orangtua', $orangTua->id_orangtua)->count();
            
            $totalPengukuran = DataPengukuran::whereHas('anak', function($query) use ($orangTua) {
                $query->where('id_orangtua', $orangTua->id_orangtua);
            })->count();
            
            $lastActivity = DataPengukuran::whereHas('anak', function($query) use ($orangTua) {
                $query->where('id_orangtua', $orangTua->id_orangtua);
            })->latest('created_at')->first();
        }
        
        $accountAge = Carbon::parse($user->created_at)->diffForHumans();
        
        $stats = [
            'jumlah_anak' => $jumlahAnak,
            'total_pengukuran' => $totalPengukuran,
            'account_age' => $accountAge,
            'last_activity' => $lastActivity,
        ];
        
        $unreadNotifications = $this->getUnreadNotifications($userId);

        return view('orangtua.profile.index', compact('user', 'orangTua', 'stats', 'unreadNotifications'));
    }

    public function profileUpdate(Request $request)
    {
        // Validasi menggunakan nama tabel yang benar (lowercase standard)
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore(Auth::id(), 'id_user')],
            'no_telepon' => 'nullable|string|max:15',
            'nama_ayah' => 'required|string|max:100',
            'nama_ibu' => 'required|string|max:100',
            'nik' => ['required', 'string', 'size:16', Rule::unique('orang_tua', 'nik')->ignore(Auth::user()->orangTua->id_orangtua ?? 0, 'id_orangtua')],
            'alamat' => 'required|string',
            'pekerjaan' => 'nullable|string|max:50',
        ], [
            'nama.required' => 'Nama harus diisi',
            'email.unique' => 'Email sudah digunakan',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Update User table
            $user = User::findOrFail(Auth::id());
            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->no_telepon = $request->no_telepon;
            $user->updated_at = now();
            $user->save();
            
            // Update OrangTua table
            // Gunakan updateOrCreate untuk menangani jika data orangtua belum ada
            OrangTua::updateOrCreate(
                ['id_user' => Auth::id()],
                [
                    'nama_ayah' => $request->nama_ayah,
                    'nama_ibu' => $request->nama_ibu,
                    'nik' => $request->nik,
                    'alamat' => $request->alamat,
                    'pekerjaan' => $request->pekerjaan,
                ]
            );
            
            DB::commit();
            return redirect()->back()->with('success', 'Profil berhasil diperbarui');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui profil: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Password lama harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);
        
        $user = User::findOrFail(Auth::id());
        
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Password lama tidak sesuai')
                ->withInput();
        }
        
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->back()->with('success', 'Password berhasil diubah');
    }

    public function settings()
    {
        $userId = Auth::id();
        $user = User::with('orangTua')->findOrFail($userId);
        $unreadNotifications = $this->getUnreadNotifications($userId);
        
        $settings = [
            'notifikasi_email' => session('settings.notifikasi_email', true),
            'notifikasi_whatsapp' => session('settings.notifikasi_whatsapp', true),
            'notifikasi_browser' => session('settings.notifikasi_browser', true),
            'notifikasi_sound' => session('settings.notifikasi_sound', true),
            'pengingat_posyandu' => session('settings.pengingat_posyandu', true),
            'pengingat_imunisasi' => session('settings.pengingat_imunisasi', true),
            'privasi_data' => session('settings.privasi_data', 'private'),
            'bahasa' => session('settings.bahasa', 'id'),
            'tema' => session('settings.tema', 'light'),
        ];
        
        // FIX PATH: Menggunakan folder 'orangtua/profile/settings'
        return view('orangtua.profile.settings.index', compact('user', 'settings', 'unreadNotifications'));
    }

    public function settingsUpdate(Request $request)
    {
        $request->validate([
            'notifikasi_email' => 'boolean',
            'privasi_data' => 'in:public,private',
            'bahasa' => 'in:id,en',
        ]);
        
        session([
            'settings.notifikasi_email' => $request->boolean('notifikasi_email'),
            'settings.notifikasi_whatsapp' => $request->boolean('notifikasi_whatsapp'),
            'settings.notifikasi_browser' => $request->boolean('notifikasi_browser'),
            'settings.notifikasi_sound' => $request->boolean('notifikasi_sound'),
            'settings.pengingat_posyandu' => $request->boolean('pengingat_posyandu'),
            'settings.pengingat_imunisasi' => $request->boolean('pengingat_imunisasi'),
            'settings.privasi_data' => $request->privasi_data ?? 'private',
            'settings.bahasa' => $request->bahasa ?? 'id',
            'settings.tema' => $request->tema ?? 'light',
        ]);
        
        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan');
    }

    public function deleteAccountRequest(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'alasan' => 'required|string|max:500',
        ]);
        
        $user = User::findOrFail(Auth::id());
        
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Password salah')->withInput();
        }
        
        // Log request penghapusan
        Log::info('Permintaan Hapus Akun', [
            'user_id' => $user->id_user,
            'alasan' => $request->alasan,
            'timestamp' => now(),
        ]);
        
        return redirect()->back()
            ->with('warning', 'Permintaan penghapusan akun telah diterima. Tim kami akan menghubungi Anda.');
    }

    public function exportData()
    {
        $userId = Auth::id();
        $user = User::with('orangTua')->findOrFail($userId);
        $orangTua = $user->orangTua;
        
        if (!$orangTua) return back()->with('error', 'Data orang tua belum lengkap');

        $anak = Anak::with(['dataPengukuran.dataStunting'])
            ->where('id_orangtua', $orangTua->id_orangtua)
            ->get();
        
        $exportData = [
            'user_info' => [
                'nama' => $user->nama,
                'email' => $user->email,
            ],
            'orangtua_info' => [
                'nama_ayah' => $orangTua->nama_ayah,
                'nama_ibu' => $orangTua->nama_ibu,
                'nik' => $orangTua->nik,
            ],
            'children' => [],
        ];
        
        foreach ($anak as $child) {
            $childData = [
                'nama_anak' => $child->nama_anak,
                'tanggal_lahir' => $child->tanggal_lahir,
                'measurements' => [],
            ];
            
            foreach ($child->dataPengukuran as $pengukuran) {
                $childData['measurements'][] = [
                    'tanggal_ukur' => $pengukuran->tanggal_ukur,
                    'berat_badan' => $pengukuran->berat_badan,
                    'tinggi_badan' => $pengukuran->tinggi_badan,
                    'status_gizi' => $pengukuran->dataStunting->status_stunting ?? null,
                ];
            }
            
            $exportData['children'][] = $childData;
        }
        
        $filename = 'Data_Pribadi_' . str_replace(' ', '_', $user->nama) . '_' . now()->format('Ymd') . '.json';
        
        return response()->json($exportData)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Content-Type', 'application/json');
    }

    // =========================================================================
    // PRIVATE HELPER METHODS
    // =========================================================================

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

            if ($pengukuran->dataStunting) {
                $status = $pengukuran->dataStunting->status_stunting;
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

    private function getWHOStandards($jenisKelamin, $umurBulan)
    {
        // Standar sederhana untuk demo grafik (sebaiknya gunakan tabel WHO lengkap di production)
        $standards = [
            'L' => [
                'bb_min' => 2.5 + ($umurBulan * 0.3),
                'bb_median' => 3.5 + ($umurBulan * 0.4),
                'bb_max' => 4.5 + ($umurBulan * 0.5),
                'tb_min' => 45 + ($umurBulan * 1.2),
                'tb_median' => 50 + ($umurBulan * 1.4),
                'tb_max' => 55 + ($umurBulan * 1.6),
            ],
            'P' => [
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

    private function getEdukasiTipsData()
    {
        $tips = [
            ['icon' => '🥛', 'title' => 'ASI Eksklusif', 'description' => 'Berikan ASI eksklusif selama 6 bulan pertama.'],
            ['icon' => '🍎', 'title' => 'MPASI 4 Bintang', 'description' => 'Karbohidrat, Protein Hewani, Nabati, Sayur.'],
            ['icon' => '🏥', 'title' => 'Imunisasi', 'description' => 'Pastikan anak mendapat imunisasi lengkap.'],
            ['icon' => '📏', 'title' => 'Pantau Tumbuh', 'description' => 'Rutin ke Posyandu setiap bulan.']
        ];
        shuffle($tips);
        return array_slice($tips, 0, 3);
    }

    private function getEdukasiContent()
    {
        // Data Dummy untuk Artikel Edukasi
        return [
            [
                'slug' => 'pentingnya-asi-eksklusif',
                'judul' => 'Pentingnya ASI Eksklusif untuk Mencegah Stunting',
                'kategori' => 'ASI & MPASI',
                'icon' => '🍼',
                'gambar' => 'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?w=800',
                'ringkasan' => 'ASI eksklusif selama 6 bulan adalah investasi terbaik untuk mencegah stunting.',
                'konten' => [
                    'paragraf' => ['ASI (Air Susu Ibu) eksklusif adalah pemberian ASI saja kepada bayi...'],
                ],
                'tanggal' => '2024-01-15',
                'durasi_baca' => 5
            ],
            [
                'slug' => 'menu-mpasi-4-bintang',
                'judul' => 'Panduan Lengkap MPASI 4 Bintang',
                'kategori' => 'ASI & MPASI',
                'icon' => '🍽️',
                'gambar' => 'https://images.unsplash.com/photo-1607013251379-e6eecfffe234?w=800',
                'ringkasan' => 'MPASI 4 bintang adalah metode pemberian makanan pendamping ASI yang lengkap.',
                'konten' => [
                    'paragraf' => ['MPASI (Makanan Pendamping ASI) 4 bintang adalah konsep pemberian makanan...'],
                ],
                'tanggal' => '2024-01-20',
                'durasi_baca' => 7
            ],
            // ... Tambahkan artikel lain sesuai kebutuhan
        ];
    }
}