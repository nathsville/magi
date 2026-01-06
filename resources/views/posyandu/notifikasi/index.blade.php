@extends('layouts.app')

@section('title', 'Notifikasi')
@section('breadcrumb', 'Posyandu / Notifikasi')

@section('sidebar')
    @include('posyandu.sidebar-menu')
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
<div class="space-y-6">
    {{-- Header Section (Matches pengukuran/form.blade.php) --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-[#000878] rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
                <i class="fas fa-bell text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Notifikasi</h1>
                <p class="text-sm text-gray-600 mt-1">Kelola dan lihat semua aktivitas terbaru</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('posyandu.dashboard') }}" 
                class="flex items-center px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm font-medium text-sm">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            
            <button onclick="markAllAsRead()" 
                    class="flex items-center px-4 py-2.5 bg-[#000878] text-white font-medium rounded-lg hover:bg-blue-900 transition text-sm shadow-md">
                <i class="fas fa-check-double mr-2"></i>Tandai Semua Dibaca
            </button>

            <button onclick="deleteAllRead()" 
                    class="flex items-center px-4 py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition text-sm shadow-md">
                <i class="fas fa-trash-alt mr-2"></i>Hapus Yang Dibaca
            </button>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        @include('posyandu.partials.alert-success', ['message' => session('success')])
    @endif

    {{-- Stats Cards --}}
    @include('posyandu.notifikasi.partials.stats-cards', ['stats' => $stats])

    {{-- Filter Panel --}}
    @include('posyandu.notifikasi.partials.filter-panel')

    {{-- Notification List --}}
    @include('posyandu.notifikasi.partials.notification-list', ['notifikasiList' => $notifikasiList])
</div>
@endsection

@push('scripts')
@include('posyandu.notifikasi.scripts.index')
@endpush