@extends('layouts.app')

@section('title', 'Detail Notifikasi')

@section('sidebar')
    @include('orangtua.sidebar.sidebar-menu')
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Back Button --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('orangtua.notifikasi.index') }}" 
           class="flex items-center text-gray-600 hover:text-[#000878] transition font-medium text-sm group">
            <div class="w-8 h-8 bg-white border border-gray-300 rounded-full flex items-center justify-center mr-3 group-hover:border-[#000878] transition">
                <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </div>
            Kembali ke Daftar
        </a>
    </div>

    {{-- Notification Card --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        {{-- Header --}}
        @include('orangtua.notifikasi.partials.show.header', ['notifikasi' => $notifikasi])

        {{-- Content --}}
        @include('orangtua.notifikasi.partials.show.content', ['notifikasi' => $notifikasi])

        {{-- Related Anak Info (if available) --}}
        @if($anak)
            @include('orangtua.notifikasi.partials.show.anak-info', ['anak' => $anak])
        @endif

        {{-- Actions --}}
        @include('orangtua.notifikasi.partials.show.actions', ['notifikasi' => $notifikasi, 'anak' => $anak])
    </div>

    {{-- Related Notifications --}}
    @include('orangtua.notifikasi.partials.show.related', ['notifikasi' => $notifikasi])
</div>
@endsection

@push('scripts')
@include('orangtua.notifikasi.scripts.detail')
@endpush