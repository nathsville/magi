@extends('layouts.app')

@section('title', 'Dashboard Posyandu')
@section('breadcrumb', 'Posyandu / Dashboard')

@section('sidebar')
    @include('posyandu.sidebar-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header Section (Identitas Posyandu) --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-[#000878] rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Dashboard Posyandu</h1>
                <div class="flex items-center text-sm text-gray-600 mt-1">
                    <span class="font-semibold text-[#000878] bg-blue-50 px-2 py-0.5 rounded border border-blue-100">
                        {{ $posyandu->nama_posyandu }}
                    </span>
                    <span class="mx-2 text-gray-300">•</span>
                    <span>Kel. {{ $posyandu->kelurahan }}</span>
                </div>
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            <span class="text-sm text-gray-500 bg-white px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm">
                {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
            </span>
        </div>
    </div>

    {{-- Stats Cards --}}
    @include('posyandu.partials.stats-cards', [
        'todayMeasurements' => $todayMeasurements,
        'monthlyMeasurements' => $monthlyMeasurements,
        'totalAnak' => $totalAnak,
        'persentaseStunting' => $persentaseStunting,
        'pendingValidations' => $pendingValidations
    ])

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Quick Actions (Replaced with Puskesmas style buttons later if needed, but keeping logic for now) --}}
            @include('posyandu.partials.quick-actions')

            {{-- Monthly Trend Chart --}}
            @include('posyandu.partials.monthly-trend', ['monthlyTrend' => $monthlyTrend])

            {{-- Recent Measurements --}}
            @include('posyandu.partials.recent-measurements', ['recentMeasurements' => $recentMeasurements])
        </div>

        {{-- Right Column --}}
        <div class="space-y-6">
            {{-- Notifications --}}
            @include('posyandu.partials.notifications-widget', ['notifications' => $notifications])

            {{-- Tips --}}
            @include('posyandu.partials.tips-widget')
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('posyandu.scripts.dashboard')
@endpush