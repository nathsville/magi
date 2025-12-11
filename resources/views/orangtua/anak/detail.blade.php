@extends('layouts.app')

@section('title', 'Detail Anak - ' . $anak->nama_anak)

@section('sidebar')
    @include('orangtua.sidebar.sidebar-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header & Back Button --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <a href="{{ route('orangtua.anak.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-white border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-[#000878] transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Data Anak</h1>
                <p class="text-sm text-gray-600">Riwayat pertumbuhan dan kesehatan lengkap</p>
            </div>
        </div>
    </div>

    {{-- Profile Card --}}
    {{-- Path Updated: detail.profile-card --}}
    @include('orangtua.anak.partials.detail.profile-card', ['anak' => $anak, 'umurBulan' => $umurBulan])

    {{-- Latest Status Alert --}}
    @if($statusTerakhir)
        {{-- Path Updated: detail.status-alert --}}
        @include('orangtua.anak.partials.detail.status-alert', ['status' => $statusTerakhir])
    @endif

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Charts & History (2/3 width) --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Growth Charts --}}
            {{-- Path Updated: detail.growth-charts --}}
            @include('orangtua.anak.partials.detail.growth-charts', [
                'chartData' => $chartData,
                'whoStandards' => $whoStandards,
                'anak' => $anak
            ])

            {{-- Measurement History Table --}}
            {{-- Path Updated: detail.measurement-history --}}
            @include('orangtua.anak.partials.detail.measurement-history', [
                'riwayatPengukuran' => $riwayatPengukuran
            ])
        </div>

        {{-- Right Column: Stats & Info (1/3 width) --}}
        <div class="space-y-6">
            {{-- Quick Stats (Z-Scores) --}}
            {{-- Path Updated: detail.quick-stats --}}
            @include('orangtua.anak.partials.detail.quick-stats', [
                'totalPengukuran' => $totalPengukuran,
                'statusTerakhir' => $statusTerakhir
            ])

            {{-- Interventions --}}
            {{-- Path Updated: detail.interventions --}}
            @include('orangtua.anak.partials.detail.interventions', [
                'intervensiList' => $intervensiList
            ])

            {{-- WHO Info --}}
            {{-- Path Updated: detail.who-info --}}
            @include('orangtua.anak.partials.detail.who-info')

            {{-- Actions --}}
            {{-- Path Updated: detail.chart-actions --}}
            @include('orangtua.anak.partials.detail.chart-actions')
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .chart-container {
        position: relative;
        height: 350px;
        width: 100%;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@include('orangtua.anak.scripts.charts', [
    'chartData' => $chartData,
    'whoStandards' => $whoStandards,
    'jenisKelamin' => $anak->jenis_kelamin
])
@endpush