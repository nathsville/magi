@extends('layouts.app')

@section('title', 'Dashboard Posyandu')
@section('breadcrumb', 'Posyandu / Dashboard')

@section('sidebar')
    @include('posyandu.sidebar-menu')
@endsection

@section('content')
<div class="space-y-6 pb-10">
    {{-- Header Section (Identitas Posyandu) --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center space-x-5">
            <div class="w-14 h-14 bg-[#000878] rounded-2xl flex items-center justify-center shadow-lg shadow-blue-900/20 transform hover:scale-105 transition-transform duration-300">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Dashboard Posyandu</h1>
                <div class="flex items-center text-sm text-gray-600 mt-1.5 gap-2">
                    <span class="font-semibold text-[#000878] bg-blue-50 px-3 py-0.5 rounded-full border border-blue-100">
                        {{ $posyandu->nama_posyandu }}
                    </span>
                    <span class="text-gray-300">|</span>
                    <span class="flex items-center">
                        <i class="fas fa-map-marker-alt text-gray-400 mr-1.5"></i>
                        Kel. {{ $posyandu->kelurahan }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="flex items-center">
            <div class="bg-gray-50 px-4 py-2 rounded-xl border border-gray-200 text-gray-600 text-sm font-medium flex items-center shadow-sm">
                <i class="far fa-calendar-alt mr-2 text-[#000878]"></i>
                {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    {{-- PERBAIKAN: Menghapus wrapper div class="grid..." karena sudah ada di dalam partials --}}
    @include('posyandu.partials.stats-cards', [
        'todayMeasurements' => $todayMeasurements,
        'monthlyMeasurements' => $monthlyMeasurements,
        'totalAnak' => $totalAnak,
        'persentaseStunting' => $persentaseStunting,
        'pendingValidations' => $pendingValidations
    ])

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        {{-- Left Column (Main Content) --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Quick Actions --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                 @include('posyandu.partials.quick-actions')
            </div>

            {{-- Monthly Trend Chart --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-1">
                @include('posyandu.partials.monthly-trend', ['monthlyTrend' => $monthlyTrend])
            </div>

            {{-- Recent Measurements (Table) --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden table-wrapper">
                @include('posyandu.partials.recent-measurements', ['recentMeasurements' => $recentMeasurements])
            </div>
        </div>

        {{-- Right Column (Side Widgets) --}}
        <div class="space-y-6 lg:sticky lg:top-6">
            {{-- Notifications --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                @include('posyandu.partials.notifications-widget', ['notifications' => $notifications])
            </div>

            {{-- Tips --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                @include('posyandu.partials.tips-widget')
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Styling scrollbar tabel agar tipis dan rapi */
    .table-wrapper .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    .table-wrapper .overflow-x-auto::-webkit-scrollbar-track {
        background: #f8fafc;
        border-radius: 4px;
    }
    .table-wrapper .overflow-x-auto::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 4px;
        border: 1px solid #f8fafc;
    }
    .table-wrapper .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background-color: #94a3b8;
    }
    
    /* Memastikan Canvas Chart responsif */
    canvas#monthlyTrendChart {
        max-height: 350px !important;
    }

    /* Padding tabel agar lebih lega */
    .table-wrapper table td, 
    .table-wrapper table th {
        padding-top: 1rem;
        padding-bottom: 1rem;
        white-space: nowrap;
    }
</style>
@endpush

@push('scripts')
@include('posyandu.scripts.dashboard')
@endpush