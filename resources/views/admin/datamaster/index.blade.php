@extends('layouts.app')

@section('title', 'Data Master')
@section('breadcrumb', 'Data Master')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header Section --}}
    @include('admin.datamaster.partials.header')

    {{-- Search & Filter Section --}}
    @include('admin.datamaster.partials.search-filter', [
        'searchValue' => request('search'),
        'tipeValue' => request('tipe'),
        'totalData' => $dataMaster->sum(function($items) { return $items->count(); }),
        'totalKategori' => $dataMaster->count()
    ])

    {{-- Data Tables or Empty State --}}
    @forelse($dataMaster as $tipe => $items)
        @include('admin.datamaster.partials.table-group', [
            'tipe' => $tipe,
            'items' => $items
        ])
    @empty
        @include('admin.datamaster.partials.empty-state')
    @endforelse
</>
@endsection

{{-- Scripts --}}
@push('scripts')
    @include('admin.datamaster.scripts.autocomplete')
@endpush