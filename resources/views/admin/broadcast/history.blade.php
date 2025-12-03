@extends('layouts.app')

@section('title', 'Riwayat Broadcast')
@section('breadcrumb', 'Admin / Broadcast / Riwayat')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- 1. Header Section --}}
    @include('admin.broadcast.partials.history.header')

    {{-- 2. Stats Summary --}}
    @include('admin.broadcast.partials.history.stats-cards')

    {{-- 3. Broadcast List OR Empty State --}}
    @if($broadcasts->count() > 0)
        @include('admin.broadcast.partials.history.broadcast-list')
    @else
        @include('admin.broadcast.partials.history.empty-state')
    @endif
</div>
@endsection