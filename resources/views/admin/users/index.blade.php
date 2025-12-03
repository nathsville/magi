@extends('layouts.app')

@section('title', 'Kelola Pengguna')
@section('breadcrumb', 'Admin / Pengguna')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header Section --}}
    @include('admin.users.partials.header')

    {{-- Search & Filter Section --}}
    @include('admin.users.partials.search-filter', [
        'searchValue' => request('search'),
        'roleValue' => request('role'),
        'statusValue' => request('status'),
        'roleList' => $roleList,
        'totalCount' => $users->count(),
        'totalAll' => $users->total()
    ])

    {{-- Data Table or Empty State --}}
    @if($users->count() > 0)
        @include('admin.users.partials.table', [
            'users' => $users
        ])
    @else
        @include('admin.users.partials.empty-state')
    @endif
</div>
@endsection

{{-- Scripts --}}
@push('scripts')
    @include('admin.users.scripts.autocomplete')
    @include('admin.users.scripts.actions')
@endpush