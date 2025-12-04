@extends('layouts.app')

@section('title', 'Input Data Pengukuran')
@section('breadcrumb', 'Puskesmas / Input Data')

@section('sidebar')
    @include('puskesmas.partials.sidebar.puskesmas-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    @include('puskesmas.input.partials.header')

    {{-- Stats Summary --}}
    @include('puskesmas.input.partials.stats-summary')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Input Form (2 cols) --}}
        <div class="lg:col-span-2">
            @include('puskesmas.input.partials.input-form')
        </div>

        {{-- Recent Inputs (1 col) --}}
        <div class="lg:col-span-1">
            @include('puskesmas.input.partials.recent-inputs')
        </div>
    </div>
</div>

{{-- Scripts --}}
@include('puskesmas.input.scripts.form-validation')
@include('puskesmas.input.scripts.outlier-detection')
@include('puskesmas.input.scripts.auto-calculate')
@endsection