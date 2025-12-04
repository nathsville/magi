@extends('layouts.app')

@section('title', 'Dashboard Puskesmas')
@section('breadcrumb', 'Puskesmas / Dashboard')

@section('sidebar')
    @include('puskesmas.partials.sidebar.puskesmas-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    @include('puskesmas.dashboard.partials.header')

    {{-- Stats Cards --}}
    @include('puskesmas.dashboard.partials.stats-cards')

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Chart + Table (2 cols) --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Chart Tren Stunting --}}
            @include('puskesmas.dashboard.partials.chart-tren')

            {{-- Tabel Data Posyandu --}}
            @include('puskesmas.dashboard.partials.table-posyandu')
        </div>

        {{-- Right Column: Recent Interventions (1 col) --}}
        <div class="lg:col-span-1">
            @include('puskesmas.dashboard.partials.recent-interventions')
        </div>
    </div>
</div>

{{-- Scripts --}}
@include('puskesmas.dashboard.scripts.chart')
@include('puskesmas.dashboard.scripts.filters')
@endsection