@extends('layouts.app')

@section('title', 'Filter Audit Log')
@section('breadcrumb', 'Admin / Audit Log / Filter')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- 1. Header Section --}}
    @include('admin.audit-log.partials.filter.header')

    {{-- 2. Filter Form Section --}}
    @include('admin.audit-log.partials.filter.form')

    {{-- 3. Results Section --}}
    @include('admin.audit-log.partials.filter.results')
</div>
@endsection

@push('scripts')
    {{-- Scripts Helper --}}
    @include('admin.audit-log.scripts.detail-modal')
    
    <script>
    function exportFiltered() {
        const form = document.querySelector('form');
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();
        
        window.location.href = '{{ route("admin.audit-log.export") }}?' + params;
        showSuccessToast('File sedang diunduh...');
    }
    </script>
@endpush