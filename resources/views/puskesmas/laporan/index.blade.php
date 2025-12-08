@extends('layouts.app')

@section('title', 'Kelola Laporan')
@section('breadcrumb', 'Puskesmas / Laporan')

@section('sidebar')
    @include('puskesmas.partials.sidebar.puskesmas-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    @include('puskesmas.laporan.partials.header')

    {{-- Stats Cards --}}
    @include('puskesmas.laporan.partials.stats-cards')

    {{-- Filter Panel --}}
    @include('puskesmas.laporan.partials.filter-panel')

    {{-- Laporan Table --}}
    @include('puskesmas.laporan.partials.laporan-table')
</div>

{{-- Scripts --}}
@include('puskesmas.laporan.scripts.filter')
@endsection