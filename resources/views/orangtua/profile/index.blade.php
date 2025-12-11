@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
    @include('orangtua.partials.header')

    <div class="container mx-auto px-4 py-6 max-w-6xl">
        {{-- Back Button --}}
        <div class="mb-4">
            <a href="{{ route('orangtua.dashboard') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 font-medium transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
            </a>
        </div>

        {{-- Page Header --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-user-circle text-purple-600 mr-3"></i>Profil Saya
                    </h1>
                    <p class="text-gray-600">Kelola informasi profil dan keamanan akun keluarga Anda</p>
                </div>
                <a href="{{ route('orangtua.data.export') }}" 
                   class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition shadow-lg text-sm">
                    <i class="fas fa-download mr-2"></i>Unduh Data Pribadi
                </a>
            </div>
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

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow animate-fade-in">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div class="bg-orange-50 border-l-4 border-orange-500 text-orange-700 p-4 rounded-lg mb-6 shadow animate-fade-in">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-xl mr-3"></i>
                    <p class="font-medium">{{ session('warning') }}</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column: Profile Card --}}
            <div class="space-y-6">
                {{-- Avatar Card --}}
                <div class="bg-gradient-to-br from-purple-500 via-purple-600 to-pink-600 rounded-2xl shadow-lg p-6 text-white text-center">
                    <div class="w-24 h-24 bg-white bg-opacity-20 rounded-full flex items-center justify-center text-5xl mx-auto mb-4 backdrop-blur-sm">
                        👨‍👩‍👧‍👦
                    </div>
                    <h3 class="text-xl font-bold mb-1">{{ $user->nama }}</h3>
                    <p class="text-sm text-purple-100 mb-4">{{ $user->role }}</p>
                    <div class="flex items-center justify-center space-x-2 mb-3">
                        <span class="px-3 py-1 bg-white bg-opacity-20 rounded-full text-xs font-medium backdrop-blur-sm">
                            {{ $user->status }}
                        </span>
                        @if($user->email_verified_at)
                        <span class="px-3 py-1 bg-green-500 bg-opacity-80 rounded-full text-xs font-medium">
                            <i class="fas fa-check-circle mr-1"></i>Terverifikasi
                        </span>
                        @endif
                    </div>
                    <p class="text-xs text-purple-100">
                        Bergabung {{ $stats['account_age'] }}
                    </p>
                </div>

                {{-- Stats Card --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-chart-bar text-purple-600 mr-2"></i>Statistik Keluarga
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <div class="flex items-center">
                                <i class="fas fa-child text-purple-500 mr-2"></i>
                                <span class="text-sm text-gray-600">Jumlah Anak</span>
                            </div>
                            <span class="text-sm font-bold text-purple-600">{{ $stats['jumlah_anak'] }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <div class="flex items-center">
                                <i class="fas fa-ruler text-purple-500 mr-2"></i>
                                <span class="text-sm text-gray-600">Total Pengukuran</span>
                            </div>
                            <span class="text-sm font-bold text-purple-600">{{ $stats['total_pengukuran'] }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center">
                                <i class="fas fa-clock text-purple-500 mr-2"></i>
                                <span class="text-sm text-gray-600">Aktivitas Terakhir</span>
                            </div>
                            <span class="text-xs font-medium text-gray-700">
                                @if($stats['last_activity'])
                                    {{ \Carbon\Carbon::parse($stats['last_activity']->created_at)->diffForHumans() }}
                                @else
                                    Belum ada
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-link text-purple-600 mr-2"></i>Tautan Cepat
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('orangtua.settings') }}" class="flex items-center justify-between p-3 bg-gray-50 hover:bg-purple-50 rounded-lg transition group">
                            <div class="flex items-center">
                                <i class="fas fa-cog text-gray-500 group-hover:text-purple-600 mr-3"></i>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-purple-600">Pengaturan</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-purple-600"></i>
                        </a>
                        <a href="{{ route('orangtua.notifikasi.index') }}" class="flex items-center justify-between p-3 bg-gray-50 hover:bg-purple-50 rounded-lg transition group">
                            <div class="flex items-center">
                                <i class="fas fa-bell text-gray-500 group-hover:text-purple-600 mr-3"></i>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-purple-600">Notifikasi</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-purple-600"></i>
                        </a>
                        <a href="{{ route('orangtua.anak.riwayat') }}" class="flex items-center justify-between p-3 bg-gray-50 hover:bg-purple-50 rounded-lg transition group">
                            <div class="flex items-center">
                                <i class="fas fa-history text-gray-500 group-hover:text-purple-600 mr-3"></i>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-purple-600">Riwayat Tumbuh Kembang</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-purple-600"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Right Column: Forms --}}
            <div class="lg:col-span-2 space-y-6">
                @include('orangtua.profile.partials.edit-profile-form', ['user' => $user, 'orangTua' => $orangTua])
                @include('orangtua.profile.partials.change-password-form')
            </div>
        </div>
    </div>
</div>

@include('orangtua.profile.scripts.index')
@endsection