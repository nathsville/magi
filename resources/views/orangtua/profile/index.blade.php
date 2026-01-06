@extends('layouts.app')

@section('title', 'Profil Saya')
@section('breadcrumb', 'Orang Tua / Profil Saya')

@section('sidebar')
    @include('orangtua.sidebar.sidebar-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- 1. Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-[#000878] rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
                <p class="text-sm text-gray-600 mt-1">Kelola informasi akun dan data keluarga</p>
            </div>
        </div>
        
        <div class="flex gap-3">
            <a href="{{ route('orangtua.dashboard') }}" 
                class="flex items-center px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="font-medium text-sm">Kembali</span>
            </a>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        @include('posyandu.partials.alert-success', ['message' => session('success')])
    @elseif(session('error'))
        @include('posyandu.partials.alert-error', ['message' => session('error')])
    @endif
    
    @if($errors->any())
        @include('posyandu.partials.alert-error', ['message' => 'Terdapat kesalahan pada form. Silakan periksa kembali inputan Anda.'])
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- Jumlah Anak --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex items-center space-x-4">
            <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Jumlah Anak</p>
                <p class="text-xl font-bold text-gray-900">{{ $stats['jumlah_anak'] ?? 0 }} <span class="text-sm font-normal text-gray-500">Jiwa</span></p>
            </div>
        </div>
        {{-- Total Pengukuran --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex items-center space-x-4">
            <div class="w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path></svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Pengukuran</p>
                <p class="text-xl font-bold text-gray-900">{{ $stats['total_pengukuran'] ?? 0 }} <span class="text-sm font-normal text-gray-500">Data</span></p>
            </div>
        </div>
        {{-- Terakhir Aktivitas --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex items-center space-x-4">
            <div class="w-12 h-12 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Terakhir Aktivitas</p>
                <p class="text-sm font-bold text-gray-900">
                    @if(isset($stats['last_activity']) && $stats['last_activity'])
                        {{ \Carbon\Carbon::parse($stats['last_activity']->created_at)->diffForHumans() }}
                    @else
                        -
                    @endif
                </p>
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- 3. Left Column: Read-Only Information --}}
        <div class="space-y-6">
            {{-- Data Akun --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                        Data Akun
                    </h2>
                </div>
                <div class="p-6">
                    {{-- Avatar & Basic Info --}}
                    <div class="flex flex-col items-center text-center pb-6 border-b border-gray-100">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center text-3xl font-bold text-white mb-3 shadow-md bg-gradient-to-br from-blue-500 to-blue-600">
                            {{ substr($user->nama, 0, 1) }}
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $user->nama }}</h3>
                        <p class="text-sm text-gray-500 mb-2">{{ $user->role ?? 'Orang Tua' }}</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Aktif
                        </span>
                    </div>

                    {{-- Detail Info Table --}}
                    <div class="pt-4 space-y-3">
                        <div class="grid grid-cols-3 gap-2 text-sm">
                            <span class="text-gray-500">Username</span>
                            <span class="col-span-2 font-mono font-medium text-gray-900">{{ $user->username }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2 text-sm">
                            <span class="text-gray-500">Bergabung</span>
                            <span class="col-span-2 font-medium text-gray-900">
                                {{ isset($stats['account_age']) ? $stats['account_age'] : \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ringkasan Keluarga (Menggantikan Lokasi Posyandu) --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Ringkasan Keluarga
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-3 gap-2 text-sm border-b border-gray-50 pb-3">
                        <span class="text-gray-500">Ayah</span>
                        <span class="col-span-2 font-semibold text-gray-900">{{ $orangTua->nama_ayah }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-sm border-b border-gray-50 pb-3">
                        <span class="text-gray-500">Ibu</span>
                        <span class="col-span-2 font-medium text-gray-900">{{ $orangTua->nama_ibu }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-sm">
                        <span class="text-gray-500">NIK KK</span>
                        <span class="col-span-2 font-medium text-gray-900 font-mono">{{ $orangTua->nik }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. Right Column: Editable Forms --}}
        <div class="lg:col-span-2 space-y-6">
            @include('orangtua.profile.partials.edit-profile-form')
            @include('orangtua.profile.partials.change-password-form')
        </div>
    </div>
</div>
@endsection