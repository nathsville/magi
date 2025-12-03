@extends('layouts.app')

@section('title', 'Dashboard Petugas Puskesmas')
@section('header', 'Dashboard Petugas Puskesmas')

@section('sidebar')
    <a href="{{ route('puskesmas.dashboard') }}" class="block px-6 py-3 sidebar-active">
        Dashboard
    </a>
    <a href="{{ route('puskesmas.validasi') }}" class="block px-6 py-3 hover:bg-blue-800">
        Validasi Data
    </a>
    <a href="{{ route('puskesmas.monitoring') }}" class="block px-6 py-3 hover:bg-blue-800">
        Monitoring
    </a>
    <a href="{{ route('puskesmas.laporan') }}" class="block px-6 py-3 hover:bg-blue-800">
        Laporan
    </a>
@endsection

@section('content')
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="card">
            <p class="text-sm text-gray-600">Total Penduduk</p>
            <p class="text-3xl font-bold text-primary mt-2">{{ $totalAnak }}</p>
        </div>

        <div class="card">
            <p class="text-sm text-gray-600">Kasus Stunting</p>
            <p class="text-3xl font-bold text-red-600 mt-2">{{ $totalStunting }}</p>
        </div>

        <div class="card">
            <p class="text-sm text-gray-600">Persentase Stunting</p>
            <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $persentaseStunting }}%</p>
        </div>

        <div class="card">
            <p class="text-sm text-gray-600">Posyandu Aktif</p>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalPosyandu }}</p>
        </div>
    </div>

    <!-- Monitoring & Laporan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="card">
            <h3 class="text-lg font-semibold mb-4">Monitoring Data Stunting</h3>
            <div class="text-center py-8">
                <p class="text-gray-600 mb-4">Grafik Tren Stunting 6 Bulan Terakhir</p>
            </div>
        </div>

        <div class="card">
            <h3 class="text-lg font-semibold mb-4">Laporan Stunting</h3>
            <div class="space-y-2">
                @foreach($laporanStunting as $laporan)
                    <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                        <div>
                            <p class="text-sm font-medium">{{ $laporan['periode'] }}</p>
                            <p class="text-xs text-gray-600">{{ $laporan['jenis_laporan'] }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded 
                            @if($laporan['status'] == 'Selesai') bg-green-100 text-green-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ $laporan['status'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Data Posyandu & Intervensi -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card">
            <h3 class="text-lg font-semibold mb-4">Data Posyandu</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Posyandu</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Anak Terdaftar</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kasus Stunting</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prevalensi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($dataPosyandu as $posyandu)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $posyandu->nama_posyandu }}</td>
                                <td class="px-4 py-3 text-sm">{{ $posyandu->total_anak }}</td>
                                <td class="px-4 py-3 text-sm">-</td>
                                <td class="px-4 py-3 text-sm">-</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <h3 class="text-lg font-semibold mb-4">Intervensi Stunting</h3>
            <div class="space-y-3">
                <div class="p-3 bg-blue-50 rounded">
                    <p class="text-sm font-medium">Pemberian Makanan Tambahan</p>
                    <p class="text-xs text-gray-600 mt-1">{{ $intervensiStunting['pemberian_makanan_tambahan'] }}</p>
                </div>

                <div class="p-3 bg-green-50 rounded">
                    <p class="text-sm font-medium">Edukasi Gizi</p>
                    <p class="text-xs text-gray-600 mt-1">{{ $intervensiStunting['edukasi_gizi'] }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection