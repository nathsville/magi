<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        No
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Jenis & Periode
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Statistik
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Persentase Stunting
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Tanggal Dibuat
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($laporanList as $index => $laporan)
                <tr class="hover:bg-gray-50 transition">
                    {{-- No --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $laporanList->firstItem() + $index }}
                    </td>

                    {{-- Jenis & Periode --}}
                    <td class="px-6 py-4">
                        <div class="space-y-1">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $laporan->jenis_laporan === 'Laporan Puskesmas' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ $laporan->jenis_laporan }}
                            </span>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ \Carbon\Carbon::create($laporan->periode_tahun, $laporan->periode_bulan)->format('F Y') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                Oleh: {{ $laporan->pembuat->nama ?? 'N/A' }}
                            </p>
                        </div>
                    </td>

                    {{-- Statistik --}}
                    <td class="px-6 py-4">
                        <div class="space-y-1 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Total Anak:</span>
                                <span class="font-semibold text-gray-900">{{ $laporan->total_anak }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-green-600">Normal:</span>
                                <span class="font-semibold text-green-700">{{ $laporan->total_normal }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-red-600">Stunting:</span>
                                <span class="font-semibold text-red-700">{{ $laporan->total_stunting }}</span>
                            </div>
                        </div>
                    </td>

                    {{-- Persentase Stunting --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-3">
                            <div class="flex-1">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full transition-all
                                        {{ $laporan->persentase_stunting >= 30 ? 'bg-red-600' : '' }}
                                        {{ $laporan->persentase_stunting >= 20 && $laporan->persentase_stunting < 30 ? 'bg-orange-500' : '' }}
                                        {{ $laporan->persentase_stunting < 20 ? 'bg-green-500' : '' }}"
                                        style="width: {{ min($laporan->persentase_stunting, 100) }}%">
                                    </div>
                                </div>
                            </div>
                            <span class="text-lg font-bold
                                {{ $laporan->persentase_stunting >= 30 ? 'text-red-600' : '' }}
                                {{ $laporan->persentase_stunting >= 20 && $laporan->persentase_stunting < 30 ? 'text-orange-500' : '' }}
                                {{ $laporan->persentase_stunting < 20 ? 'text-green-600' : '' }}">
                                {{ number_format($laporan->persentase_stunting, 1) }}%
                            </span>
                        </div>
                    </td>

                    {{-- Tanggal Dibuat --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm">
                            <p class="font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($laporan->tanggal_buat)->format('d M Y') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($laporan->tanggal_buat)->format('H:i') }} WIB
                            </p>
                        </div>
                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('puskesmas.laporan.preview', $laporan->id_laporan) }}" 
                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-primary rounded-lg hover:bg-blue-700 transition">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat
                            </a>
                            
                            <a href="{{ route('puskesmas.laporan.download', $laporan->id_laporan) }}" 
                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-500 text-lg font-medium">Belum ada laporan</p>
                        <p class="text-gray-400 text-sm mt-2">Generate laporan baru untuk memulai</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($laporanList->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $laporanList->links() }}
    </div>
    @endif
</div>