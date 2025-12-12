@extends('layouts.app')

@section('sidebar')
    @include('dppkb.partials.sidebar')
@endsection

@section('content')
<div class="min-h-screen bg-gray-50">
    {{-- Header --}}
    @include('dppkb.statistik.partials.header')
    
    {{-- Main Container --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Quick Stats Cards --}}
        @include('dppkb.statistik.partials.quick-stats')
        
        {{-- Filter & Time Range --}}
        @include('dppkb.statistik.partials.filter-bar')
        
        {{-- Charts Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            {{-- Tren Prevalensi --}}
            @include('dppkb.statistik.partials.chart-tren-prevalensi')
            
            {{-- Distribusi Usia --}}
            @include('dppkb.statistik.partials.chart-distribusi-usia')
        </div>
        
        {{-- Comparison Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            {{-- Perbandingan Wilayah --}}
            @include('dppkb.statistik.partials.chart-perbandingan-wilayah')
            
            {{-- Top/Bottom Posyandu --}}
            @include('dppkb.statistik.partials.table-top-bottom')
        </div>
        
        {{-- Advanced Analytics --}}
        <div class="grid grid-cols-1 gap-6">
            {{-- Korelasi & Prediksi --}}
            @include('dppkb.statistik.partials.analytics-advanced')
        </div>
        
    </div>
</div>

{{-- Modals --}}
@include('dppkb.statistik.partials.modal-detail-wilayah')
@include('dppkb.statistik.partials.modal-export')

{{-- Scripts --}}
@include('dppkb.statistik.scripts.index')
@endsection