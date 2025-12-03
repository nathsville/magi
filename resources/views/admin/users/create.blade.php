@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('breadcrumb', 'Admin / Pengguna / Tambah')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- 1. Header Section --}}
    @include('admin.users.partials.create.header')

    {{-- Form Wrapper --}}
    <form action="{{ route('admin.users.store') }}" method="POST" id="penggunaForm" class="space-y-6">
        @csrf

        {{-- 2. Section: Informasi Akun (Username, Password, Nama) --}}
        @include('admin.users.partials.create.section-account')

        {{-- 3. Section: Role & Kontak --}}
        @include('admin.users.partials.create.section-role-contact')

        {{-- 4. Section: Status Akun --}}
        @include('admin.users.partials.create.section-status')

        {{-- 5. Action Buttons --}}
        @include('admin.users.partials.create.action-buttons')
    </form>
</div>
@endsection

{{-- 6. Javascript Logic --}}
@include('admin.users.partials.create.scripts')