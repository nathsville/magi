@extends('layouts.app')

@section('title', 'Generate Laporan Baru')
@section('breadcrumb', 'Puskesmas / Laporan / Generate')

@section('sidebar')
    @include('puskesmas.partials.sidebar.puskesmas-menu')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Generate Laporan Baru</h1>
                <p class="text-gray-600 mt-1">Buat laporan stunting untuk periode tertentu</p>
            </div>
            <a href="{{ route('puskesmas.laporan.index') }}" 
                class="flex items-center px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Alert Errors --}}
    @if($errors->any())
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Terdapat {{ $errors->count() }} kesalahan:</h3>
                <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('puskesmas.laporan.store') }}" method="POST" id="formLaporan">
        @csrf

        {{-- Section 1: Jenis Laporan --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-primary to-blue-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <span class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center mr-3 text-sm">1</span>
                    Jenis Laporan
                </h2>
            </div>
            <div class="p-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Pilih Jenis Laporan <span class="text-red-500">*</span>
                </label>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Laporan Puskesmas --}}
                    <label class="relative flex items-start p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition
                        {{ old('jenis_laporan') == 'Laporan Puskesmas' ? 'border-primary bg-blue-50' : 'border-gray-300' }}">
                        <input type="radio" name="jenis_laporan" value="Laporan Puskesmas" 
                            {{ old('jenis_laporan', 'Laporan Puskesmas') == 'Laporan Puskesmas' ? 'checked' : '' }}
                            class="mt-1 text-primary focus:ring-primary" required>
                        <div class="ml-3">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="font-semibold text-gray-900">Laporan Puskesmas</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">
                                Laporan internal untuk tingkat Puskesmas
                            </p>
                        </div>
                    </label>

                    {{-- Laporan Daerah --}}
                    <label class="relative flex items-start p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition
                        {{ old('jenis_laporan') == 'Laporan Daerah' ? 'border-primary bg-blue-50' : 'border-gray-300' }}">
                        <input type="radio" name="jenis_laporan" value="Laporan Daerah" 
                            {{ old('jenis_laporan') == 'Laporan Daerah' ? 'checked' : '' }}
                            class="mt-1 text-primary focus:ring-primary">
                        <div class="ml-3">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-semibold text-gray-900">Laporan Daerah</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">
                                Laporan untuk tingkat Kabupaten/Kota (DPPKB)
                            </p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        {{-- Section 2: Periode Laporan --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-primary to-blue-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <span class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center mr-3 text-sm">2</span>
                    Periode Laporan
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Bulan --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Bulan <span class="text-red-500">*</span>
                        </label>
                        <select name="periode_bulan" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">-- Pilih Bulan --</option>
                            @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $bulan)
                                <option value="{{ $index + 1 }}" {{ old('periode_bulan', date('n')) == ($index + 1) ? 'selected' : '' }}>
                                    {{ $bulan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tahun --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tahun <span class="text-red-500">*</span>
                        </label>
                        <select name="periode_tahun" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">-- Pilih Tahun --</option>
                            @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                                <option value="{{ $year }}" {{ old('periode_tahun', date('Y')) == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                {{-- Info Box --}}
                <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-800">Informasi</p>
                            <p class="text-sm text-blue-700 mt-1">
                                Sistem akan mengumpulkan semua data pengukuran dan stunting pada periode yang dipilih untuk menghasilkan laporan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 3: Preview Data (Optional - Will be shown after period selected) --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6" id="previewSection" style="display: none;">
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <span class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center mr-3 text-sm">3</span>
                    Preview Data (Estimasi)
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-600 mb-1">Total Anak</p>
                        <p class="text-2xl font-bold text-gray-900" id="previewTotalAnak">-</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <p class="text-sm text-green-600 mb-1">Normal</p>
                        <p class="text-2xl font-bold text-green-700" id="previewNormal">-</p>
                    </div>
                    <div class="bg-red-50 rounded-lg p-4">
                        <p class="text-sm text-red-600 mb-1">Stunting</p>
                        <p class="text-2xl font-bold text-red-700" id="previewStunting">-</p>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3 text-center">
                    * Data preview adalah estimasi berdasarkan periode yang dipilih
                </p>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-between bg-gray-50 rounded-xl p-6">
            <a href="{{ route('puskesmas.laporan.index') }}" 
                class="px-6 py-3 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
            
            <button type="submit" id="btnSubmit"
                class="flex items-center px-8 py-3 text-white bg-primary rounded-lg hover:bg-blue-700 transition shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Generate Laporan</span>
            </button>
        </div>
    </form>
</div>

{{-- Generate Script --}}
@include('puskesmas.laporan.scripts.generate')
@endsection