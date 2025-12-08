@extends('layouts.app')

@section('title', 'Monitoring Data Stunting')
@section('breadcrumb', 'Puskesmas / Monitoring Data')

@section('sidebar')
    @include('puskesmas.partials.sidebar.puskesmas-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    @include('puskesmas.monitoring.partials.header')

    {{-- Filter Panel --}}
    @include('puskesmas.monitoring.partials.filter-panel')

    {{-- Data Table --}}
    @include('puskesmas.monitoring.partials.data-table')
</div>

{{-- Scripts --}}
@include('puskesmas.monitoring.scripts.filter')
@include('puskesmas.monitoring.scripts.export')
@endsection