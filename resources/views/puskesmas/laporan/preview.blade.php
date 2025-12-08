@extends('layouts.app')

@section('title', 'Preview Laporan')
@section('breadcrumb', 'Puskesmas / Laporan / Preview')

@section('sidebar')
    @include('puskesmas.partials.sidebar.puskesmas-menu')
@endsection

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Preview Laporan</h1>
                <p class="text-gray-600 mt-1">{{ $laporan->jenis_laporan }} - {{ \Carbon\Carbon::create($laporan->periode_tahun, $laporan->periode_bulan)->format('F Y') }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('puskesmas.laporan.index') }}" 
                    class="flex items-center px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
                
                <a href="{{ route('puskesmas.laporan.download', $laporan->id_laporan) }}" 
                    class="flex items-center px-6 py-2.5 text-white bg-green-600 rounded-lg hover:bg-green-700 transition shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download PDF
                </a>
            </div>
        </div>
    </div>

    {{-- Laporan Content --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden" id="laporanContent">
        
        {{-- Header Laporan --}}
        <div class="bg-gradient-to-r from-primary to-blue-600 px-8 py-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold">{{ $laporan->jenis_laporan }}</h2>
                    <p class="text-blue-100 mt-1">Periode: {{ \Carbon\Carbon::create($laporan->periode_tahun, $laporan->periode_bulan)->format('F Y') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-blue-100">Dibuat oleh:</p>
                    <p class="font-semibold">{{ $laporan->pembuat->nama ?? 'N/A' }}</p>
                    <p class="text-xs text-blue-100 mt-1">{{ \Carbon\Carbon::parse($laporan->tanggal_buat)->format('d F Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Ringkasan Statistik --}}
        <div class="p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Statistik</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Total Anak --}}
                <div class="bg-blue-50 rounded-xl p-6 border-2 border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600 mb-1">Total Anak Terdata</p>
                            <p class="text-4xl font-bold text-blue-900">{{ $laporan->total_anak }}</p>
                        </div>
                        <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>

                {{-- Normal --}}
                <div class="bg-green-50 rounded-xl p-6 border-2 border-green-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600 mb-1">Status Normal</p>
                            <p class="text-4xl font-bold text-green-900">{{ $laporan->total_normal }}</p>
                            <p class="text-xs text-green-600 mt-1">
                                {{ $laporan->total_anak > 0 ? number_format(($laporan->total_normal / $laporan->total_anak) * 100, 1) : 0 }}% dari total
                            </p>
                        </div>
                        <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

                {{-- Stunting --}}
                <div class="bg-red-50 rounded-xl p-6 border-2 border-red-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-red-600 mb-1">Terindikasi Stunting</p>
                            <p class="text-4xl font-bold text-red-900">{{ $laporan->total_stunting }}</p>
                            <p class="text-xs text-red-600 mt-1">
                                {{ number_format($laporan->persentase_stunting, 1) }}% dari total
                            </p>
                        </div>
                        <svg class="w-12 h-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Persentase Stunting Visual --}}
            <div class="mb-8">
                <h4 class="text-lg font-bold text-gray-900 mb-3">Persentase Stunting</h4>
                <div class="bg-gray-100 rounded-xl p-6">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <div class="w-full bg-gray-300 rounded-full h-8">
                                <div class="h-8 rounded-full flex items-center justify-center text-white font-bold text-sm transition-all
                                    {{ $laporan->persentase_stunting >= 30 ? 'bg-red-600' : '' }}
                                    {{ $laporan->persentase_stunting >= 20 && $laporan->persentase_stunting < 30 ? 'bg-orange-500' : '' }}
                                    {{ $laporan->persentase_stunting < 20 ? 'bg-green-500' : '' }}"
                                    style="width: {{ min($laporan->persentase_stunting, 100) }}%">
                                    {{ number_format($laporan->persentase_stunting, 1) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex items-center justify-center space-x-6 text-sm">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-500 rounded mr-2"></div>
                            <span class="text-gray-700">Baik (&lt;20%)</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-orange-500 rounded mr-2"></div>
                            <span class="text-gray-700">Sedang (20-30%)</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-600 rounded mr-2"></div>
                            <span class="text-gray-700">Tinggi (≥30%)</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kesimpulan --}}
            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                <h4 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Kesimpulan & Rekomendasi
                </h4>
                <div class="prose max-w-none text-gray-700">
                    <p class="mb-3">
                        Berdasarkan data pengukuran periode <strong>{{ \Carbon\Carbon::create($laporan->periode_tahun, $laporan->periode_bulan)->format('F Y') }}</strong>, 
                        dari <strong>{{ $laporan->total_anak }} anak</strong> yang terdata, 
                        <strong>{{ $laporan->total_stunting }} anak ({{ number_format($laporan->persentase_stunting, 1) }}%)</strong> 
                        terindikasi mengalami stunting.
                    </p>
                    
                    @if($laporan->persentase_stunting >= 30)
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mt-4">
                            <p class="font-semibold text-red-800">⚠️ Status: KRITIS</p>
                            <p class="text-red-700 text-sm mt-1">
                                Persentase stunting sangat tinggi (≥30%). Diperlukan intervensi intensif dan program percepatan penanganan stunting secara menyeluruh.
                            </p>
                        </div>
                    @elseif($laporan->persentase_stunting >= 20)
                        <div class="bg-orange-50 border-l-4 border-orange-500 p-4 mt-4">
                            <p class="font-semibold text-orange-800">⚠️ Status: PERLU PERHATIAN</p>
                            <p class="text-orange-700 text-sm mt-1">
                                Persentase stunting berada di level sedang (20-30%). Perlu peningkatan program edukasi gizi dan monitoring berkala.
                            </p>
                        </div>
                    @else
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 mt-4">
                            <p class="font-semibold text-green-800">✓ Status: BAIK</p>
                            <p class="text-green-700 text-sm mt-1">
                                Persentase stunting masih terkendali (&lt;20%). Pertahankan program pencegahan dan monitoring rutin.
                            </p>
                        </div>
                    @endif

                    <div class="mt-4">
                        <p class="font-semibold text-gray-900 mb-2">Rekomendasi Tindak Lanjut:</p>
                        <ul class="list-disc list-inside space-y-1 text-sm">
                            <li>Intensifkan program PMT (Pemberian Makanan Tambahan) untuk anak stunting</li>
                            <li>Lakukan konseling gizi kepada orang tua secara berkala</li>
                            <li>Tingkatkan koordinasi antara Posyandu, Puskesmas, dan DPPKB</li>
                            <li>Monitoring dan evaluasi program intervensi setiap bulan</li>
                            @if($laporan->persentase_stunting >= 20)
                                <li>Rujuk kasus stunting berat ke fasilitas kesehatan yang lebih lengkap</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Metadata --}}
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <p><span class="font-semibold">Pembuat Laporan:</span> {{ $laporan->pembuat->nama ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Jabatan:</span> {{ $laporan->pembuat->role ?? 'N/A' }}</p>
                    </div>
                    <div class="text-right">
                        <p><span class="font-semibold">Tanggal Dibuat:</span> {{ \Carbon\Carbon::parse($laporan->tanggal_buat)->format('d F Y, H:i') }} WIB</p>
                        <p><span class="font-semibold">Wilayah:</span> {{ $laporan->tipe_wilayah }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Action Buttons Bottom --}}
    <div class="mt-6 flex items-center justify-center space-x-4">
        <button onclick="window.print()" 
            class="flex items-center px-6 py-3 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Print Laporan
        </button>
        
        <a href="{{ route('puskesmas.laporan.download', $laporan->id_laporan) }}" 
            class="flex items-center px-6 py-3 text-white bg-green-600 rounded-lg hover:bg-green-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Download PDF
        </a>
    </div>
</div>

{{-- Print Styles --}}
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #laporanContent, #laporanContent * {
        visibility: visible;
    }
    #laporanContent {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .no-print {
        display: none !important;
    }
}
</style>
@endsection