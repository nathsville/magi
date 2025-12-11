<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide flex items-center">
            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Analisis Status Gizi
        </h3>
    </div>

    <div class="p-6">
        {{-- Status Badge Large --}}
        @php
            $statusClass = match($stunting->status_stunting) {
                'Normal' => 'bg-green-50 border-green-200 text-green-800',
                'Stunting Ringan' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
                'Stunting Sedang' => 'bg-orange-50 border-orange-200 text-orange-800',
                'Stunting Berat' => 'bg-red-50 border-red-200 text-red-800',
                default => 'bg-gray-50 border-gray-200 text-gray-800'
            };
        @endphp

        <div class="mb-6 p-4 rounded-xl border-2 {{ $statusClass }} flex items-center justify-between">
            <div>
                <p class="text-sm font-medium opacity-80">Kesimpulan Status:</p>
                <p class="text-2xl font-extrabold mt-1 uppercase tracking-wide">{{ $stunting->status_stunting }}</p>
            </div>
            {{-- Validation Status Pill --}}
            <div class="text-right">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white border border-gray-200 shadow-sm">
                    @if($stunting->status_validasi === 'Validated')
                        <span class="text-green-600 flex items-center"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Valid</span>
                    @elseif($stunting->status_validasi === 'Pending')
                        <span class="text-yellow-600 flex items-center"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Pending</span>
                    @else
                        <span class="text-red-600 flex items-center"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Ditolak</span>
                    @endif
                </span>
            </div>
        </div>

        {{-- Grid Z-Scores --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- TB/U --}}
            <div class="p-3 rounded-lg border text-center {{ $stunting->zscore_tb_u < -2 ? 'bg-red-50 border-red-100' : 'bg-gray-50 border-gray-200' }}">
                <p class="text-xs text-gray-500 font-medium">TB / U</p>
                <p class="text-xl font-bold mt-1 text-gray-900">{{ number_format($stunting->zscore_tb_u, 2) }}</p>
                <p class="text-[10px] text-gray-400">Z-Score</p>
            </div>
            {{-- BB/U --}}
            <div class="p-3 rounded-lg border text-center {{ $stunting->zscore_bb_u < -2 ? 'bg-red-50 border-red-100' : 'bg-gray-50 border-gray-200' }}">
                <p class="text-xs text-gray-500 font-medium">BB / U</p>
                <p class="text-xl font-bold mt-1 text-gray-900">{{ number_format($stunting->zscore_bb_u, 2) }}</p>
                <p class="text-[10px] text-gray-400">Z-Score</p>
            </div>
            {{-- BB/TB --}}
            <div class="p-3 rounded-lg border text-center {{ $stunting->zscore_bb_tb < -2 ? 'bg-red-50 border-red-100' : 'bg-gray-50 border-gray-200' }}">
                <p class="text-xs text-gray-500 font-medium">BB / TB</p>
                <p class="text-xl font-bold mt-1 text-gray-900">{{ number_format($stunting->zscore_bb_tb, 2) }}</p>
                <p class="text-[10px] text-gray-400">Z-Score</p>
            </div>
        </div>
    </div>
</div>