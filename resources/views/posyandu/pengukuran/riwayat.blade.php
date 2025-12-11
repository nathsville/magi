@extends('layouts.app')

@section('title', 'Riwayat Pengukuran')
@section('breadcrumb', 'Posyandu / Riwayat Pengukuran')

@section('sidebar')
    @include('posyandu.sidebar-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-[#000878] rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
                {{-- SVG Icon: History/Clock --}}
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Riwayat Pengukuran</h1>
                <p class="text-sm text-gray-600 mt-1">Daftar lengkap riwayat pengukuran di {{ $posyandu->nama_posyandu ?? 'Posyandu' }}</p>
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            <a href="{{ route('posyandu.dashboard') }}" 
                class="flex items-center px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="font-medium text-sm">Kembali</span>
            </a>

            <button onclick="exportToExcel()" 
                class="flex items-center px-5 py-2.5 text-white bg-green-600 rounded-lg hover:bg-green-700 transition shadow-md hover:shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="font-medium text-sm">Export Excel</span>
            </button>
        </div>
    </div>

    {{-- Stats Cards --}}
    @include('pengukuran.partials.stats-cards-riwayat', ['stats' => $stats])

    {{-- Search & Filter --}}
    @include('pengukuran.partials.search-filter-riwayat')

    {{-- Riwayat Table --}}
    @include('pengukuran.partials.riwayat-table', ['pengukuranList' => $pengukuranList])
</div>

@push('scripts')
    @include('pengukuran.scripts.riwayat')
@endpush
@endsection