@extends('layouts.app')

@section('title', 'Detail Pengukuran')
@section('breadcrumb', 'Posyandu / Riwayat / Detail')

@section('sidebar')
    @include('posyandu.sidebar-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Data Pengukuran</h1>
            <p class="text-gray-600 mt-1">Informasi lengkap pengukuran anak</p>
        </div>
        <a href="{{ route('posyandu.pengukuran.riwayat') }}" 
            class="flex items-center space-x-2 px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="text-sm font-medium">Kembali</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Data Anak & Info --}}
        <div class="space-y-6">
            @include('pengukuran.partials.detail-child-info', ['pengukuran' => $pengukuran])
            @include('pengukuran.partials.detail-measurement-info', ['pengukuran' => $pengukuran])
        </div>

        {{-- Right Column: Hasil & Aksi --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Z-Score & Status --}}
            @if($pengukuran->stunting)
                @include('pengukuran.partials.detail-zscore-card', ['stunting' => $pengukuran->stunting])
            @endif

            {{-- Data Antropometri --}}
            @include('pengukuran.partials.detail-anthropometric', ['pengukuran' => $pengukuran])

            {{-- Catatan --}}
            @if($pengukuran->catatan)
                @include('pengukuran.partials.detail-notes', ['pengukuran' => $pengukuran])
            @endif

            {{-- Aksi --}}
            @include('pengukuran.partials.detail-actions', ['pengukuran' => $pengukuran])
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @include('pengukuran.scripts.detail')
@endpush