@extends('layouts.app')

@section('title', 'Detail Audit Log')
@section('breadcrumb', 'Admin / Audit Log / Detail')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    {{-- 1. Header Section --}}
    @include('admin.audit-log.partials.detail.header')

    {{-- Main Info Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        {{-- 2. Log Info (Header Card Color) --}}
        @include('admin.audit-log.partials.detail.log-info')

        {{-- Content Body --}}
        <div class="p-6 space-y-6">
            {{-- 3. Description --}}
            @include('admin.audit-log.partials.detail.description')

            {{-- 4. Metadata (User, Time, System, etc) --}}
            @include('admin.audit-log.partials.detail.metadata')

            {{-- 5. Data Changes (Table Comparison) --}}
            @include('admin.audit-log.partials.detail.data-changes')
        </div>

        {{-- 6. Footer Actions --}}
        @include('admin.audit-log.partials.detail.footer')
    </div>
</div>
@endsection