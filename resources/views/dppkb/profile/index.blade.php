@extends('layouts.app')

@section('title', 'Profile Akun')
@section('breadcrumb', 'DPPKB / Profile')

@section('sidebar')
    @include('dppkb.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6 animate-fade-in">
    {{-- Header --}}
    <div class="flex items-center space-x-4">
        <div class="w-12 h-12 bg-[#000878] rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Akun</h1>
            <p class="text-sm text-gray-600 mt-1">Kelola informasi profil dan keamanan akun Anda</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kolom Kiri: Edit Profile (2/3 width) --}}
        <div class="lg:col-span-2 space-y-6">
            @include('dppkb.profile.partials.edit-profile-form')
        </div>

        {{-- Kolom Kanan: Ganti Password & Info (1/3 width) --}}
        <div class="space-y-6">
            @include('dppkb.profile.partials.change-password-form')
        </div>
    </div>
</div>

{{-- Style Tambahan untuk Animasi & Scrollbar --}}
<style>
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.4s ease-out; }
    
    /* Transisi smooth untuk progress bar */
    #strengthBar { transition: width 0.3s ease, background-color 0.3s ease; }
</style>

{{-- Script Interaktif (Diadaptasi untuk DPPKB) --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Password Strength Checker
    const newPasswordInput = document.getElementById('newPassword');
    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            checkPasswordStrength(this.value);
        });
    }

    // 2. Form Validation Listener
    const passwordForm = document.getElementById('passwordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            const newPass = document.getElementById('newPassword').value;
            const confirmPass = document.getElementById('password_confirmation').value;

            if (newPass && newPass !== confirmPass) {
                e.preventDefault();
                showToast('error', 'Konfirmasi password tidak cocok');
                return false;
            }
            if (newPass && newPass.length < 8) {
                e.preventDefault();
                showToast('error', 'Password minimal 8 karakter');
                return false;
            }
            // Jika valid, tampilkan loading
            showLoadingOverlay();
        });
    }
    
    // Listener untuk form profil (Loading effect)
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function() {
            showLoadingOverlay();
        });
    }
});

// Fungsi Toggle Visibility Password
function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i'); // Mengasumsikan pakai FontAwesome atau SVG path logic
    
    if (input.type === 'password') {
        input.type = 'text';
        // Ganti icon logic (sesuaikan dengan icon library yang dipakai)
        button.innerHTML = `<svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>`;
    } else {
        input.type = 'password';
        button.innerHTML = `<svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>`;
    }
}

// Fungsi Cek Kekuatan Password
function checkPasswordStrength(password) {
    const strengthDiv = document.getElementById('passwordStrength');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    
    if (!password) {
        strengthDiv.classList.add('hidden');
        return;
    }
    
    strengthDiv.classList.remove('hidden');
    let strength = 0;
    
    if (password.length >= 8) strength += 25;
    if (password.length >= 12) strength += 25;
    if (/[A-Z]/.test(password)) strength += 15;
    if (/[0-9]/.test(password)) strength += 15;
    if (/[^A-Za-z0-9]/.test(password)) strength += 20;
    
    let color = '#ef4444'; // Merah
    let text = 'Lemah';
    
    if (strength >= 90) { color = '#000878'; text = 'Sangat Kuat'; } // Pakai warna brand DPPKB
    else if (strength >= 70) { color = '#10b981'; text = 'Kuat'; }
    else if (strength >= 40) { color = '#f59e0b'; text = 'Sedang'; }
    
    strengthBar.style.width = strength + '%';
    strengthBar.style.backgroundColor = color;
    strengthText.textContent = text;
    strengthText.style.color = color;
}

// UI Helpers
function showLoadingOverlay() {
    const overlay = document.createElement('div');
    overlay.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-50 backdrop-blur-sm';
    overlay.innerHTML = `
        <div class="bg-white rounded-2xl p-6 text-center shadow-2xl">
            <div class="w-12 h-12 border-4 border-[#000878] border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
            <p class="font-bold text-gray-800">Memproses...</p>
        </div>`;
    document.body.appendChild(overlay);
}

function showToast(type, message) {
    const bg = type === 'error' ? 'bg-red-600' : 'bg-green-600';
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 ${bg} text-white px-6 py-3 rounded-lg shadow-xl z-50 animate-fade-in`;
    toast.innerHTML = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 4000);
}
</script>
@endsection