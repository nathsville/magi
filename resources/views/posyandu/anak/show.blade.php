@extends('layouts.app')

@section('title', 'Detail Anak - ' . $anak->nama_anak)

@section('sidebar')
    @include('posyandu.sidebar-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('posyandu.anak.index') }}" class="flex items-center text-gray-600 hover:text-[#000878] transition font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Data Anak
        </a>
        <div class="text-sm text-gray-500">
            Terdaftar: {{ $anak->created_at->format('d M Y') }}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column --}}
        <div class="space-y-6">
            @include('posyandu.anak.partials.profile-card', ['anak' => $anak])
            @include('posyandu.anak.partials.quick-actions-detail', ['anak' => $anak])
        </div>

        {{-- Right Column --}}
        <div class="lg:col-span-2 space-y-6">
            @if($anak->stuntingTerakhir)
                @include('posyandu.anak.partials.latest-status', ['anak' => $anak])
            @endif

            @include('posyandu.anak.partials.measurement-history', ['riwayatPengukuran' => $riwayatPengukuran])
            @include('posyandu.anak.partials.growth-chart', ['riwayatPengukuran' => $riwayatPengukuran, 'anak' => $anak])
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@include('posyandu.anak.scripts.detail')
@endpush