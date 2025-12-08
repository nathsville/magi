@extends('layouts.app')

@section('title', 'Dashboard Orang Tua')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
    {{-- Header --}}
    @include('orangtua.partials.header')

    <div class="container mx-auto px-4 py-6 max-w-7xl">
        {{-- Welcome Section --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ $orangTua->nama_ayah ?? $orangTua->nama_ibu }}</h2>
                    <p class="text-gray-600 mt-1">Pantau kesehatan dan pertumbuhan anak Anda secara real-time</p>
                </div>
                <div class="hidden md:block">
                    <img src="https://api.dicebear.com/7.x/bottts/svg?seed={{ $orangTua->id_orangtua }}" 
                         alt="Avatar" 
                         class="w-16 h-16 rounded-full border-4 border-purple-200">
                </div>
            </div>
        </div>

        {{-- Statistics Cards --}}
        @include('orangtua.partials.stats-cards', [
            'totalAnak' => $totalAnak,
            'anakNormal' => $anakNormal,
            'anakStunting' => $anakStunting,
            'unreadNotifications' => $unreadNotifications
        ])

        {{-- Main Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
            {{-- Left Column: Children List --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Data Anak Section --}}
                @include('orangtua.partials.anak-list', ['anakList' => $anakList])
            </div>

            {{-- Right Column: Notifications & Tips --}}
            <div class="space-y-6">
                {{-- Notifications --}}
                @include('orangtua.partials.notifications', ['latestNotifications' => $latestNotifications])

                {{-- Educational Tips --}}
                @include('orangtua.partials.edukasi-tips', ['edukasiTips' => $edukasiTips])
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('orangtua.scripts.dashboard')
@endpush