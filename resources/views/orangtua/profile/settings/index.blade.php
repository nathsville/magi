@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
    @include('orangtua.partials.header')

    <div class="container mx-auto px-4 py-6 max-w-5xl">
        {{-- Back Button --}}
        <div class="mb-4">
            <a href="{{ route('orangtua.dashboard') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 font-medium transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
            </a>
        </div>

        {{-- Page Header --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                <i class="fas fa-cog text-purple-600 mr-3"></i>Pengaturan
            </h1>
            <p class="text-gray-600">Sesuaikan preferensi dan pengaturan aplikasi sesuai kebutuhan keluarga Anda</p>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow animate-fade-in">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-xl mr-3"></i>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Settings Form --}}
        <form method="POST" action="{{ route('orangtua.settings.update') }}" id="settingsForm">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                {{-- Notification Settings --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 pb-3 border-b border-gray-200 flex items-center">
                        <i class="fas fa-bell text-purple-600 mr-2"></i>Pengaturan Notifikasi
                    </h3>

                    <div class="space-y-4">
                        {{-- Email Notifications --}}
                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-xl hover:border-purple-500 transition cursor-pointer group">
                            <input type="checkbox" 
                                   name="notifikasi_email" 
                                   value="1"
                                   {{ $settings['notifikasi_email'] ? 'checked' : '' }}
                                   class="mt-1 w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="font-semibold text-gray-800 group-hover:text-purple-600 transition">
                                        <i class="fas fa-envelope text-purple-500 mr-2"></i>Notifikasi Email
                                    </p>
                                    <span class="text-xs px-3 py-1 bg-purple-100 text-purple-700 rounded-full font-medium">Direkomendasikan</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">Terima pemberitahuan penting melalui email tentang kesehatan anak</p>
                            </div>
                        </label>

                        {{-- WhatsApp Notifications --}}
                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-xl hover:border-purple-500 transition cursor-pointer group">
                            <input type="checkbox" 
                                   name="notifikasi_whatsapp" 
                                   value="1"
                                   {{ $settings['notifikasi_whatsapp'] ? 'checked' : '' }}
                                   class="mt-1 w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="font-semibold text-gray-800 group-hover:text-purple-600 transition">
                                        <i class="fab fa-whatsapp text-green-500 mr-2"></i>Notifikasi WhatsApp
                                    </p>
                                    <span class="text-xs px-3 py-1 bg-green-100 text-green-700 rounded-full font-medium">Populer</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">Terima notifikasi instan via WhatsApp untuk update terbaru</p>
                            </div>
                        </label>

                        {{-- Browser Notifications --}}
                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-xl hover:border-purple-500 transition cursor-pointer group">
                            <input type="checkbox" 
                                   name="notifikasi_browser" 
                                   value="1"
                                   {{ $settings['notifikasi_browser'] ? 'checked' : '' }}
                                   class="mt-1 w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold text-gray-800 group-hover:text-purple-600 transition">
                                    <i class="fas fa-desktop text-blue-500 mr-2"></i>Notifikasi Browser
                                </p>
                                <p class="text-sm text-gray-600 mt-1">Tampilkan notifikasi pop-up di browser saat ada update</p>
                            </div>
                        </label>

                        {{-- Sound Notifications --}}
                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-xl hover:border-purple-500 transition cursor-pointer group">
                            <input type="checkbox" 
                                   name="notifikasi_sound" 
                                   value="1"
                                   {{ $settings['notifikasi_sound'] ? 'checked' : '' }}
                                   class="mt-1 w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold text-gray-800 group-hover:text-purple-600 transition">
                                    <i class="fas fa-volume-up text-orange-500 mr-2"></i>Suara Notifikasi
                                </p>
                                <p class="text-sm text-gray-600 mt-1">Putar suara saat menerima notifikasi baru</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Reminder Settings --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 pb-3 border-b border-gray-200 flex items-center">
                        <i class="fas fa-calendar-check text-purple-600 mr-2"></i>Pengingat Otomatis
                    </h3>

                    <div class="space-y-4">
                        {{-- Posyandu Reminder --}}
                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-xl hover:border-purple-500 transition cursor-pointer group">
                            <input type="checkbox" 
                                   name="pengingat_posyandu" 
                                   value="1"
                                   {{ $settings['pengingat_posyandu'] ? 'checked' : '' }}
                                   class="mt-1 w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold text-gray-800 group-hover:text-purple-600 transition">
                                    <i class="fas fa-hospital text-teal-500 mr-2"></i>Pengingat Jadwal Posyandu
                                </p>
                                <p class="text-sm text-gray-600 mt-1">Dapatkan pengingat sebelum jadwal posyandu bulanan</p>
                            </div>
                        </label>

                        {{-- Immunization Reminder --}}
                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-xl hover:border-purple-500 transition cursor-pointer group">
                            <input type="checkbox" 
                                   name="pengingat_imunisasi" 
                                   value="1"
                                   {{ $settings['pengingat_imunisasi'] ? 'checked' : '' }}
                                   class="mt-1 w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold text-gray-800 group-hover:text-purple-600 transition">
                                    <i class="fas fa-syringe text-red-500 mr-2"></i>Pengingat Jadwal Imunisasi
                                </p>
                                <p class="text-sm text-gray-600 mt-1">Ingatkan saat jadwal imunisasi anak tiba</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Privacy Settings --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 pb-3 border-b border-gray-200 flex items-center">
                        <i class="fas fa-shield-alt text-purple-600 mr-2"></i>Privasi & Keamanan
                    </h3>

                    <div class="space-y-4">
                        {{-- Data Privacy --}}
                        <div class="p-4 border-2 border-gray-200 rounded-xl">
                            <label class="block font-semibold text-gray-800 mb-3">
                                <i class="fas fa-lock text-purple-500 mr-2"></i>Privasi Data Anak
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-purple-50 transition cursor-pointer">
                                    <input type="radio" 
                                           name="privasi_data" 
                                           value="private"
                                           {{ $settings['privasi_data'] == 'private' ? 'checked' : '' }}
                                           class="w-4 h-4 text-purple-600 border-gray-300 focus:ring-purple-500">
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-800">Pribadi (Private)</p>
                                        <p class="text-xs text-gray-600">Hanya Anda dan petugas kesehatan yang dapat melihat data</p>
                                    </div>
                                </label>
                                <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-purple-50 transition cursor-pointer">
                                    <input type="radio" 
                                           name="privasi_data" 
                                           value="public"
                                           {{ $settings['privasi_data'] == 'public' ? 'checked' : '' }}
                                           class="w-4 h-4 text-purple-600 border-gray-300 focus:ring-purple-500">
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-800">Publik (Untuk Penelitian)</p>
                                        <p class="text-xs text-gray-600">Data anonim dapat digunakan untuk keperluan penelitian kesehatan</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Export Data --}}
                        <div class="p-4 bg-blue-50 border-2 border-blue-200 rounded-xl">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="font-semibold text-blue-800 mb-1">
                                        <i class="fas fa-download text-blue-600 mr-2"></i>Unduh Data Pribadi
                                    </p>
                                    <p class="text-sm text-blue-700">Dapatkan salinan lengkap semua data keluarga Anda dalam format JSON</p>
                                </div>
                                <a href="{{ route('orangtua.data.export') }}" 
                                   class="ml-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow text-sm font-medium whitespace-nowrap">
                                    <i class="fas fa-download mr-2"></i>Unduh
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Display Settings --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 pb-3 border-b border-gray-200 flex items-center">
                        <i class="fas fa-palette text-purple-600 mr-2"></i>Tampilan
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Language --}}
                        <div>
                            <label class="block font-semibold text-gray-800 mb-3">
                                <i class="fas fa-language text-purple-500 mr-2"></i>Bahasa
                            </label>
                            <select name="bahasa" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="id" {{ $settings['bahasa'] == 'id' ? 'selected' : '' }}>🇮🇩 Bahasa Indonesia</option>
                                <option value="en" {{ $settings['bahasa'] == 'en' ? 'selected' : '' }}>🇬🇧 English</option>
                            </select>
                        </div>

                        {{-- Theme --}}
                        <div>
                            <label class="block font-semibold text-gray-800 mb-3">
                                <i class="fas fa-moon text-purple-500 mr-2"></i>Tema
                            </label>
                            <select name="tema" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="light" {{ $settings['tema'] == 'light' ? 'selected' : '' }}>☀️ Terang (Light)</option>
                                <option value="dark" {{ $settings['tema'] == 'dark' ? 'selected' : '' }}>🌙 Gelap (Dark) - Segera Hadir</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                        <p class="text-sm text-gray-600 flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                            Fitur tema gelap dan pengaturan tampilan lainnya akan segera hadir
                        </p>
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('orangtua.dashboard') }}" 
                           class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-lg hover:from-purple-700 hover:to-pink-700 transition shadow-lg">
                            <i class="fas fa-save mr-2"></i>Simpan Pengaturan
                        </button>
                    </div>
                </div>

                {{-- Danger Zone --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-red-200">
                    <h3 class="text-xl font-bold text-red-600 mb-4 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Zona Berbahaya
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Tindakan di bawah ini bersifat permanen dan tidak dapat dibatalkan. Harap berhati-hati.
                    </p>
                    
                    <button type="button" 
                            onclick="showDeleteAccountModal()"
                            class="px-6 py-3 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-user-times mr-2"></i>Hapus Akun Permanen
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Delete Account Modal --}}
<div id="deleteAccountModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 animate-scale-in">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-red-600">
                <i class="fas fa-exclamation-triangle mr-2"></i>Konfirmasi Penghapusan Akun
            </h3>
            <button onclick="closeDeleteAccountModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div class="mb-6">
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                <p class="text-sm text-red-700 font-medium mb-2">⚠️ Peringatan:</p>
                <ul class="text-xs text-red-600 space-y-1 ml-4 list-disc">
                    <li>Semua data anak akan dihapus permanen</li>
                    <li>Riwayat pengukuran akan hilang</li>
                    <li>Akun tidak dapat dipulihkan</li>
                    <li>Proses membutuhkan waktu hingga 30 hari</li>
                </ul>
            </div>

            <form method="POST" action="{{ route('orangtua.account.delete-request') }}" id="deleteAccountForm">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               name="password" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Alasan Penghapusan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="alasan" 
                                  rows="3"
                                  required
                                  maxlength="500"
                                  placeholder="Mohon jelaskan alasan Anda..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"></textarea>
                        <p class="text-xs text-gray-500 mt-1">Maksimal 500 karakter</p>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 mt-6">
                    <button type="button" 
                            onclick="closeDeleteAccountModal()"
                            class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-6 py-3 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition">
                        Ya, Hapus Akun Saya
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('orangtua.settings.scripts.index')
@endsection