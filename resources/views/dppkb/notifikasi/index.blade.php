@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    {{-- Header --}}
    @include('dppkb.notifikasi.partials.header')
    
    {{-- Main Container --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Quick Actions & Stats --}}
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
            @include('dppkb.notifikasi.partials.quick-actions')
            @include('dppkb.notifikasi.partials.notification-stats')
        </div>
        
        {{-- Filter Bar --}}
        @include('dppkb.notifikasi.partials.filter-bar')
        
        {{-- Notifications List --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main List --}}
            <div class="lg:col-span-2">
                @include('dppkb.notifikasi.partials.notification-list')
            </div>
            
            {{-- Sidebar --}}
            <div class="space-y-6">
                @include('dppkb.notifikasi.partials.sidebar-summary')
                @include('dppkb.notifikasi.partials.sidebar-templates')
            </div>
        </div>
        
    </div>
</div>

{{-- Modals --}}
@include('dppkb.notifikasi.partials.modal-detail')
@include('dppkb.notifikasi.partials.modal-compose')

{{-- Scripts --}}
@include('dppkb.notifikasi.scripts.index')
@endsection