@extends('layouts.app')

@section('title', 'Tambah Data Master')
@section('breadcrumb', 'Data Master / Tambah')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- 1. Header Section --}}
    @include('admin.datamaster.partials.create.header')

    {{-- Form Wrapper --}}
    <form action="{{ route('admin.datamaster.store') }}" method="POST" id="datamasterForm" class="space-y-6">
        @csrf

        {{-- 2. Section: Informasi Data (Tipe, Kode, Nilai) --}}
        @include('admin.datamaster.partials.create.section-basic-info')

        {{-- 3. Section: Detail & Status (Deskripsi, Status Radio) --}}
        @include('admin.datamaster.partials.create.section-detail-status')

        {{-- 4. Action Buttons (Simpan/Batal) --}}
        @include('admin.datamaster.partials.create.action-buttons')
    </form>
</div>
@endsection

{{-- 5. Javascript Logic --}}
@include('admin.datamaster.partials.create.scripts')