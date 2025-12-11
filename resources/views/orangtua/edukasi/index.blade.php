@extends('layouts.app')

@section('title', 'Edukasi Gizi')

@section('sidebar')
    @include('orangtua.sidebar.sidebar-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    @include('orangtua.edukasi.partials.page-header')

    {{-- Search & Filter --}}
    @include('orangtua.edukasi.partials.search-filter', ['categories' => $categories])

    {{-- Featured Article --}}
    @if(!request()->has('search') && !request()->has('kategori'))
        @include('orangtua.edukasi.partials.featured-article', ['featured' => $edukasiContent[0]])
    @endif

    {{-- Articles Grid --}}
    @include('orangtua.edukasi.partials.articles-grid', ['edukasiContent' => $edukasiContent])
</div>
@endsection

@push('scripts')
@include('orangtua.edukasi.scripts.filter')
@endpush