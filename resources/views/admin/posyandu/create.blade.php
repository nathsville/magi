@extends('layouts.app')

@section('title', 'Tambah Posyandu')
@section('breadcrumb', 'Admin / Posyandu / Tambah')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- 1. Header Section --}}
    @include('admin.posyandu.partials.create.header')

    {{-- Form Wrapper --}}
    <form action="{{ route('admin.posyandu.store') }}" method="POST" id="posyanduForm" class="space-y-6">
        @csrf

        {{-- 2. Section: Informasi Dasar (Nama, Puskesmas, Alamat) --}}
        @include('admin.posyandu.partials.create.section-info')

        {{-- 3. Section: Lokasi (Kelurahan, Kecamatan) --}}
        @include('admin.posyandu.partials.create.section-location')

        {{-- 4. Section: Status Operasional --}}
        @include('admin.posyandu.partials.create.section-status')

        {{-- 5. Action Buttons --}}
        @include('admin.posyandu.partials.create.action-buttons')
    </form>
</div>
@endsection

{{-- 6. Javascript Logic --}}
@include('admin.posyandu.partials.create.scripts')