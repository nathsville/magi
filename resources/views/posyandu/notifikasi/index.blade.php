@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teal-50 via-cyan-50 to-blue-50">
    @include('posyandu.partials.header')

    <div class="container mx-auto px-4 py-6 max-w-5xl">
        {{-- Back Button --}}
        <div class="mb-4">
            <a href="{{ route('posyandu.dashboard') }}" class="inline-flex items-center text-teal-600 hover:text-teal-700 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
            </a>
        </div>

        {{-- Page Header --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-bell text-teal-600 mr-3"></i>Notifikasi
                    </h1>
                    <p class="text-gray-600">Kelola dan lihat semua notifikasi Anda</p>
                </div>
                <div class="flex space-x-2">
                    <button onclick="markAllAsRead()" 
                            class="px-4 py-2 bg-teal-600 text-white font-medium rounded-lg hover:bg-teal-700 transition text-sm">
                        <i class="fas fa-check-double mr-2"></i>Tandai Semua Dibaca
                    </button>
                    <button onclick="deleteAllRead()" 
                            class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition text-sm">
                        <i class="fas fa-trash mr-2"></i>Hapus Yang Dibaca
                    </button>
                </div>
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
</div>
@endsection

@push('scripts')
@include('posyandu.notifikasi.scripts.index')
@endpush