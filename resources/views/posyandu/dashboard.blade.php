@extends('layouts.app')

@section('title', 'Dashboard Petugas Posyandu')
@section('header', 'Dashboard Petugas Posyandu')

@section('sidebar')
    <a href="{{ route('posyandu.dashboard') }}" class="block px-6 py-3 sidebar-active">
        Dashboard
    </a>
    <a href="{{ route('posyandu.input-data') }}" class="block px-6 py-3 hover:bg-blue-800">
        Input Data
    </a>
    <a href="{{ route('posyandu.data-anak') }}" class="block px-6 py-3 hover:bg-blue-800">
        Data Anak
    </a>
    <a href="{{ route('posyandu.monitoring') }}" class="block px-6 py-3 hover:bg-blue-800">
        Monitoring
    </a>
@endsection

@section('content')
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="card">
            <p class="text-sm text-gray-600">Anak Terdaftar</p>
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
            <p class="text-sm text-gray-600">Pengukuran Bulan Ini</p>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $pengukuranBulanIni }}</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="card">
            <h3 class="text-lg font-semibold mb-4">Input Data Pengukuran</h3>
            <a href="{{ route('posyandu.input-data') }}" class="btn-primary inline-block">
                Input Data
            </a>
        </div>

        <div class="card">
            <h3 class="text-lg font-semibold mb-4">Data Pengukuran Terbaru</h3>
            <div class="space-y-2">
                @forelse($pengukuranTerbaru as $data)
                    <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                        <div>
                            <p class="text-sm font-medium">{{ $data->anak->nama_anak }}</p>
                            <p class="text-xs text-gray-600">{{ $data->tanggal_ukur->format('d M Y') }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded 
                            @if($data->dataStunting && $data->dataStunting->status_stunting == 'Normal') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $data->dataStunting->status_stunting ?? 'Pending' }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Anak Perlu Perhatian -->
    <div class="card">
        <h3 class="text-lg font-semibold mb-4">Anak Perlu Perhatian</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Anak</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Umur</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($anakPerluPerhatian as $anak)
                        <tr>
                            <td class="px-4 py-3 text-sm">{{ $anak->nama_anak }}</td>
                            <td class="px-4 py-3 text-sm">{{ $anak->umur_bulan }} bulan</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800">
                                    {{ $anak->statusGiziTerakhir }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <button class="text-primary hover:underline">Lihat</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-sm text-center text-gray-500">
                                Tidak ada anak yang perlu perhatian khusus
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection