@extends('layouts.app')

@section('title', 'Monitoring Data Stunting Kota')
@section('breadcrumb', 'DPPKB / Monitoring')

@section('sidebar')
    @include('dppkb.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header Section --}}
    @include('dppkb.monitoring.partials.header')

    {{-- Quick Stats Cards --}}
    @include('dppkb.monitoring.partials.quick-stats')

    {{-- Filter Bar --}}
    @include('dppkb.monitoring.partials.filter-bar')

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left: Map Visualization --}}
        <div class="lg:col-span-2">
            @include('dppkb.monitoring.partials.map-section')
        </div>

        {{-- Right: Kecamatan List --}}
        <div class="lg:col-span-1">
            @include('dppkb.monitoring.partials.kecamatan-list')
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @include('dppkb.monitoring.partials.chart-tren')
        @include('dppkb.monitoring.partials.chart-distribusi')
    </div>

    {{-- Top Puskesmas Table --}}
    @include('dppkb.monitoring.partials.top-puskesmas')
</div>

@include('dppkb.monitoring.scripts.index')
@endsection