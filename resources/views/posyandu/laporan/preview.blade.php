@extends('layouts.app')

@section('title', 'Preview Laporan')

@section('sidebar')
    @include('posyandu.sidebar-menu')
@endsection

@section('content')
<div class="space-y-6">
    {{-- Back & Actions Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 no-print">
        <a href="{{ route('posyandu.laporan.index') }}" class="inline-flex items-center text-gray-600 hover:text-[#000878] font-medium transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>

        <div class="flex space-x-3">
            <button onclick="window.print()" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition shadow-sm flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak
            </button>

            <form method="POST" action="{{ route('posyandu.laporan.generate') }}" class="inline">
                @csrf
                <input type="hidden" name="bulan" value="{{ $stats['bulan'] }}">
                <input type="hidden" name="tahun" value="{{ $stats['tahun'] }}">
                <input type="hidden" name="format" value="pdf">
                <button type="submit" class="px-4 py-2 bg-[#000878] text-white font-medium rounded-lg hover:bg-blue-900 transition shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download PDF
                </button>
            </form>
        </div>
    </div>

    {{-- Laporan Content (Paper View) --}}
    <div id="laporanContent" class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 md:p-12 mx-auto max-w-4xl">
        {{-- Header Dokumen --}}
        <div class="text-center mb-8 pb-6 border-b-2 border-gray-800">
            <h1 class="text-2xl font-bold text-gray-900 mb-1">LAPORAN BULANAN POSYANDU</h1>
            <h2 class="text-xl font-bold text-[#000878] uppercase mb-2">{{ $posyandu->nama_posyandu }}</h2>
            <p class="text-gray-600 text-sm">{{ $posyandu->kelurahan }}, {{ $posyandu->kecamatan }}</p>
            {{-- PERBAIKAN DI SINI: Menambahkan casting (int) dan parameter tanggal 1 --}}
            <p class="text-gray-900 mt-4 font-medium">
                Periode: {{ \Carbon\Carbon::createFromDate((int)$stats['tahun'], (int)$stats['bulan'], 1)->format('F Y') }}
            </p>
        </div>

        {{-- Summary Section --}}
        <div class="mb-10">
            <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider border-l-4 border-[#000878] pl-3">
                Ringkasan Data
            </h3>

            <table class="w-full text-sm border-collapse">
                <tr class="border-b border-gray-100">
                    <td class="py-2 text-gray-600">Total Anak Terdaftar</td>
                    <td class="py-2 text-right font-bold text-gray-900">{{ $stats['total_anak'] }}</td>
                </tr>
                <tr class="border-b border-gray-100">
                    <td class="py-2 text-gray-600">Total Pengukuran</td>
                    <td class="py-2 text-right font-bold text-gray-900">{{ $stats['total_pengukuran'] }}</td>
                </tr>
                <tr class="border-b border-gray-100">
                    <td class="py-2 text-gray-600">Status Normal</td>
                    <td class="py-2 text-right font-bold text-green-700">{{ $stats['normal'] }}</td>
                </tr>
                <tr class="bg-red-50 border-b border-red-100">
                    <td class="py-2 pl-2 font-semibold text-red-800">Total Stunting</td>
                    <td class="py-2 pr-2 text-right font-bold text-red-800">{{ $stats['total_stunting'] }} ({{ $stats['persentase_stunting'] }}%)</td>
                </tr>
            </table>
        </div>

        {{-- Detail Table --}}
        <div>
            <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider border-l-4 border-[#000878] pl-3">
                Detail Pengukuran
            </h3>

            @if($detailData->isEmpty())
                <p class="text-center text-gray-500 py-8 italic border border-dashed border-gray-300 rounded">Tidak ada data pengukuran</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border border-gray-200">
                        <thead class="bg-gray-100 text-gray-900 font-semibold">
                            <tr>
                                <th class="px-3 py-2 border-b">Tgl</th>
                                <th class="px-3 py-2 border-b">Nama</th>
                                <th class="px-3 py-2 border-b text-center">Umur</th>
                                <th class="px-3 py-2 border-b text-center">BB</th>
                                <th class="px-3 py-2 border-b text-center">TB</th>
                                <th class="px-3 py-2 border-b text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($detailData as $item)
                            <tr>
                                <td class="px-3 py-2 text-gray-600">{{ \Carbon\Carbon::parse($item->tanggal_ukur)->format('d/m') }}</td>
                                <td class="px-3 py-2 font-medium text-gray-900">{{ optional($item->anak)->nama_anak ?? 'Data Anak Terhapus' }}</td>
                                <td class="px-3 py-2 text-center text-gray-600">{{ $item->umur_bulan }} bln</td>
                                <td class="px-3 py-2 text-center">{{ number_format($item->berat_badan, 1) }}</td>
                                <td class="px-3 py-2 text-center">{{ number_format($item->tinggi_badan, 1) }}</td>
                                <td class="px-3 py-2 text-center">
                                    @php
                                        $status = optional($item->stunting)->status_stunting;
                                        $colorClass = $status === 'Normal' ? 'text-green-700' : 'text-red-700';
                                    @endphp
                                    <span class="text-xs font-bold {{ $status ? $colorClass : 'text-gray-500' }}">
                                        {{ $status ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Signatures --}}
        <div class="mt-16 grid grid-cols-2 gap-8">
            <div></div>
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-16">Petugas Posyandu</p>
                <p class="text-sm font-bold text-gray-900 border-t border-gray-400 pt-2 inline-block min-w-[150px]">
                    {{ Auth::user()->nama }}
                </p>
            </div>
        </div>
    </div>
</div>

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
        margin: 0;
        padding: 0;
        box-shadow: none;
        border: none;
    }
    .no-print {
        display: none !important;
    }
}
</style>
@endsection