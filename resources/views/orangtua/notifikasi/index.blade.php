@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
    {{-- Header --}}
    @include('orangtua.partials.header')

    <div class="container mx-auto px-4 py-6 max-w-7xl">
        {{-- Page Header --}}
        @include('orangtua.notifikasi.partials.page-header')

        {{-- Stats Cards --}}
        @include('orangtua.notifikasi.partials.stats-cards', [
            'totalNotifikasi' => $totalNotifikasi,
            'belumDibaca' => $belumDibaca,
            'sudahDibaca' => $sudahDibaca,
            'peringatan' => $peringatan
        ])

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mt-6">
            {{-- Sidebar Filter --}}
            <div class="lg:col-span-1">
                @include('orangtua.notifikasi.partials.filter-sidebar')
            </div>

            {{-- Main Content --}}
            <div class="lg:col-span-3">
                {{-- Actions Bar --}}
                @include('orangtua.notifikasi.partials.actions-bar')

                {{-- Notifications List --}}
                @include('orangtua.notifikasi.partials.notifications-list', [
                    'notifikasiList' => $notifikasiList
                ])

                {{-- Pagination --}}
                @if($notifikasiList->hasPages())
                <div class="mt-6">
                    {{ $notifikasiList->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('orangtua.notifikasi.scripts.actions')
@endpush