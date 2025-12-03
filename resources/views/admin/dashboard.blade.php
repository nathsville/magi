@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('breadcrumb', 'Dashboard')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
    {{-- Header Section --}}
    @include('admin.partials.dashboard.header')

    {{-- Stats Cards Row --}}
    @include('admin.partials.dashboard.stats-cards')

    {{-- Main Content Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Data Stunting per Wilayah --}}
        @include('admin.partials.dashboard.wilayah-table')

        {{-- Status Gizi Distribution --}}
        @include('admin.partials.dashboard.status-gizi-chart')
    </div>

    {{-- Bottom Row --}}
    <div class="mb-8">
        @include('admin.partials.dashboard.recent-activities')
    </div>

    <div class="mb-8">
        @include('admin.partials.dashboard.data-master-summary')
    </div>

    {{-- Quick Actions Banner --}}
    @include('admin.partials.dashboard.quick-actions')
@endsection

@push('scripts')
    @include('admin.partials.dashboard.scripts')
@endpush