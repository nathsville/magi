@extends('layouts.app')

@section('title', 'Notifikasi')
@section('breadcrumb', 'Orang Tua / Notifikasi')

@section('sidebar')
    @include('orangtua.sidebar.sidebar-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-[#000878] rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Notifikasi</h1>
                <p class="text-sm text-gray-600 mt-1">Pemberitahuan dan peringatan kesehatan anak</p>
            </div>
        </div>
        
        {{-- Mark all read action --}}
        @if($belumDibaca > 0)
        <form method="POST" action="{{ route('orangtua.notifikasi.mark-all-read') }}">
            @csrf
            <button type="submit" 
                    class="flex items-center px-4 py-2.5 text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition text-sm font-medium"
                    onclick="return confirm('Tandai semua notifikasi sebagai dibaca?')">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Tandai Semua Dibaca
            </button>
        </form>
        @endif
    </div>

    {{-- Stats Cards --}}
    @include('orangtua.notifikasi.partials.stats-cards', [
        'totalNotifikasi' => $totalNotifikasi,
        'belumDibaca' => $belumDibaca,
        'sudahDibaca' => $sudahDibaca,
        'peringatan' => $peringatan
    ])

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        {{-- Sidebar Filter --}}
        <div class="lg:col-span-1">
            @include('orangtua.notifikasi.partials.filter-sidebar')
        </div>

        {{-- Main Content --}}
        <div class="lg:col-span-3">
            {{-- Notifications List --}}
            @include('orangtua.notifikasi.partials.notifications-list', [
                'notifikasiList' => $notifikasiList
            ])

            {{-- Pagination --}}
            @if($notifikasiList->hasPages())
            <div class="mt-6 border-t border-gray-200 pt-4">
                {{ $notifikasiList->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('orangtua.notifikasi.scripts.actions')
@endpush