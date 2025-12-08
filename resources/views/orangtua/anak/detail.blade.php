@extends('layouts.app')

@section('title', 'Detail Anak - ' . $anak->nama_anak)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
    {{-- Header --}}
    @include('orangtua.partials.header')

    <div class="container mx-auto px-4 py-6 max-w-7xl">
        {{-- Back Button --}}
        <div class="mb-4">
            <a href="{{ route('orangtua.anak.index') }}" 
               class="inline-flex items-center text-purple-600 hover:text-purple-700 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Data Anak
            </a>
        </div>

        {{-- Profile Card --}}
        @include('orangtua.anak.partials.profile-card', ['anak' => $anak, 'umurBulan' => $umurBulan])

        {{-- Latest Status Alert --}}
        @if($statusTerakhir)
            @include('orangtua.anak.partials.status-alert', ['status' => $statusTerakhir])
        @endif

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
            {{-- Left Column: Charts (2/3 width) --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Growth Charts --}}
                @include('orangtua.anak.partials.growth-charts', [
                    'chartData' => $chartData,
                    'whoStandards' => $whoStandards,
                    'anak' => $anak
                ])

                {{-- Measurement History Table --}}
                @include('orangtua.anak.partials.measurement-history', [
                    'riwayatPengukuran' => $riwayatPengukuran
                ])
            </div>

            {{-- Right Column: Info & Interventions (1/3 width) --}}
            <div class="space-y-6">
                {{-- Quick Stats --}}
                @include('orangtua.anak.partials.quick-stats', [
                    'totalPengukuran' => $totalPengukuran,
                    'statusTerakhir' => $statusTerakhir
                ])

                {{-- Interventions --}}
                @include('orangtua.anak.partials.interventions', [
                    'intervensiList' => $intervensiList
                ])

                {{-- WHO Info --}}
                @include('orangtua.anak.partials.who-info')

                @include('orangtua.anak.partials.chart-actions')
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom styles for charts */
    .chart-container {
        position: relative;
        height: 350px;
    }
</style>
@endpush

@push('scripts')
{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@include('orangtua.anak.scripts.charts', [
    'chartData' => $chartData,
    'whoStandards' => $whoStandards,
    'jenisKelamin' => $anak->jenis_kelamin
])
@endpush