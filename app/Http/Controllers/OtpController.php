<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use App\Models\User;
use Carbon\Carbon;

class OtpController extends Controller
{
    // Tampilkan Form
    public function show()
    {
        // Jika tidak ada session user sementara, tendang ke login
        if (!session('otp_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.verify-otp');
    }

    // Proses Verifikasi
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $userId = session('otp_user_id');
        if (!$userId) return redirect()->route('login');

        $user = User::find($userId);

        // Cek Kode & Expired
        if ($user && $user->otp_code == $request->otp && Carbon::now()->lessThan($user->otp_expires_at)) {
            
            // === LOGIN RESMI ===
            Auth::login($user);
            $request->session()->regenerate();

            // Bersihkan OTP
            $user->update(['otp_code' => null, 'otp_expires_at' => null]);
            session()->forget('otp_user_id');

            // Panggil helper redirect milik AuthController agar konsisten
            return AuthController::redirectBasedOnRole($user->role);
        }

        return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kadaluwarsa.']);
    }

    // Kirim Ulang Kode
    public function resend()
    {
        $userId = session('otp_user_id');
        if (!$userId) return redirect()->route('login');

        $user = User::find($userId);
        
        $code = rand(100000, 999999);
        $user->update([
            'otp_code' => $code,
            'otp_expires_at' => Carbon::now()->addMinutes(5)
        ]);

        Mail::to($user->email)->send(new SendOtpMail($code));

        return back()->with('status', 'Kode baru telah dikirim ke email Anda.');
    }
}