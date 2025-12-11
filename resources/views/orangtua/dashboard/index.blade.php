@extends('layouts.app')

@section('title', 'Dashboard Orang Tua')
@section('breadcrumb', 'Orang Tua / Dashboard')

@section('sidebar')
    @include('orangtua.sidebar.sidebar-menu')
@endsection

@section('content')
<div class="space-y-8">
    {{-- Header with Identity (Mirip Puskesmas Header) --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-[#000878] rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Dashboard Orang Tua</h1>
                <p class="text-sm text-gray-600 mt-1">Selamat Datang, {{ $orangTua->nama_ayah ?? $orangTua->nama_ibu }}</p>
            </div>
        </div>
        
        {{-- Profile Avatar Small --}}
        <div class="hidden md:block">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($orangTua->nama_ayah ?? $orangTua->nama_ibu) }}&background=000878&color=ffffff" 
                 alt="Avatar" 
                 class="w-10 h-10 rounded-full border-2 border-gray-200 shadow-sm">
        </div>
    </div>

    {{-- Stats Cards --}}
    @include('orangtua.dashboard.partials.stats-cards', [
        'totalAnak' => $totalAnak,
        'anakNormal' => $anakNormal,
        'anakStunting' => $anakStunting,
        'unreadNotifications' => $unreadNotifications
    ])

    {{-- Section: Data Anak --}}
    <div class="space-y-6">
        @include('orangtua.dashboard.partials.anak-list', ['anakList' => $anakList])
    </div>

    {{-- Section: Info & Notifikasi (2 Kolom) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Left: Notifications --}}
        <div>
            @include('orangtua.dashboard.partials.notifications', ['latestNotifications' => $latestNotifications])
        </div>

        {{-- Right: Health Tips --}}
        <div>
            @include('orangtua.dashboard.partials.edukasi-tips', ['edukasiTips' => $edukasiTips])
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('orangtua.dashboard.scripts.dashboard')
@endpush