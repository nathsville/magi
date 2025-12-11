@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teal-50 via-cyan-50 to-blue-50">
    @include('posyandu.partials.header')

    <div class="container mx-auto px-4 py-6 max-w-4xl">
        {{-- Back Button --}}
        <div class="mb-4">
            <a href="{{ route('posyandu.dashboard') }}" class="inline-flex items-center text-teal-600 hover:text-teal-700 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
            </a>
        </div>

        {{-- Page Header --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                <i class="fas fa-cog text-teal-600 mr-3"></i>Pengaturan
            </h1>
            <p class="text-gray-600">Sesuaikan preferensi dan pengaturan aplikasi</p>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            @include('posyandu.partials.alert-success', ['message' => session('success')])
        @endif

        {{-- Settings Form --}}
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <form method="POST" action="{{ route('posyandu.settings.update') }}">
                @csrf
                @method('PUT')

                {{-- Notification Settings --}}
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">
                        <i class="fas fa-bell text-teal-600 mr-2"></i>Notifikasi
                    </h3>

                    <div class="space-y-4">
                        {{-- Email Notifications --}}
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:border-teal-500 transition cursor-pointer">
                            <input type="checkbox" 
                                   name="notifikasi_email" 
                                   value="1"
                                   {{ session('settings.notifikasi_email', true) ? 'checked' : '' }}
                                   class="w-5 h-5 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                            <div class="ml-4">
                                <p class="font-semibold text-gray-800">Notifikasi Email</p>
                                <p class="text-sm text-gray-600">Terima notifikasi melalui email</p>
                            </div>
                        </label>

                        {{-- Browser Notifications --}}
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:border-teal-500 transition cursor-pointer">
                            <input type="checkbox" 
                                   name="notifikasi_browser" 
                                   value="1"
                                   {{ session('settings.notifikasi_browser', true) ? 'checked' : '' }}
                                   class="w-5 h-5 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                            <div class="ml-4">
                                <p class="font-semibold text-gray-800">Notifikasi Browser</p>
                                <p class="text-sm text-gray-600">Tampilkan notifikasi di browser</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Security Settings --}}
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">
                        <i class="fas fa-shield-alt text-teal-600 mr-2"></i>Keamanan
                    </h3>

                    <div class="space-y-4">
                        {{-- Auto Logout --}}
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:border-teal-500 transition cursor-pointer">
                            <input type="checkbox" 
                                   name="auto_logout" 
                                   value="1"
                                   {{ session('settings.auto_logout', false) ? 'checked' : '' }}
                                   id="autoLogoutToggle"
                                   class="w-5 h-5 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold text-gray-800">Auto Logout</p>
                                <p class="text-sm text-gray-600">Logout otomatis setelah tidak aktif</p>
                            </div>
                        </label>

                        {{-- Auto Logout Duration --}}
                        <div id="autoLogoutDuration" class="pl-9 {{ session('settings.auto_logout', false) ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Durasi (menit)
                            </label>
                            <input type="number" 
                                   name="auto_logout_duration" 
                                   value="{{ session('settings.auto_logout_duration', 30) }}"
                                   min="5"
                                   max="120"
                                   class="w-32 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">Minimum 5 menit, maksimum 120 menit</p>
                        </div>
                    </div>
                </div>

                {{-- Display Settings --}}
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">
                        <i class="fas fa-palette text-teal-600 mr-2"></i>Tampilan
                    </h3>

                    <div class="p-4 bg-gray-50 border-2 border-gray-200 rounded-lg">
                        <p class="text-sm text-gray-600 flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                            Fitur pengaturan tampilan akan segera hadir
                        </p>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('posyandu.dashboard') }}" 
                       class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 text-white font-bold rounded-lg hover:from-teal-700 hover:to-cyan-700 transition shadow-lg">
                        <i class="fas fa-save mr-2"></i>Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

        {{-- Danger Zone --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 mt-6 border-2 border-red-200">
            <h3 class="text-xl font-bold text-red-600 mb-4">
                <i class="fas fa-exclamation-triangle mr-2"></i>Zona Berbahaya
            </h3>
            <p class="text-sm text-gray-600 mb-4">
                Tindakan di bawah ini bersifat permanen dan tidak dapat dibatalkan.
            </p>
            <button onclick="alert('Fitur ini memerlukan konfirmasi admin')" 
                    class="px-6 py-3 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-user-times mr-2"></i>Nonaktifkan Akun
            </button>
        </div>
    </div>
</div>

<script>
document.getElementById('autoLogoutToggle').addEventListener('change', function() {
    const durationDiv = document.getElementById('autoLogoutDuration');
    if (this.checked) {
        durationDiv.classList.remove('hidden');
    } else {
        durationDiv.classList.add('hidden');
    }
});
</script>
@endsection