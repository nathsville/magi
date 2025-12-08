@extends('layouts.app')

@section('title', 'Data Anak')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
    {{-- Header --}}
    @include('orangtua.partials.header')

    <div class="container mx-auto px-4 py-6 max-w-7xl">
        {{-- Page Header --}}
        @include('orangtua.anak.partials.page-header')

        {{-- Stats Cards --}}
        @include('orangtua.anak.partials.stats-cards', [
            'totalAnak' => $totalAnak,
            'anakNormal' => $anakNormal,
            'anakStunting' => $anakStunting
        ])

        {{-- Filter Panel --}}
        @include('orangtua.anak.partials.filter-panel')

        {{-- Children Grid --}}
        @include('orangtua.anak.partials.anak-grid', ['anakList' => $anakList])
    </div>
</div>
@endsection

@push('scripts')
@include('orangtua.anak.scripts.filter')
@endpush