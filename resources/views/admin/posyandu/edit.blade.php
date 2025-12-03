@extends('layouts.app')

@section('title', 'Edit Posyandu')
@section('breadcrumb', 'Admin / Posyandu / Edit')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- 1. Header Section --}}
    @include('admin.posyandu.partials.edit.header')

    {{-- 2. Info Banner (ID & Created At) --}}
    @include('admin.posyandu.partials.edit.info-banner')

    {{-- Form Wrapper --}}
    <form action="{{ route('admin.posyandu.update', $posyandu->id_posyandu) }}" method="POST" id="posyanduForm" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- 3. Section: Informasi Dasar (Nama, Puskesmas, Alamat) --}}
        @include('admin.posyandu.partials.edit.section-info')

        {{-- 4. Section: Lokasi (Kelurahan, Kecamatan) --}}
        @include('admin.posyandu.partials.edit.section-location')

        {{-- 5. Section: Status Operasional --}}
        @include('admin.posyandu.partials.edit.section-status')

        {{-- 6. Action Buttons --}}
        @include('admin.posyandu.partials.edit.action-buttons')
    </form>

    {{-- 7. Danger Zone (Hapus) --}}
    @include('admin.posyandu.partials.edit.danger-zone')
</div>
@endsection

{{-- 8. Javascript Logic --}}
@include('admin.posyandu.partials.edit.scripts')