@extends('layouts.app')

@section('title', 'Validasi Data Stunting')
@section('breadcrumb', 'Puskesmas / Validasi Data')

@section('sidebar')
    @include('puskesmas.partials.sidebar.puskesmas-menu', ['pendingCount' => $totalPending])
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    @include('puskesmas.validasi.partials.header')

    {{-- Stats Cards --}}
    @include('puskesmas.validasi.partials.stats-cards')

    {{-- Filter Form --}}
    @include('puskesmas.validasi.partials.filter-form')

    {{-- Pending List --}}
    @include('puskesmas.validasi.partials.pending-list')
</div>

{{-- Scripts --}}
@include('puskesmas.validasi.scripts.validation')
@include('puskesmas.validasi.scripts.bulk-action')
@endsection