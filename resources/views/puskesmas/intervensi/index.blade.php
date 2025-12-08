@extends('layouts.app')

@section('title', 'Kelola Intervensi Stunting')
@section('breadcrumb', 'Puskesmas / Intervensi')

@section('sidebar')
    @include('puskesmas.partials.sidebar.puskesmas-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    @include('puskesmas.intervensi.partials.header')

    {{-- Stats Cards --}}
    @include('puskesmas.intervensi.partials.stats-cards')

    {{-- Filter Panel --}}
    @include('puskesmas.intervensi.partials.filter-panel')

    {{-- Intervensi Table --}}
    @include('puskesmas.intervensi.partials.intervensi-table')
</div>

{{-- Scripts --}}
@include('puskesmas.intervensi.scripts.filter')
@endsection