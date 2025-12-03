@extends('layouts.app')

@section('title', 'Edit Data Master')
@section('breadcrumb', 'Data Master / Edit')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- 1. Header Section --}}
    @include('admin.datamaster.partials.edit.header')

    {{-- 2. Info Banner --}}
    @include('admin.datamaster.partials.edit.alert-info')

    {{-- 3. Main Update Form --}}
    <form action="{{ route('admin.datamaster.update', $data->id_master) }}" method="POST" id="datamasterForm" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Section: Informasi Dasar (Tipe, Kode, Nilai) --}}
        @include('admin.datamaster.partials.edit.section-basic-info')

        {{-- Section: Detail & Status (Deskripsi, Status Radio) --}}
        @include('admin.datamaster.partials.edit.section-detail-status')

        {{-- Action Buttons (Simpan/Batal) --}}
        @include('admin.datamaster.partials.edit.action-buttons')
    </form>

    {{-- 4. Danger Zone (Hapus) --}}
    @include('admin.datamaster.partials.edit.danger-zone')
</div>
@endsection

{{-- 5. Javascript Logic --}}
@include('admin.datamaster.partials.edit.scripts')