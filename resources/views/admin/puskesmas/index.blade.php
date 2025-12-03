@extends('layouts.app')

@section('title', 'Kelola Puskesmas')
@section('breadcrumb', 'Admin / Puskesmas')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header Section --}}
    @include('admin.puskesmas.partials.header')

    {{-- Search & Filter Section --}}
    @include('admin.puskesmas.partials.search-filter', [
        'searchValue' => request('search'),
        'kecamatanValue' => request('kecamatan'),
        'statusValue' => request('status'),
        'kecamatanList' => $kecamatanList,
        'totalCount' => $puskesmas->count(),
        'totalAll' => $puskesmas->total()
    ])

    {{-- Data Table or Empty State --}}
    @if($puskesmas->count() > 0)
        @include('admin.puskesmas.partials.table', [
            'puskesmas' => $puskesmas
        ])
    @else
        @include('admin.puskesmas.partials.empty-state')
    @endif
</div>
@endsection

{{-- Scripts --}}
@push('scripts')
    @include('admin.puskesmas.scripts.autocomplete')
    @include('admin.puskesmas.scripts.actions')
@endpush