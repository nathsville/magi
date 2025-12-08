@extends('layouts.app')

@section('title', 'Detail Notifikasi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
    {{-- Header --}}
    @include('orangtua.partials.header')

    <div class="container mx-auto px-4 py-6 max-w-4xl">
        {{-- Back Button --}}
        <div class="mb-4">
            <a href="{{ route('orangtua.notifikasi.index') }}" 
               class="inline-flex items-center text-purple-600 hover:text-purple-700 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Notifikasi
            </a>
        </div>

        {{-- Notification Card --}}
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            {{-- Header --}}
            @include('orangtua.notifikasi.partials.detail-header', ['notifikasi' => $notifikasi])

            {{-- Content --}}
            @include('orangtua.notifikasi.partials.detail-content', ['notifikasi' => $notifikasi])

            {{-- Related Anak Info (if available) --}}
            @if($anak)
                @include('orangtua.notifikasi.partials.detail-anak-info', ['anak' => $anak])
            @endif

            {{-- Actions --}}
            @include('orangtua.notifikasi.partials.detail-actions', ['notifikasi' => $notifikasi, 'anak' => $anak])
        </div>

        {{-- Related Notifications --}}
        @include('orangtua.notifikasi.partials.related-notifications', ['notifikasi' => $notifikasi])
    </div>
</div>
@endsection

@push('scripts')
@include('orangtua.notifikasi.scripts.detail')
@endpush