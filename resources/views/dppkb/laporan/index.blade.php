@extends('layouts.app')

@section('title', 'Laporan Daerah')
@section('breadcrumb', 'DPPKB / Laporan')

@section('sidebar')
    @include('dppkb.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header Section --}}
    @include('dppkb.laporan.partials.header')

    {{-- Quick Actions --}}
    @include('dppkb.laporan.partials.quick-actions')

    {{-- Generate Form & Preview Side by Side --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        {{-- Left: Generate Form --}}
        <div class="lg:col-span-2">
            @include('dppkb.laporan.partials.generate-form')
        </div>

        {{-- Right: Preview/Templates --}}
        <div class="lg:col-span-3">
            @include('dppkb.laporan.partials.preview-section')
        </div>
    </div>

    {{-- Laporan History Table --}}
    @include('dppkb.laporan.partials.history-table')
</div>

{{-- Modal Preview --}}
@include('dppkb.laporan.partials.modal-preview')

{{-- Modal Share --}}
@include('dppkb.laporan.partials.modal-share')

@include('dppkb.laporan.scripts.index')
@endsection