@extends('layouts.app')

@section('title', 'Tambah Intervensi Stunting')
@section('breadcrumb', 'Puskesmas / Intervensi / Tambah')

@section('sidebar')
    @include('puskesmas.partials.sidebar.puskesmas-menu')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Tambah Intervensi Stunting</h1>
                <p class="text-gray-600 mt-1">Buat program intervensi baru untuk anak yang terindikasi stunting</p>
            </div>
            <a href="{{ route('puskesmas.intervensi.index') }}" 
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
    <form action="{{ route('puskesmas.intervensi.store') }}" method="POST" enctype="multipart/form-data" id="formIntervensi">
        @csrf

        {{-- Section 1: Pilih Anak --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-primary to-blue-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <span class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center mr-3 text-sm">1</span>
                    Pilih Anak yang Akan Diintervensi
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Anak <span class="text-red-500">*</span>
                    </label>
                    <select name="id_anak" id="id_anak" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">-- Pilih Anak --</option>
                        @foreach($anakStuntingList as $anak)
                            <option value="{{ $anak->id_anak }}" {{ old('id_anak') == $anak->id_anak ? 'selected' : '' }}>
                                {{ $anak->nama_anak }} 
                                ({{ $anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}, 
                                {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now()) }} bulan) 
                                - {{ $anak->posyandu->nama_posyandu ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-2">Hanya menampilkan anak yang terindikasi stunting</p>
                </div>
            </div>
        </div>

        {{-- Section 2: Detail Intervensi --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-primary to-blue-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <span class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center mr-3 text-sm">2</span>
                    Detail Intervensi
                </h2>
            </div>
            <div class="p-6 space-y-4">
                {{-- Jenis Intervensi --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Jenis Intervensi <span class="text-red-500">*</span>
                    </label>
                    <select name="jenis_intervensi" id="jenis_intervensi" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="PMT" {{ old('jenis_intervensi') == 'PMT' ? 'selected' : '' }}>PMT (Pemberian Makanan Tambahan)</option>
                        <option value="Suplemen/Vitamin" {{ old('jenis_intervensi') == 'Suplemen/Vitamin' ? 'selected' : '' }}>Suplemen/Vitamin</option>
                        <option value="Edukasi Gizi" {{ old('jenis_intervensi') == 'Edukasi Gizi' ? 'selected' : '' }}>Edukasi Gizi</option>
                        <option value="Rujukan RS" {{ old('jenis_intervensi') == 'Rujukan RS' ? 'selected' : '' }}>Rujukan Rumah Sakit</option>
                        <option value="Konseling" {{ old('jenis_intervensi') == 'Konseling' ? 'selected' : '' }}>Konseling Orang Tua</option>
                        <option value="Lainnya" {{ old('jenis_intervensi') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi Program <span class="text-red-500">*</span>
                    </label>
                    <textarea name="deskripsi" rows="4" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="Jelaskan detail program intervensi yang akan dilakukan...">{{ old('deskripsi') }}</textarea>
                </div>

                {{-- Grid: Tanggal & Dosis --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Pelaksanaan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_pelaksanaan" 
                            value="{{ old('tanggal_pelaksanaan', date('Y-m-d')) }}" 
                            max="{{ date('Y-m-d') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Dosis/Jumlah
                        </label>
                        <input type="text" name="dosis_jumlah" 
                            value="{{ old('dosis_jumlah') }}" 
                            placeholder="Contoh: 1 sachet/hari, 500ml susu"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Opsional, untuk suplemen atau PMT</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 3: Penanggung Jawab & Tindak Lanjut --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-primary to-blue-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <span class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center mr-3 text-sm">3</span>
                    Penanggung Jawab & Status
                </h2>
            </div>
            <div class="p-6 space-y-4">
                {{-- Grid: Petugas & Status --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Petugas Penanggung Jawab <span class="text-red-500">*</span>
                        </label>
                        <select name="id_petugas" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">-- Pilih Petugas --</option>
                            @foreach($petugasList as $petugas)
                                <option value="{{ $petugas->id_user }}" {{ old('id_petugas') == $petugas->id_user ? 'selected' : '' }}>
                                    {{ $petugas->nama }} ({{ $petugas->role }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Status Tindak Lanjut <span class="text-red-500">*</span>
                        </label>
                        <select name="status_tindak_lanjut" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="Sedang Berjalan" {{ old('status_tindak_lanjut') == 'Sedang Berjalan' ? 'selected' : '' }}>Sedang Berjalan</option>
                            <option value="Selesai" {{ old('status_tindak_lanjut') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Perlu Rujukan Lanjutan" {{ old('status_tindak_lanjut') == 'Perlu Rujukan Lanjutan' ? 'selected' : '' }}>Perlu Rujukan Lanjutan</option>
                        </select>
                    </div>
                </div>

                {{-- Catatan --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Catatan Tambahan
                    </label>
                    <textarea name="catatan" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="Catatan atau hasil evaluasi (opsional)">{{ old('catatan') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Section 4: Upload File Pendukung --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-primary to-blue-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <span class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center mr-3 text-sm">4</span>
                    File Pendukung (Opsional)
                </h2>
            </div>
            <div class="p-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Upload Dokumen Pendukung
                    </label>
                    <input type="file" name="file_pendukung" id="file_pendukung" 
                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-2">
                        Format: PDF, JPG, PNG, DOC, DOCX. Max: 2MB. Contoh: foto kegiatan, surat rujukan, dll.
                    </p>
                    <div id="filePreview" class="mt-3 hidden">
                        <div class="flex items-center space-x-2 text-sm text-gray-700 bg-gray-50 px-3 py-2 rounded-lg">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span id="fileName"></span>
                            <button type="button" onclick="clearFile()" class="ml-auto text-red-600 hover:text-red-800">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-between bg-gray-50 rounded-xl p-6">
            <a href="{{ route('puskesmas.intervensi.index') }}" 
                class="px-6 py-3 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
            
            <button type="submit" id="btnSubmit"
                class="flex items-center px-8 py-3 text-white bg-primary rounded-lg hover:bg-blue-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Simpan Intervensi</span>
            </button>
        </div>
    </form>
</div>

{{-- File Upload Script --}}
@include('puskesmas.intervensi.scripts.file-upload')

{{-- Submit Confirmation Script --}}
<script>
document.getElementById('formIntervensi').addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Simpan Data Intervensi?',
        text: 'Pastikan semua data sudah benar sebelum disimpan',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0000878',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Periksa Lagi'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            document.getElementById('btnSubmit').disabled = true;
            document.getElementById('btnSubmit').innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menyimpan...</span>
            `;
            
            this.submit();
        }
    });
});
</script>
@endsection