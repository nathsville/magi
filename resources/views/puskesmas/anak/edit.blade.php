@extends('layouts.app')

@section('title', 'Edit Data Anak')
@section('breadcrumb', 'Puskesmas / Data Anak / Edit')

@section('sidebar')
    @include('puskesmas.partials.sidebar.puskesmas-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Data Anak</h1>
            <p class="text-gray-600 mt-1">Update informasi data anak</p>
        </div>
        
        <a href="{{ route('puskesmas.anak.index') }}" 
            class="flex items-center px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Form Edit --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-primary to-blue-600 px-6 py-4">
            <h2 class="text-lg font-bold text-white">Form Edit Data Anak</h2>
        </div>

        <form id="editForm" action="{{ route('puskesmas.anak.update', $anak->id_anak) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            {{-- Alert Info --}}
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-blue-800">Perubahan data akan dicatat dalam audit trail</p>
                        <p class="text-xs text-blue-700 mt-1">Pastikan data yang diinput sudah benar sebelum menyimpan</p>
                    </div>
                </div>
            </div>

            {{-- Section 1: Data Anak --}}
            <div class="space-y-4">
                <h3 class="text-base font-bold text-gray-900 flex items-center">
                    <span class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">1</span>
                    Data Identitas Anak
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Nama Anak --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap Anak <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_anak" id="nama_anak" required
                            value="{{ old('nama_anak', $anak->nama_anak) }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('nama_anak') border-red-500 @enderror">
                        @error('nama_anak')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NIK --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            NIK Anak <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nik_anak" id="nik_anak" required
                            value="{{ old('nik_anak', $anak->nik_anak) }}"
                            maxlength="16" pattern="[0-9]{16}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('nik_anak') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">16 digit angka</p>
                        @error('nik_anak')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('jenis_kelamin') border-red-500 @enderror">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('jenis_kelamin', $anak->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $anak->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tempat Lahir --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tempat Lahir
                        </label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir"
                            value="{{ old('tempat_lahir', $anak->tempat_lahir) }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" required
                            value="{{ old('tanggal_lahir', $anak->tanggal_lahir->format('Y-m-d')) }}"
                            max="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('tanggal_lahir') border-red-500 @enderror">
                        @error('tanggal_lahir')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Anak Ke --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Anak Ke-
                        </label>
                        <input type="number" name="anak_ke" id="anak_ke"
                            value="{{ old('anak_ke', $anak->anak_ke) }}"
                            min="1" max="20"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Urutan anak dalam keluarga</p>
                    </div>
                </div>
            </div>

            {{-- Section 2: Posyandu --}}
            <div class="space-y-4 pt-6 border-t border-gray-200">
                <h3 class="text-base font-bold text-gray-900 flex items-center">
                    <span class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">2</span>
                    Posyandu Terdaftar
                </h3>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Posyandu <span class="text-red-500">*</span>
                    </label>
                    <select name="id_posyandu" id="id_posyandu" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('id_posyandu') border-red-500 @enderror">
                        <option value="">Pilih Posyandu</option>
                        @foreach($posyanduList as $posyandu)
                            <option value="{{ $posyandu->id_posyandu }}" {{ old('id_posyandu', $anak->id_posyandu) == $posyandu->id_posyandu ? 'selected' : '' }}>
                                {{ $posyandu->nama_posyandu }} - {{ $posyandu->kelurahan }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_posyandu')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Display Info Orang Tua (Read-only) --}}
            <div class="space-y-4 pt-6 border-t border-gray-200">
                <h3 class="text-base font-bold text-gray-900 flex items-center">
                    <span class="w-8 h-8 bg-gray-400 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">ℹ</span>
                    Informasi Orang Tua (Read-Only)
                </h3>

                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600 text-xs mb-1">Nama Ayah</p>
                            <p class="font-semibold text-gray-900">{{ $anak->orangTua->nama_ayah ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-xs mb-1">Nama Ibu</p>
                            <p class="font-semibold text-gray-900">{{ $anak->orangTua->nama_ibu ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-xs mb-1">NIK Orang Tua</p>
                            <p class="font-semibold text-gray-900">{{ $anak->orangTua->nik ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-xs mb-1">No. Telepon</p>
                            <p class="font-semibold text-gray-900">{{ $anak->orangTua->no_telepon ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Submit Buttons --}}
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('puskesmas.anak.index') }}" 
                    class="px-6 py-2.5 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Batal
                </a>
                
                <button type="submit" id="submitBtn"
                    class="flex items-center px-8 py-3 text-white bg-primary rounded-lg hover:bg-blue-700 transition shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script for form validation --}}
<script>
document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        icon: 'question',
        title: 'Konfirmasi Perubahan Data',
        html: `
            <p class="text-gray-700 mb-4">Apakah Anda yakin ingin menyimpan perubahan data anak ini?</p>
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 rounded-r-lg text-left">
                <p class="text-xs text-yellow-800">
                    <strong>Perhatian:</strong> Semua perubahan akan tercatat dalam audit trail sistem
                </p>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#000878',
        cancelButtonColor: '#6B7280'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menyimpan...
            `;
            
            // Submit form
            this.submit();
        }
    });
});

// NIK validation (16 digits)
document.getElementById('nik_anak').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '').substring(0, 16);
});
</script>
@endsection