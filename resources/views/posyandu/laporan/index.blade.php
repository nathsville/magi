@extends('layouts.app')

@section('title', 'Laporan Posyandu')
@section('breadcrumb', 'Posyandu / Laporan')

@section('sidebar')
    @include('posyandu.sidebar-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-[#000878] rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Laporan Posyandu</h1>
                <p class="text-sm text-gray-600 mt-1">Generate dan kelola laporan bulanan {{ $posyandu->nama_posyandu }}</p>
            </div>
        </div>

        <a href="{{ route('posyandu.dashboard') }}" class="flex items-center px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="font-medium text-sm">Kembali</span>
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        @include('posyandu.partials.alert-success', ['message' => session('success')])
    @endif

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Form --}}
        <div class="lg:col-span-1">
            @include('posyandu.laporan.partials.laporan-form', ['availableMonths' => $availableMonths])
        </div>

        {{-- Right Column: Stats & Quick Reports --}}
        <div class="lg:col-span-2 space-y-6">
            @include('posyandu.laporan.partials.current-stats', ['stats' => $stats, 'posyandu' => $posyandu])
            @include('posyandu.laporan.partials.quick-reports', ['availableMonths' => $availableMonths])
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('posyandu.laporan.scripts.index')
@endpush