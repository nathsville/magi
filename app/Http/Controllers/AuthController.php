<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // Tambahan
use App\Mail\SendOtpMail; // Tambahan: Pastikan Mailable sudah dibuat
use App\Models\User;
use Carbon\Carbon; // Tambahan

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        // Pastikan session bersih dulu sebelum memulai proses baru
        // Ini mencegah error jika ada session nyangkut dari login sebelumnya
        $request->session()->invalidate(); 

        // 1. Cek Validasi Username & Password (TANPA LOGIN)
        if (Auth::validate($credentials)) {
            
            // Ambil data user
            $user = User::where('username', $request->username)->first();

            $bypassOtp = true; 

            if ($bypassOtp) {
                Auth::login($user);
                $request->session()->regenerate();
                return self::redirectBasedOnRole($user->role);
            }
            
            // 2. Generate Kode OTP
            $code = rand(100000, 999999);
            
            // 3. Simpan OTP ke Database
            $user->update([
                'otp_code' => $code,
                'otp_expires_at' => Carbon::now()->addMinutes(5)
            ]);

            // 4. Kirim Email
            if ($user->email) {
                try {
                    Mail::to($user->email)->send(new SendOtpMail($code));
                } catch (\Exception $e) {
                    // Jangan return error, lanjut saja ke halaman OTP biar user tau logikanya jalan
                    // return back()->withErrors(['username' => 'Gagal kirim email...']); 
                }
            } else {
                return back()->withErrors(['username' => 'Akun ini tidak memiliki email terdaftar.']);
            }

            // 5. Simpan ID sementara di session (PERBAIKAN UTAMA DI SINI)
            // Gunakan 'id_user' sesuai database Anda
            session(['otp_user_id' => $user->id_user]); 
            
            // 6. Redirect ke halaman OTP
            // Pastikan nama route ini SAMA dengan yang ada di web.php ('otp.show' atau 'otp.view')
            return redirect()->route('otp.show'); 
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Ubah menjadi PUBLIC STATIC agar bisa dipanggil dari OtpController
    public static function redirectBasedOnRole($role)
    {
        return match($role) {
            'Admin' => redirect()->route('admin.dashboard'),
            'Petugas Posyandu' => redirect()->route('posyandu.dashboard'),
            'Petugas Puskesmas' => redirect()->route('puskesmas.dashboard'),
            'Petugas DPPKB' => redirect()->route('dppkb.dashboard'),
            'Orang Tua' => redirect()->route('orangtua.dashboard'),
            default => redirect()->route('login'),
        };
    }
}