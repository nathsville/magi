<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        No
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Data Anak
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Pengukuran
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Z-Score & Status
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Posyandu
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Tanggal
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($dataStunting as $index => $data)
                <tr class="hover:bg-gray-50 transition">
                    {{-- No --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $dataStunting->firstItem() + $index }}
                    </td>

                    {{-- Data Anak --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($data->dataPengukuran->anak->nama_anak, 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $data->dataPengukuran->anak->nama_anak }}
                                </p>
                                <div class="flex items-center space-x-2 text-xs text-gray-600 mt-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded bg-gray-100">
                                        {{ $data->dataPengukuran->anak->jenis_kelamin === 'L' ? '👦 Laki-laki' : '👧 Perempuan' }}
                                    </span>
                                    <span>{{ $data->dataPengukuran->umur_bulan }} bulan</span>
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- Pengukuran --}}
                    <td class="px-6 py-4">
                        <div class="space-y-1 text-xs">
                            <div class="flex items-center">
                                <span class="text-gray-600 w-16">BB:</span>
                                <span class="font-semibold text-gray-900">{{ $data->dataPengukuran->berat_badan }} kg</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-gray-600 w-16">TB:</span>
                                <span class="font-semibold text-gray-900">{{ $data->dataPengukuran->tinggi_badan }} cm</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-gray-600 w-16">LK:</span>
                                <span class="font-semibold text-gray-900">{{ $data->dataPengukuran->lingkar_kepala }} cm</span>
                            </div>
                        </div>
                    </td>

                    {{-- Z-Score & Status --}}
                    <td class="px-6 py-4">
                        <div class="space-y-2">
                            <div class="text-xs">
                                <span class="text-gray-600">TB/U:</span>
                                <span class="font-semibold ml-1 
                                    {{ $data->zscore_tb_u >= -2 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($data->zscore_tb_u, 2) }}
                                </span>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $data->status_stunting === 'Normal' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $data->status_stunting === 'Stunting Ringan' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $data->status_stunting === 'Stunting Sedang' ? 'bg-orange-100 text-orange-800' : '' }}
                                {{ $data->status_stunting === 'Stunting Berat' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $data->status_stunting }}
                            </span>
                        </div>
                    </td>

                    {{-- Posyandu --}}
                    <td class="px-6 py-4">
                        <div class="text-sm">
                            <p class="font-medium text-gray-900">{{ $data->dataPengukuran->posyandu->nama_posyandu }}</p>
                            <p class="text-xs text-gray-500">{{ $data->dataPengukuran->posyandu->kelurahan }}</p>
                        </div>
                    </td>

                    {{-- Tanggal --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm">
                            <p class="font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($data->dataPengukuran->tanggal_ukur)->format('d M Y') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($data->dataPengukuran->tanggal_ukur)->diffForHumans() }}
                            </p>
                        </div>
                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('puskesmas.validasi.detail', $data->id_stunting) }}" 
                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-primary rounded-lg hover:bg-blue-700 transition">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-500 text-lg font-medium">Tidak ada data</p>
                        <p class="text-gray-400 text-sm mt-2">Gunakan filter untuk mencari data atau ubah periode pencarian</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($dataStunting->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $dataStunting->links() }}
    </div>
    @endif
</div>