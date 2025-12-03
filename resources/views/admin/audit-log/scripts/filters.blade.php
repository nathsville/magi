@extends('layouts.app')

@section('title', 'Filter Audit Log')
@section('breadcrumb', 'Admin / Audit Log / Filter')

@section('sidebar')
    @include('admin.partials.sidebar.admin-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Filter Audit Log</h1>
            <p class="text-sm text-gray-600 mt-1">Cari dan filter aktivitas sistem</p>
        </div>
        <a href="{{ route('admin.audit-log') }}" 
            class="flex items-center space-x-2 px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="text-sm font-medium">Kembali</span>
        </a>
    </div>

    {{-- Filter Form --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
            <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                <span>Advanced Filters</span>
            </h2>
        </div>

        <form action="{{ route('admin.audit-log.filter') }}" method="GET" class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                {{-- Search --}}
                <div class="lg:col-span-3">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        Pencarian
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" 
                            name="search" 
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="Cari dalam deskripsi..."
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                </div>

                {{-- User Filter --}}
                <div>
                    <label for="user" class="block text-sm font-medium text-gray-700 mb-2">
                        Pengguna
                    </label>
                    <select name="user" id="user" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        <option value="">Semua Pengguna</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id_user }}" {{ request('user') == $user->id_user ? 'selected' : '' }}>
                            {{ $user->nama }} (@{{ $user->username }})
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Action Filter --}}
                <div>
                    <label for="action" class="block text-sm font-medium text-gray-700 mb-2">
                        Aksi
                    </label>
                    <select name="action" id="action" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        <option value="">Semua Aksi</option>
                        @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                            {{ $action }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Module Filter --}}
                <div>
                    <label for="module" class="block text-sm font-medium text-gray-700 mb-2">
                        Module
                    </label>
                    <select name="module" id="module" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        <option value="">Semua Module</option>
                        @foreach($modules as $module)
                        <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>
                            {{ $module }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Date From --}}
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">
                        Dari Tanggal
                    </label>
                    <input type="date" 
                        name="date_from" 
                        id="date_from"
                        value="{{ request('date_from') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                </div>

                {{-- Date To --}}
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">
                        Sampai Tanggal
                    </label>
                    <input type="date" 
                        name="date_to" 
                        id="date_to"
                        value="{{ request('date_to') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                <a href="{{ route('admin.audit-log.filter') }}" 
                    class="text-sm font-medium text-gray-600 hover:text-gray-900">
                    Reset Filter
                </a>
                <div class="flex space-x-3">
                    <button type="button" 
                        onclick="exportFiltered()"
                        class="flex items-center space-x-2 px-5 py-2.5 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Export Hasil</span>
                    </button>
                    <button type="submit" 
                        class="flex items-center space-x-2 px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-blue-900 transition font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Terapkan Filter</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Results --}}
    @if(isset($logs))
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Hasil Pencarian</h2>
            <span class="text-sm text-gray-600">{{ $logs->total() }} hasil ditemukan</span>
        </div>

        @if($logs->count() > 0)
        <div class="divide-y divide-gray-200">
            @foreach($logs as $log)
            <div class="p-6 hover:bg-gray-50 transition cursor-pointer" onclick="showLogDetail({{ $log->id_audit }})">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-{{ $log->action_color }}-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-{{ $log->action_color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $log->action_icon }}"></path>
                        </svg>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-{{ $log->action_color }}-100 text-{{ $log->action_color }}-800">
                                        {{ $log->action }}
                                    </span>
                                    <span class="text-xs text-gray-500">•</span>
                                    <span class="text-xs font-medium text-gray-700">{{ $log->module }}</span>
                                </div>
                                <p class="text-sm text-gray-900">{{ $log->description }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 mt-2">
                            <div class="flex items-center text-xs text-gray-600">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>{{ $log->user?->nama ?? 'System' }}</span>
                            </div>
                            <span class="text-gray-400">•</span>
                            <div class="flex items-center text-xs text-gray-600">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $log->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $logs->links() }}
        </div>
        @endif

        @else
        <div class="p-12 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak Ada Hasil</h3>
            <p class="text-sm text-gray-600">Coba ubah filter pencarian Anda</p>
        </div>
        @endif
    </div>
    @endif
</div>
@endsection

@push('scripts')
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