@extends('layouts.app')

@section('title', 'Kelola Posyandu')
@section('breadcrumb', 'Admin / Posyandu')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header Section --}}
    @include('admin.posyandu.partials.header')

    {{-- Search & Filter Section --}}
    @include('admin.posyandu.partials.search-filter', [
        'searchValue' => request('search'),
        'puskesmasValue' => request('puskesmas'),
        'kecamatanValue' => request('kecamatan'),
        'statusValue' => request('status'),
        'puskesmasList' => $puskesmasList,
        'kecamatanList' => $kecamatanList,
        'totalCount' => $posyandu->count(),
        'totalAll' => $posyandu->total()
    ])

    {{-- Data Table or Empty State --}}
    @if($posyandu->count() > 0)
        @include('admin.posyandu.partials.table', [
            'posyandu' => $posyandu
        ])
    @else
        @include('admin.posyandu.partials.empty-state')
    @endif
</div>
@endsection

{{-- Scripts --}}
@push('scripts')
    @include('admin.posyandu.scripts.autocomplete')
    @include('admin.posyandu.scripts.actions')
@endpush