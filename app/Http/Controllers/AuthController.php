<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirect berdasarkan role
            return $this->redirectBasedOnRole($user->role);
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

    private function redirectBasedOnRole($role)
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