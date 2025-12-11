@extends('layouts.app')

@section('title', 'Validasi Final Data Stunting')
@section('breadcrumb', 'DPPKB / Validasi Final')

@section('sidebar')
    @include('dppkb.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header Section --}}
    @include('dppkb.validasi.partials.header')

    {{-- Filter & Search --}}
    @include('dppkb.validasi.partials.filter-search')

    {{-- Stats Overview --}}
    @include('dppkb.validasi.partials.stats-overview')

    {{-- Data Table --}}
    <div id="validasiTableContainer">
        {{-- Table will be loaded via AJAX --}}
        <div class="flex items-center justify-center py-12">
            <div class="text-center">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-[#000878] border-t-transparent mb-4"></div>
                <p class="text-gray-600">Memuat data validasi...</p>
            </div>
        </div>
    </div>
</div>

{{-- Modal Detail --}}
@include('dppkb.validasi.partials.modal-detail')

{{-- Modal Approve --}}
@include('dppkb.validasi.partials.modal-approve')

{{-- Modal Klarifikasi --}}
@include('dppkb.validasi.partials.modal-klarifikasi')

@include('dppkb.validasi.scripts.index')
@endsection