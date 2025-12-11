@extends('layouts.app')

@section('title', 'Data Anak')
@section('breadcrumb', 'Orang Tua / Data Anak')

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
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Data Anak</h1>
                <p class="text-sm text-gray-600 mt-1">Pantau pertumbuhan dan kesehatan seluruh anak Anda</p>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    @include('orangtua.anak.partials.stats-cards', [
        'totalAnak' => $totalAnak,
        'anakNormal' => $anakNormal,
        'anakStunting' => $anakStunting
    ])

    {{-- Filter Panel --}}
    @include('orangtua.anak.partials.filter-panel')

    {{-- Children Grid --}}
    @include('orangtua.anak.partials.anak-grid', ['anakList' => $anakList])
</div>
@endsection

@push('scripts')
@include('orangtua.anak.scripts.filter')
@endpush