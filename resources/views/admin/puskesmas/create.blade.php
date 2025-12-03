@extends('layouts.app')

@section('title', 'Tambah Puskesmas')
@section('breadcrumb', 'Admin / Puskesmas / Tambah')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- 1. Header Section --}}
    @include('admin.puskesmas.partials.create.header')

    {{-- Form Wrapper --}}
    <form action="{{ route('admin.puskesmas.store') }}" method="POST" id="puskesmasForm" class="space-y-6">
        @csrf

        {{-- 2. Section: Informasi Dasar (Nama, Alamat, Kecamatan, Telepon) --}}
        @include('admin.puskesmas.partials.create.section-info')

        {{-- 3. Section: Status Operasional --}}
        @include('admin.puskesmas.partials.create.section-status')

        {{-- 4. Action Buttons --}}
        @include('admin.puskesmas.partials.create.action-buttons')
    </form>
</div>
@endsection

{{-- 5. Javascript Logic --}}
@include('admin.puskesmas.partials.create.scripts')