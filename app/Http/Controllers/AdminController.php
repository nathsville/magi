<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Puskesmas;
use App\Models\Posyandu;
use App\Models\Anak;
use App\Models\DataStunting;
use App\Models\DataPengukuran;
use App\Models\DataMaster;
use App\Models\Notifikasi;
use App\Models\OrangTua;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\BroadcastMail;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $totalAnak = Anak::count();
        $totalStunting = DataStunting::whereIn('status_stunting', ['Stunting Ringan', 'Stunting Sedang', 'Stunting Berat'])->count();
        $persentaseStunting = $totalAnak > 0 ? ($totalStunting / $totalAnak) * 100 : 0;
        $totalPosyandu = Posyandu::where('status', 'Aktif')->count();
        
        // Data stunting per wilayah menggunakan raw query yang lebih efisien
        $stuntingPerWilayah = DB::table('puskesmas')
            ->select(
                'puskesmas.id_puskesmas',
                'puskesmas.nama_puskesmas',
                'puskesmas.kecamatan',
                DB::raw('COUNT(DISTINCT data_pengukuran.id_anak) as total_anak'),
                DB::raw('SUM(CASE WHEN data_stunting.status_stunting IN ("Stunting Ringan", "Stunting Sedang", "Stunting Berat") THEN 1 ELSE 0 END) as jumlah_stunting')
            )
            ->leftJoin('posyandu', 'puskesmas.id_puskesmas', '=', 'posyandu.id_puskesmas')
            ->leftJoin('data_pengukuran', 'posyandu.id_posyandu', '=', 'data_pengukuran.id_posyandu')
            ->leftJoin('data_stunting', 'data_pengukuran.id_pengukuran', '=', 'data_stunting.id_pengukuran')
            ->groupBy('puskesmas.id_puskesmas', 'puskesmas.nama_puskesmas', 'puskesmas.kecamatan')
            ->get()
            ->map(function($item) {
                $item->persentase = $item->total_anak > 0 
                    ? ($item->jumlah_stunting / $item->total_anak) * 100 
                    : 0;
                return $item;
            });

        // Log aktivitas terbaru
        $recentActivities = $this->getRecentActivities();

        return view('admin.dashboard', compact(
            'totalAnak',
            'totalStunting',
            'persentaseStunting',
            'totalPosyandu',
            'stuntingPerWilayah',
            'recentActivities'
        ));
    }

    // ========== MANAJEMEN DATA MASTER ==========
    
    public function datamasterIndex()
    {
        $query = DataMaster::query();

        // Support search dari dashboard
        if (request('search')) {
            $searchTerm = request('search');
            
            // Ekstrak kode jika format "KODE - NILAI"
            if (strpos($searchTerm, ' - ') !== false) {
                $parts = explode(' - ', $searchTerm, 2);
                $kode = trim($parts[0]);
                $nilai = trim($parts[1]);
                
                $query->where(function($q) use ($kode, $nilai) {
                    $q->where('kode', $kode)
                    ->where('nilai', 'LIKE', '%' . $nilai . '%');
                });
            } else {
                // Search biasa
                $query->where(function($q) use ($searchTerm) {
                    $q->where('kode', 'like', '%' . $searchTerm . '%')
                    ->orWhere('nilai', 'like', '%' . $searchTerm . '%')
                    ->orWhere('deskripsi', 'like', '%' . $searchTerm . '%');
                });
            }
        }

        // Support filter tipe dari dashboard
        if (request('tipe')) {
            $query->where('tipe_data', request('tipe'));
        }

        $dataMaster = $query->orderBy('tipe_data')->orderBy('kode')->get()->groupBy('tipe_data');
        
        return view('admin.datamaster.index', compact('dataMaster'));
    }

    public function datamasterCreate()
    {
        return view('admin.datamaster.create');
    }

    public function datamasterStore(Request $request)
    {
        $validated = $request->validate([
            'tipe_data' => 'required|string|max:50',
            'kode' => 'required|string|max:20',
            'nilai' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:Aktif,Nonaktif'
        ]);

        DataMaster::create($validated);

        $this->logActivity('Menambahkan data master: ' . $validated['tipe_data'] . ' - ' . $validated['nilai']);

        return redirect()->route('admin.datamaster')->with('success', 'Data master berhasil ditambahkan');
    }

    public function datamasterEdit($id)
    {
        $data = DataMaster::findOrFail($id);
        return view('admin.datamaster.edit', compact('data'));
    }

    public function datamasterUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'tipe_data' => 'required|string|max:50',
            'kode' => 'required|string|max:20|unique:data_master,kode,' . $id . ',id_master', // PENTING!
            'nilai' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:Aktif,Nonaktif'
        ]);

        $data = DataMaster::findOrFail($id);
        $data->update($validated);

        $this->logActivity('Mengubah data master: ' . $validated['tipe_data'] . ' - ' . $validated['nilai']);

        return redirect()->route('admin.datamaster')->with('success', 'Data master berhasil diperbarui');
    }

    public function datamasterDestroy($id)
    {
        $data = DataMaster::findOrFail($id);
        $nama = $data->tipe_data . ' - ' . $data->nilai;
        $data->delete();

        $this->logActivity('Menghapus data master: ' . $nama);

        return redirect()->route('admin.datamaster')->with('success', 'Data master berhasil dihapus');
    }

    public function datamasterSearch(Request $request)
    {
        $query = $request->get('q', '');
        $tipe = $request->get('tipe', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = DataMaster::query()
            ->where(function($q) use ($query) {
                $q->where('kode', 'like', '%' . $query . '%')
                ->orWhere('nilai', 'like', '%' . $query . '%')
                ->orWhere('deskripsi', 'like', '%' . $query . '%');
            })
            ->when($tipe, function($q, $tipe) {
                return $q->where('tipe_data', $tipe);
            })
            ->select('id_master', 'tipe_data', 'kode', 'nilai', 'deskripsi', 'status')
            ->orderBy('tipe_data')
            ->orderBy('kode')
            ->limit(10)
            ->get();

        return response()->json($results);
    }

    // ========== MANAJEMEN PENGGUNA ==========
    
    public function users()
    {
        $users = User::with('orangTua')
            ->when(request('search'), function($query) {
                $search = request('search');
                $query->where(function($q) use ($search) {
                    $q->where('username', 'like', '%' . $search . '%')
                      ->orWhere('nama', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->when(request('role'), function($query) {
                $query->where('role', request('role'));
            })
            ->when(request('status'), function($query) {
                $query->where('status', request('status'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get unique roles for filter
        $roleList = User::select('role')
            ->distinct()
            ->orderBy('role')
            ->pluck('role');

        return view('admin.users.index', compact('users', 'roleList'));
    }

    /**
     * Show create form
     */
    public function usersCreate()
    {
        return view('admin.users.create');
    }

    /**
     * Store new User
     */
    public function usersStore(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6',
            'nama' => 'required|string|max:100',
            'role' => 'required|in:Admin,Petugas Posyandu,Petugas Puskesmas,Petugas DPPKB,Orang Tua',
            'email' => 'nullable|email|max:100',
            'no_telepon' => 'nullable|string|max:15',
            'status' => 'required|in:Aktif,Nonaktif'
        ], [
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'nama.required' => 'Nama lengkap wajib diisi',
            'role.required' => 'Role wajib dipilih',
            'email.email' => 'Format email tidak valid'
        ]);

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users')
            ->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Show edit form
     */
    public function usersEdit($id)
    {
        $user = User::with('orangTua')->findOrFail($id);
        
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update User
     */
    public function usersUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username,' . $id . ',id_user',
            'password' => 'nullable|string|min:6',
            'nama' => 'required|string|max:100',
            'role' => 'required|in:Admin,Petugas Posyandu,Petugas Puskesmas,Petugas DPPKB,Orang Tua',
            'email' => 'nullable|email|max:100',
            'no_telepon' => 'nullable|string|max:15',
            'status' => 'required|in:Aktif,Nonaktif'
        ]);

        // Only update password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users')
            ->with('success', 'Data pengguna berhasil diperbarui!');
    }

    /**
     * Delete User
     */
    public function usersDestroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting own account
        if ($user->id_user == auth()->id()) {
            return redirect()->route('admin.users')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        // Check if user has related data (Orang Tua)
        if ($user->orangTua) {
            return redirect()->route('admin.users')
                ->with('error', 'Pengguna tidak dapat dihapus karena memiliki data profil orang tua!');
        }

        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'Pengguna berhasil dihapus!');
    }

    /**
     * Search Users (for autocomplete)
     */
    public function usersSearch(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = User::where(function($q) use ($query) {
                $q->where('username', 'like', '%' . $query . '%')
                  ->orWhere('nama', 'like', '%' . $query . '%')
                  ->orWhere('email', 'like', '%' . $query . '%');
            })
            ->select('id_user', 'username', 'nama', 'email', 'role', 'status')
            ->orderBy('nama')
            ->limit(10)
            ->get();

        return response()->json($results);
    }

    // ========== MANAJEMEN PUSKESMAS ==========
    
    public function puskesmas()
    {
        $puskesmas = Puskesmas::withCount('posyandu')
            ->when(request('search'), function($query) {
                $search = request('search');
                $query->where(function($q) use ($search) {
                    $q->where('nama_puskesmas', 'like', '%' . $search . '%')
                      ->orWhere('kecamatan', 'like', '%' . $search . '%')
                      ->orWhere('kabupaten', 'like', '%' . $search . '%');
                });
            })
            ->when(request('kecamatan'), function($query) {
                $query->where('kecamatan', request('kecamatan'));
            })
            ->when(request('status'), function($query) {
                $query->where('status', request('status'));
            })
            ->orderBy('nama_puskesmas')
            ->paginate(10);

        // Get unique kecamatan for filter
        $kecamatanList = Puskesmas::select('kecamatan')
            ->distinct()
            ->orderBy('kecamatan')
            ->pluck('kecamatan');

        return view('admin.puskesmas.index', compact('puskesmas', 'kecamatanList'));
    }

    /**
     * Show create form
     */
    public function puskesmasCreate()
    {
        return view('admin.puskesmas.create');
    }

    /**
     * Store new Puskesmas
     */
    public function puskesmasStore(Request $request)
    {
        $validated = $request->validate([
            'nama_puskesmas' => 'required|string|max:100',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string|max:50',
            'kabupaten' => 'required|string|max:50',
            'no_telepon' => 'nullable|string|max:15',
            'status' => 'required|in:Aktif,Nonaktif'
        ], [
            'nama_puskesmas.required' => 'Nama Puskesmas wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'kecamatan.required' => 'Kecamatan wajib diisi',
            'kabupaten.required' => 'Kabupaten wajib diisi',
            'status.required' => 'Status wajib dipilih'
        ]);

        Puskesmas::create($validated);

        return redirect()->route('admin.puskesmas')
            ->with('success', 'Puskesmas berhasil ditambahkan!');
    }

    /**
     * Show edit form
     */
    public function puskesmasEdit($id)
    {
        $puskesmas = Puskesmas::withCount('posyandu')->findOrFail($id);
        
        return view('admin.puskesmas.edit', compact('puskesmas'));
    }

    /**
     * Update Puskesmas
     */
    public function puskesmasUpdate(Request $request, $id)
    {
        $puskesmas = Puskesmas::findOrFail($id);

        $validated = $request->validate([
            'nama_puskesmas' => 'required|string|max:100',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string|max:50',
            'kabupaten' => 'required|string|max:50',
            'no_telepon' => 'nullable|string|max:15',
            'status' => 'required|in:Aktif,Nonaktif'
        ]);

        $puskesmas->update($validated);

        return redirect()->route('admin.puskesmas')
            ->with('success', 'Data Puskesmas berhasil diperbarui!');
    }

    /**
     * Delete Puskesmas
     */
    public function puskesmasDestroy($id)
    {
        $puskesmas = Puskesmas::withCount('posyandu')->findOrFail($id);

        // Check if has Posyandu
        if ($puskesmas->posyandu_count > 0) {
            return redirect()->route('admin.puskesmas')
                ->with('error', "Puskesmas tidak dapat dihapus karena masih memiliki {$puskesmas->posyandu_count} Posyandu!");
        }

        $puskesmas->delete();

        return redirect()->route('admin.puskesmas')
            ->with('success', 'Puskesmas berhasil dihapus!');
    }

    /**
     * Search Puskesmas (for autocomplete)
     */
    public function puskesmasSearch(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = Puskesmas::where(function($q) use ($query) {
                $q->where('nama_puskesmas', 'like', '%' . $query . '%')
                  ->orWhere('kecamatan', 'like', '%' . $query . '%')
                  ->orWhere('kabupaten', 'like', '%' . $query . '%');
            })
            ->select('id_puskesmas', 'nama_puskesmas', 'kecamatan', 'kabupaten', 'status')
            ->orderBy('nama_puskesmas')
            ->limit(10)
            ->get();

        return response()->json($results);
    }

    // ========== MANAJEMEN POSYANDU ==========
    
    public function posyandu()
    {
        $posyandu = Posyandu::with('puskesmas')
            ->when(request('search'), function($query) {
                $search = request('search');
                $query->where(function($q) use ($search) {
                    $q->where('nama_posyandu', 'like', '%' . $search . '%')
                      ->orWhere('kelurahan', 'like', '%' . $search . '%')
                      ->orWhere('kecamatan', 'like', '%' . $search . '%');
                });
            })
            ->when(request('puskesmas'), function($query) {
                $query->where('id_puskesmas', request('puskesmas'));
            })
            ->when(request('kecamatan'), function($query) {
                $query->where('kecamatan', request('kecamatan'));
            })
            ->when(request('status'), function($query) {
                $query->where('status', request('status'));
            })
            ->orderBy('nama_posyandu')
            ->paginate(10);

        // Get Puskesmas list for filter
        $puskesmasList = Puskesmas::aktif()->orderBy('nama_puskesmas')->get();

        // Get unique kecamatan for filter
        $kecamatanList = Posyandu::select('kecamatan')
            ->distinct()
            ->orderBy('kecamatan')
            ->pluck('kecamatan');

        return view('admin.posyandu.index', compact('posyandu', 'puskesmasList', 'kecamatanList'));
    }

    /**
     * Show create form
     */
    public function posyanduCreate()
    {
        $puskesmasList = Puskesmas::aktif()->orderBy('nama_puskesmas')->get();
        
        return view('admin.posyandu.create', compact('puskesmasList'));
    }

    /**
     * Store new Posyandu
     */
    public function posyanduStore(Request $request)
    {
        $validated = $request->validate([
            'nama_posyandu' => 'required|string|max:100',
            'id_puskesmas' => 'required|exists:puskesmas,id_puskesmas',
            'alamat' => 'required|string',
            'kelurahan' => 'required|string|max:50',
            'kecamatan' => 'required|string|max:50',
            'status' => 'required|in:Aktif,Nonaktif'
        ], [
            'nama_posyandu.required' => 'Nama Posyandu wajib diisi',
            'id_puskesmas.required' => 'Puskesmas wajib dipilih',
            'id_puskesmas.exists' => 'Puskesmas tidak valid',
            'alamat.required' => 'Alamat wajib diisi',
            'kelurahan.required' => 'Kelurahan wajib diisi',
            'kecamatan.required' => 'Kecamatan wajib diisi',
            'status.required' => 'Status wajib dipilih'
        ]);

        Posyandu::create($validated);

        return redirect()->route('admin.posyandu')
            ->with('success', 'Posyandu berhasil ditambahkan!');
    }

    /**
     * Show edit form
     */
    public function posyanduEdit($id)
    {
        $posyandu = Posyandu::with('puskesmas')->findOrFail($id);
        $puskesmasList = Puskesmas::aktif()->orderBy('nama_puskesmas')->get();
        
        return view('admin.posyandu.edit', compact('posyandu', 'puskesmasList'));
    }

    /**
     * Update Posyandu
     */
    public function posyanduUpdate(Request $request, $id)
    {
        $posyandu = Posyandu::findOrFail($id);

        $validated = $request->validate([
            'nama_posyandu' => 'required|string|max:100',
            'id_puskesmas' => 'required|exists:puskesmas,id_puskesmas',
            'alamat' => 'required|string',
            'kelurahan' => 'required|string|max:50',
            'kecamatan' => 'required|string|max:50',
            'status' => 'required|in:Aktif,Nonaktif'
        ]);

        $posyandu->update($validated);

        return redirect()->route('admin.posyandu')
            ->with('success', 'Data Posyandu berhasil diperbarui!');
    }

    /**
     * Delete Posyandu
     */
    public function posyanduDestroy($id)
    {
        $posyandu = Posyandu::findOrFail($id);

        // Check if has data pengukuran
        $hasPengukuran = \DB::table('data_pengukuran')
            ->where('id_posyandu', $id)
            ->exists();

        if ($hasPengukuran) {
            return redirect()->route('admin.posyandu')
                ->with('error', "Posyandu tidak dapat dihapus karena masih memiliki data pengukuran!");
        }

        $posyandu->delete();

        return redirect()->route('admin.posyandu')
            ->with('success', 'Posyandu berhasil dihapus!');
    }

    /**
     * Search Posyandu (for autocomplete)
     */
    public function posyanduSearch(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = Posyandu::with('puskesmas')
            ->where(function($q) use ($query) {
                $q->where('nama_posyandu', 'like', '%' . $query . '%')
                  ->orWhere('kelurahan', 'like', '%' . $query . '%')
                  ->orWhere('kecamatan', 'like', '%' . $query . '%');
            })
            ->select('id_posyandu', 'nama_posyandu', 'id_puskesmas', 'kelurahan', 'kecamatan', 'status')
            ->orderBy('nama_posyandu')
            ->limit(10)
            ->get();

        return response()->json($results);
    }

    // ========== BROADCAST EDUKASI ==========
    
    public function broadcast()
    {
        // Get statistics
        $totalOrangTua = User::where('role', 'Orang Tua')
            ->where('status', 'Aktif')
            ->count();
        
        // Get recent broadcasts
        $recentBroadcasts = Notifikasi::where('tipe_notifikasi', 'Informasi')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('admin.broadcast.index', compact('totalOrangTua', 'recentBroadcasts'));
    }

    public function broadcastSend(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'pesan' => 'required|string',
            // Kita tetap biarkan validasi tipe_pengiriman agar tidak error jika form lama masih dipakai
            'tipe_pengiriman' => 'nullable', 
            'target_audience' => 'required|in:all,with_stunting,without_stunting'
        ]);

        try {
            // 2. TENTUKAN TARGET PENERIMA
            // Default: User Role 'Orang Tua' & Status 'Aktif'
            $query = User::where('role', 'Orang Tua')->where('status', 'Aktif');

            // Filter Tambahan
            if ($validated['target_audience'] == 'with_stunting') {
                $query->whereHas('orangTua.anak.dataPengukuran.dataStunting', function($q) {
                    $q->whereIn('status_stunting', ['Stunting Ringan', 'Stunting Sedang', 'Stunting Berat']);
                });
            } elseif ($validated['target_audience'] == 'without_stunting') {
                $query->whereHas('orangTua.anak.dataPengukuran.dataStunting', function($q) {
                    $q->where('status_stunting', 'Normal');
                });
            }

            // PENTING: Pastikan ada minimal 1 user Orang Tua yang punya email valid di Database
            // $query = User::where('email', 'email_tes_anda@gmail.com'); // <-- Pakai ini cuma kalau mau tes ke diri sendiri

            $targetUsers = $query->get();

            if ($targetUsers->isEmpty()) {
                return redirect()->route('admin.broadcast')
                    ->with('warning', 'Tidak ada Orang Tua yang ditemukan untuk kategori ini.');
            }

            // 3. EKSEKUSI PENGIRIMAN (EMAIL ONLY)
            $countEmail = 0;

            foreach ($targetUsers as $user) {
                if ($user->email) {
                    try {
                        // Kirim Langsung (Tanpa Antrian)
                        Mail::to($user->email)
                            ->send(new BroadcastMail($validated['judul'], $validated['pesan']));
                        
                        $countEmail++;
                        
                        // Simpan Notifikasi ke Database
                        Notifikasi::create([
                            'id_user' => $user->id_user,
                            'judul' => $validated['judul'],
                            'pesan' => $validated['pesan'],
                            'tipe_notifikasi' => 'Informasi',
                            'status_baca' => 'Belum Dibaca',
                            'tanggal_kirim' => now()
                        ]);

                    } catch (\Exception $e) {
                        // Jika gagal, catat log saja, jangan hentikan proses untuk user lain
                        Log::error("Gagal kirim email ke " . $user->email . ": " . $e->getMessage());
                    }
                }
            }

            return redirect()->route('admin.broadcast')
                ->with('success', "Broadcast berhasil dikirim ke $countEmail Orang Tua via Email.");

        } catch (\Exception $e) {
            return redirect()->route('admin.broadcast')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Send WhatsApp message (placeholder - implement with actual gateway)
     */
    private function sendWhatsAppMessage($phoneNumber, $title, $message)
    {
        try {
            // TODO: Implement actual WhatsApp Gateway API
            // Example: Use Fonnte, Wablas, or similar service
            
            // For now, just log
            \Log::info("WhatsApp sent to {$phoneNumber}: {$title}");
            
            return true;
        } catch (\Exception $e) {
            \Log::error("WhatsApp failed to {$phoneNumber}: " . $e->getMessage());
            return false;
        }
    }

    public function broadcastHistory()
    {
        $broadcasts = Notifikasi::where('tipe_notifikasi', 'Informasi')
            ->with('user.orangTua')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.broadcast.history', compact('broadcasts'));
    }

    // ========== AUDIT LOG ==========
    
    public function auditLog()
    {
        // Get statistics
        $totalLogs = AuditLog::count();
        $todayLogs = AuditLog::whereDate('created_at', today())->count();
        $weekLogs = AuditLog::where('created_at', '>=', now()->subDays(7))->count();
        
        // Get recent activities grouped by date
        $recentActivities = AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get()
            ->groupBy(function($log) {
                return $log->created_at->format('Y-m-d');
            });
        
        // Get top users by activity
        $topUsers = AuditLog::selectRaw('id_user, COUNT(*) as activity_count')
            ->with('user')
            ->whereNotNull('id_user')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('id_user')
            ->orderByDesc('activity_count')
            ->limit(5)
            ->get();
        
        // Get action distribution
        $actionStats = AuditLog::selectRaw('action, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('action')
            ->get();
        
        return view('admin.audit-log.index', compact(
            'totalLogs',
            'todayLogs', 
            'weekLogs',
            'recentActivities',
            'topUsers',
            'actionStats'
        ));
    }

    public function auditLogFilter(Request $request)
    {
        $query = AuditLog::with('user');
        
        // Filter by user
        if ($request->filled('user')) {
            $query->where('id_user', $request->user);
        }
        
        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        
        // Filter by module
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Search
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }
        
        $logs = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Get filter options
        $users = User::select('id_user', 'nama', 'username')->get();
        $modules = AuditLog::distinct()->pluck('module');
        $actions = ['CREATE', 'UPDATE', 'DELETE', 'LOGIN', 'LOGOUT', 'VIEW'];
        
        return view('admin.audit-log.filter', compact('logs', 'users', 'modules', 'actions'));
    }

    public function auditLogDetail($id)
    {
        $log = AuditLog::with('user')->findOrFail($id);
        
        // If request wants JSON (for AJAX)
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'log' => $log
            ]);
        }
        
        // Otherwise return view
        return view('admin.audit-log.detail', compact('log'));
    }

    public function auditLogExport(Request $request)
    {
        $query = AuditLog::with('user');
        
        // Apply same filters as auditLogFilter
        if ($request->filled('user')) {
            $query->where('id_user', $request->user);
        }
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $logs = $query->orderBy('created_at', 'desc')->get();
        
        // Generate CSV
        $filename = 'audit-log-' . now()->format('Y-m-d-His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];
        
        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['Timestamp', 'User', 'Action', 'Module', 'Description', 'IP Address']);
            
            // Data
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->user?->nama ?? 'System',
                    $log->action,
                    $log->module,
                    $log->description,
                    $log->ip_address
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    // ========== HELPER FUNCTIONS ==========
    
    private function logActivity($activity)
    {
        Log::info('[ADMIN] ' . auth()->user()->nama . ' - ' . $activity);
        
        // Bisa juga simpan ke database jika ada tabel audit_log
        // AuditLog::create([
        //     'user_id' => auth()->id(),
        //     'activity' => $activity,
        //     'ip_address' => request()->ip()
        // ]);
    }

    private function getRecentActivities($limit = 10)
    {
        // Implementasi pengambilan log aktivitas
        // Untuk demo, return data dummy
        return collect([
            (object)[
                'user' => 'Admin Sistem',
                'action' => 'Menambahkan data master baru',
                'time' => '2 menit yang lalu',
                'icon' => 'plus',
                'color' => 'blue'
            ],
            (object)[
                'user' => 'Petugas Posyandu Melati',
                'action' => 'Input data pengukuran 5 anak',
                'time' => '15 menit yang lalu',
                'icon' => 'upload',
                'color' => 'green'
            ],
            (object)[
                'user' => 'Petugas Puskesmas Lumpue',
                'action' => 'Validasi 12 data stunting',
                'time' => '1 jam yang lalu',
                'icon' => 'check',
                'color' => 'purple'
            ],
            (object)[
                'user' => 'Sistem',
                'action' => 'Mengirim notifikasi ke 8 orang tua',
                'time' => '2 jam yang lalu',
                'icon' => 'bell',
                'color' => 'orange'
            ]
        ])->take($limit);
    }

    private function getOrangTuaByTarget($target, $id_target = null)
    {
        if ($target == 'semua') {
            return OrangTua::whereHas('user', function($q) {
                $q->where('status', 'Aktif');
            })->get();
        }
        
        if ($target == 'puskesmas' && $id_target) {
            return OrangTua::whereHas('anak.posyandu', function($q) use ($id_target) {
                $q->where('id_puskesmas', $id_target);
            })->get();
        }
        
        if ($target == 'posyandu' && $id_target) {
            return OrangTua::whereHas('anak', function($q) use ($id_target) {
                $q->where('id_posyandu', $id_target);
            })->get();
        }
        
        return collect();
    }
}