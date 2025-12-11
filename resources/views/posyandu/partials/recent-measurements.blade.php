<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    {{-- Header --}}
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-white">Pengukuran Terbaru</h3>
            </div>
            <a href="{{ route('posyandu.pengukuran.riwayat') }}" 
               class="text-xs font-medium text-white bg-white/20 hover:bg-white/30 px-3 py-1.5 rounded-lg transition flex items-center">
                Lihat Semua
                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>

    @if($recentMeasurements->isEmpty())
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
            </div>
            <p class="text-gray-500 text-sm">Belum ada data pengukuran</p>
            <a href="{{ route('posyandu.pengukuran.form') }}" class="inline-flex items-center mt-4 px-4 py-2 bg-[#000878] text-white text-sm font-medium rounded-lg hover:bg-blue-900 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Pengukuran
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Anak</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Hasil (BB/TB)</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status Gizi</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Validasi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentMeasurements as $measurement)
                    <tr class="hover:bg-gray-50 transition group">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($measurement->tanggal_ukur)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('posyandu.anak.show', $measurement->anak->id_anak) }}" class="text-gray-900 font-medium hover:text-[#000878] transition">
                                {{ $measurement->anak->nama_anak }}
                            </a>
                            <p class="text-xs text-gray-500">{{ $measurement->anak->nik_anak }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="text-xs font-medium text-gray-900 space-y-1">
                                <div class="bg-blue-50 px-2 py-0.5 rounded text-blue-700 border border-blue-100 inline-block min-w-[60px]">
                                    {{ number_format($measurement->berat_badan, 1) }} kg
                                </div>
                                <div class="bg-green-50 px-2 py-0.5 rounded text-green-700 border border-green-100 inline-block min-w-[60px]">
                                    {{ number_format($measurement->tinggi_badan, 1) }} cm
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($measurement->stunting)
                                @php
                                    $status = $measurement->stunting->status_stunting;
                                    $colors = [
                                        'Normal' => 'bg-green-100 text-green-800',
                                        'Stunting Ringan' => 'bg-yellow-100 text-yellow-800',
                                        'Stunting Sedang' => 'bg-orange-100 text-orange-800',
                                        'Stunting Berat' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $colors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $status }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400 italic">Menunggu Analisis</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($measurement->stunting)
                                @php
                                    $validasi = $measurement->stunting->status_validasi;
                                    $iconClass = match($validasi) {
                                        'Validated' => 'text-green-500',
                                        'Rejected' => 'text-red-500',
                                        default => 'text-yellow-500'
                                    };
                                    $iconPath = match($validasi) {
                                        'Validated' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                        'Rejected' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
                                        default => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                                    };
                                @endphp
                                <div class="flex flex-col items-center">
                                    <svg class="w-5 h-5 {{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"></path>
                                    </svg>
                                    <span class="text-[10px] text-gray-500 mt-0.5">{{ $validasi }}</span>
                                </div>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>