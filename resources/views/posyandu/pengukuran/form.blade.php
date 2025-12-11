@extends('layouts.app')

@section('title', 'Input Data Pengukuran')
@section('breadcrumb', 'Posyandu / Input Pengukuran')

@section('sidebar')
    @include('posyandu.sidebar-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-[#000878] rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Input Data Pengukuran</h1>
                <p class="text-sm text-gray-600 mt-1">Catat hasil penimbangan dan pengukuran anak</p>
            </div>
        </div>
        
        <a href="{{ route('posyandu.dashboard') }}" 
            class="flex items-center px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="font-medium text-sm">Kembali Dashboard</span>
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        @include('posyandu.partials.alert-success', ['message' => session('success')])
    @endif
    @if(session('error'))
        @include('posyandu.partials.alert-error', ['message' => session('error')])
    @endif
    @if(session('warning'))
        @include('posyandu.partials.alert-warning', ['message' => session('warning')])
    @endif

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Child Selector --}}
        <div class="lg:col-span-1">
            {{-- path view dikoreksi: posyandu.pengukuran... --}}
            @include('posyandu.pengukuran.partials.child-selector', ['anakList' => $anakList])
        </div>

        {{-- Right Column: Form --}}
        <div class="lg:col-span-2 space-y-6">
            @if($selectedAnak)
                {{-- path view dikoreksi: posyandu.pengukuran... --}}
                @include('posyandu.pengukuran.partials.selected-child-info', ['anak' => $selectedAnak])
                @include('posyandu.pengukuran.partials.measurement-form', ['anak' => $selectedAnak])
            @else
                {{-- path view dikoreksi: posyandu.pengukuran... --}}
                @include('posyandu.pengukuran.partials.empty-state')
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- path script dikoreksi --}}
    @include('posyandu.pengukuran.scripts.form')
@endpush