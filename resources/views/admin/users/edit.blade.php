@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('breadcrumb', 'Admin / Pengguna / Edit')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- 1. Header Section --}}
    @include('admin.users.partials.edit.header')

    {{-- 2. Info Banner --}}
    @include('admin.users.partials.edit.info-banner')

    {{-- 3. Self-Edit Warning --}}
    @include('admin.users.partials.edit.self-edit-warning')

    {{-- Form Wrapper --}}
    <form action="{{ route('admin.users.update', $user->id_user) }}" method="POST" id="penggunaForm" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- 4. Section: Informasi Akun (Username, Password, Nama) --}}
        @include('admin.users.partials.edit.section-account')

        {{-- 5. Section: Role & Kontak --}}
        @include('admin.users.partials.edit.section-role-contact')

        {{-- 6. Section: Status Akun --}}
        @include('admin.users.partials.edit.section-status')

        {{-- 7. Action Buttons --}}
        @include('admin.users.partials.edit.action-buttons')
    </form>

    {{-- 8. Danger Zone (Hapus) --}}
    @include('admin.users.partials.edit.danger-zone')
</div>
@endsection

{{-- 9. Javascript Logic --}}
@include('admin.users.partials.edit.scripts')