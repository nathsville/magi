<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    @if($pengukuranList->isEmpty())
        <div class="p-12 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002 2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Tidak Ada Data Pengukuran</h3>
            <p class="text-sm text-gray-500 mb-6">
                @if(request()->hasAny(['search', 'tanggal_dari', 'tanggal_sampai', 'status']))
                    Tidak ditemukan data yang sesuai kriteria pencarian.
                @else
                    Belum ada data pengukuran yang tercatat.
                @endif
            </p>
            <div class="flex justify-center space-x-3">
                @if(request()->hasAny(['search', 'tanggal_dari', 'tanggal_sampai', 'status']))
                <button onclick="clearFilters()" class="px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition text-sm">
                    Reset Filter
                </button>
                @endif
                <a href="{{ route('posyandu.pengukuran.form') }}" class="flex items-center px-4 py-2 bg-[#000878] text-white font-medium rounded-lg hover:bg-blue-900 transition text-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Input Pengukuran Baru
                </a>
            </div>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <a href="?sort_by=tanggal_ukur&sort_order={{ request('sort_order') === 'asc' ? 'desc' : 'asc' }}" class="group flex items-center hover:text-[#000878]">
                                Tanggal
                                <svg class="w-3 h-3 ml-1 text-gray-400 group-hover:text-[#000878]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Data Anak</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Umur</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">BB / TB</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Gizi</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($pengukuranList as $index => $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $pengukuranList->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($item->tanggal_ukur)->format('d M Y') }}
                            </div>
                            @if($item->tanggal_ukur === today()->toDateString())
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-blue-100 text-blue-800 mt-1">
                                    Hari Ini
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold border
                                    {{ $item->anak->jenis_kelamin === 'L' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-pink-50 text-pink-600 border-pink-100' }}">
                                    {{ substr($item->anak->nama_anak, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-gray-900">{{ $item->anak->nama_anak }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->anak->nik_anak }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                            {{ round($item->umur_bulan) }} bln
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="text-xs space-y-1">
                                <div class="flex justify-center space-x-1">
                                    <span class="text-gray-500">BB:</span>
                                    <span class="font-medium text-gray-900">{{ number_format($item->berat_badan, 1) }} kg</span>
                                </div>
                                <div class="flex justify-center space-x-1">
                                    <span class="text-gray-500">TB:</span>
                                    <span class="font-medium text-gray-900">{{ number_format($item->tinggi_badan, 1) }} cm</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($item->dataStunting)
                                @php
                                    $status = $item->dataStunting->status_stunting;
                                    $colorClass = match($status) {
                                        'Normal' => 'bg-green-100 text-green-800',
                                        'Stunting Ringan' => 'bg-yellow-100 text-yellow-800',
                                        'Stunting Sedang' => 'bg-orange-100 text-orange-800',
                                        'Stunting Berat' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                    {{ $status }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <a href="{{ route('posyandu.pengukuran.detail', $item->id_pengukuran) }}" 
                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-primary rounded-lg hover:bg-blue-700 transition shadow-sm">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pengukuranList->hasPages())
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $pengukuranList->links() }}
        </div>
        @endif
    @endif
</div>