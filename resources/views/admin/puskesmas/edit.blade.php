@extends('layouts.app')

@section('title', 'Edit Puskesmas')
@section('breadcrumb', 'Admin / Puskesmas / Edit')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- 1. Header Section --}}
    @include('admin.puskesmas.partials.edit.header')

    {{-- 2. Info Banner --}}
    @include('admin.puskesmas.partials.edit.info-banner')

    {{-- Form Wrapper --}}
    <form action="{{ route('admin.puskesmas.update', $puskesmas->id_puskesmas) }}" method="POST" id="puskesmasForm" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- 3. Section: Informasi Dasar (Nama, Alamat, Kecamatan, Telepon) --}}
        @include('admin.puskesmas.partials.edit.section-info')

        {{-- 4. Section: Status Operasional --}}
        @include('admin.puskesmas.partials.edit.section-status')

        {{-- 5. Action Buttons --}}
        @include('admin.puskesmas.partials.edit.action-buttons')
    </form>

    {{-- 6. Danger Zone (Hapus) --}}
    @include('admin.puskesmas.partials.edit.danger-zone')
</div>

{{-- Hidden Delete Form --}}
<form id="deleteForm" action="{{ route('admin.puskesmas.destroy', $puskesmas->id_puskesmas) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection

{{-- 7. Javascript Logic --}}
@include('admin.puskesmas.partials.edit.scripts')