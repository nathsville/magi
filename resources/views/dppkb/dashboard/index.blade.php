@extends('layouts.app')

@section('title', 'Dashboard DPPKB')
@section('breadcrumb', 'DPPKB / Dashboard')

@section('sidebar')
    @include('dppkb.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header Section --}}
    @include('dppkb.dashboard.partials.header')

    {{-- Alert Notifications --}}
    @if($pendingValidasi > 0)
        @include('dppkb.dashboard.partials.alert-pending')
    @endif

    {{-- Stats Cards --}}
    @include('dppkb.dashboard.partials.stats-cards', [
        'totalAnak' => $totalAnak,
        'totalStunting' => $totalStunting,
        'persentaseStunting' => $persentaseStunting,
        'pendingValidasi' => $pendingValidasi
    ])

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column (2/3) --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Tren Bulanan Chart --}}
            @include('dppkb.dashboard.partials.chart-tren', [
                'trenBulanan' => $trenBulanan
            ])

            {{-- Sebaran Kecamatan --}}
            @include('dppkb.dashboard.partials.sebaran-kecamatan', [
                'sebaranKecamatan' => $sebaranKecamatan
            ])

            {{-- Top Puskesmas --}}
            @include('dppkb.dashboard.partials.top-puskesmas', [
                'topPuskesmas' => $topPuskesmas
            ])
        </div>

        {{-- Right Column (1/3) --}}
        <div class="space-y-6">
            {{-- Quick Actions --}}
            @include('dppkb.dashboard.partials.quick-actions')

            {{-- Notifikasi Terbaru --}}
            @include('dppkb.dashboard.partials.notifikasi', [
                'notifikasi' => $notifikasi
            ])

            {{-- Calendar Widget --}}
            @include('dppkb.dashboard.partials.calendar')
        </div>
    </div>
</div>

@include('dppkb.dashboard.scripts.index')
@endsection