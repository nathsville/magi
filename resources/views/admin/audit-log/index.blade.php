@extends('layouts.app')

@section('title', 'Audit Log')
@section('breadcrumb', 'Admin / Audit Log')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    @include('admin.audit-log.partials.header')

    {{-- Statistics Cards --}}
    @include('admin.audit-log.partials.stats-cards', [
        'totalLogs' => $totalLogs,
        'todayLogs' => $todayLogs,
        'weekLogs' => $weekLogs
    ])

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Timeline (2/3) --}}
        <div class="lg:col-span-2">
            @include('admin.audit-log.partials.timeline', [
                'recentActivities' => $recentActivities
            ])
        </div>

        {{-- Sidebar (1/3) --}}
        <div class="space-y-6">
            {{-- Top Users --}}
            @include('admin.audit-log.partials.top-users', [
                'topUsers' => $topUsers
            ])

            {{-- Action Distribution --}}
            @include('admin.audit-log.partials.action-chart', [
                'actionStats' => $actionStats
            ])
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @include('admin.audit-log.scripts.detail-modal')
@endpush