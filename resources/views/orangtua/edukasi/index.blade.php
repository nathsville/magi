@extends('layouts.app')

@section('title', 'Edukasi Gizi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
    {{-- Header --}}
    @include('orangtua.partials.header')

    <div class="container mx-auto px-4 py-6 max-w-7xl">
        {{-- Page Header --}}
        @include('orangtua.edukasi.partials.page-header')

        {{-- Search & Filter Bar --}}
        @include('orangtua.edukasi.partials.search-filter', ['categories' => $categories])

        {{-- Featured Article --}}
        @if(!request()->has('search') && !request()->has('kategori'))
            @include('orangtua.edukasi.partials.featured-article', ['featured' => $edukasiContent[0]])
        @endif

        {{-- Articles Grid --}}
        @include('orangtua.edukasi.partials.articles-grid', ['edukasiContent' => $edukasiContent])
    </div>
</div>
@endsection

@push('scripts')
@include('orangtua.edukasi.scripts.filter')
@endpush