@extends('layouts.app')

@section('title', 'Broadcast Pesan')
@section('breadcrumb', 'Admin / Broadcast')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    @include('admin.broadcast.partials.header')

    {{-- Statistics Cards --}}
    @include('admin.broadcast.partials.stats-cards', [
        'totalOrangTua' => $totalOrangTua
    ])

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Compose Form (2/3) --}}
        <div class="lg:col-span-2">
            @include('admin.broadcast.partials.compose-form')
        </div>

        {{-- Recent Broadcasts (1/3) --}}
        <div class="lg:col-span-1">
            @include('admin.broadcast.partials.recent-broadcasts', [
                'recentBroadcasts' => $recentBroadcasts
            ])
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @include('admin.broadcast.scripts.compose')
    @include('admin.broadcast.scripts.preview')
@endpush