@extends('layouts.app')

@section('title', 'Data Anak')
@section('breadcrumb', 'Puskesmas / Data Anak')

@section('sidebar')
    @include('puskesmas.partials.sidebar.puskesmas-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    @include('puskesmas.anak.partials.header')

    {{-- Stats Cards --}}
    @include('puskesmas.anak.partials.stats-cards')

    {{-- Search & Filter --}}
    @include('puskesmas.anak.partials.search-filter')

    {{-- Anak Table --}}
    @include('puskesmas.anak.partials.anak-table')
</div>

{{-- Scripts --}}
@include('puskesmas.anak.scripts.search')
@include('puskesmas.anak.scripts.delete-confirm')
@endsection