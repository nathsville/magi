@extends('layouts.app')

@section('title', 'Registrasi Anak Baru')

@section('sidebar')
    @include('posyandu.sidebar-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Registrasi Anak Baru</h1>
            <p class="text-sm text-gray-600 mt-1">Daftarkan anak baru ke {{ $posyandu->nama_posyandu }}</p>
        </div>
        <a href="{{ route('posyandu.anak.index') }}" class="flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    @if(session('error'))
        @include('posyandu.partials.alert-error', ['message' => session('error')])
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        {{-- Card Header --}}
        <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Formulir Pendaftaran
            </h2>
        </div>

        <form method="POST" action="{{ route('posyandu.anak.store') }}" id="registrationForm" class="p-6 space-y-8">
            @csrf

            {{-- Section 1: Orang Tua --}}
            <div>
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide border-b border-gray-200 pb-2 mb-4">
                    1. Data Orang Tua
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Orang Tua <span class="text-red-500">*</span>
                        </label>
                        <select name="id_orangtua" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] @error('id_orangtua') border-red-500 @enderror">
                            <option value="">-- Pilih --</option>
                            @foreach($orangTuaList as $orangTua)
                            <option value="{{ $orangTua->id_orangtua }}" {{ old('id_orangtua') == $orangTua->id_orangtua ? 'selected' : '' }}>
                                {{ $orangTua->nama_ayah ?? $orangTua->nama_ibu }} ({{ $orangTua->nik }})
                            </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Orang tua wajib terdaftar sebelumnya.</p>
                        @error('id_orangtua')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Section 2: Data Anak --}}
            <div>
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide border-b border-gray-200 pb-2 mb-4">
                    2. Identitas Anak
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_anak" value="{{ old('nama_anak') }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">NIK Anak <span class="text-red-500">*</span></label>
                        <input type="text" name="nik_anak" value="{{ old('nik_anak') }}" maxlength="16" required
                               placeholder="16 digit angka"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <div class="flex space-x-4">
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition w-full {{ old('jenis_kelamin') == 'L' ? 'border-[#000878] bg-blue-50' : 'border-gray-300' }}">
                                <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }} class="text-[#000878] focus:ring-[#000878]" required>
                                <span class="ml-2 text-gray-700 font-medium">Laki-laki</span>
                            </label>
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition w-full {{ old('jenis_kelamin') == 'P' ? 'border-[#000878] bg-blue-50' : 'border-gray-300' }}">
                                <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }} class="text-[#000878] focus:ring-[#000878]" required>
                                <span class="ml-2 text-gray-700 font-medium">Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" max="{{ date('Y-m-d') }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Anak Ke- <span class="text-red-500">*</span></label>
                        <input type="number" name="anak_ke" value="{{ old('anak_ke') }}" min="1" max="20" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]">
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('posyandu.anak.index') }}" class="px-6 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 font-medium transition">
                    Batal
                </a>
                <button type="submit" class="px-8 py-2.5 bg-[#000878] text-white font-medium rounded-lg hover:bg-blue-900 transition shadow-md">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
@include('posyandu.anak.scripts.create')
@endpush