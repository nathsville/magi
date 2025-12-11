<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-3 border-b border-gray-200">
        <h3 class="text-sm font-bold text-white uppercase tracking-wide">Ringkasan Medis</h3>
    </div>
    <div class="p-6 space-y-5">
        {{-- Total Pengukuran --}}
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Total Pengukuran</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalPengukuran }}x</p>
            </div>
            <div class="p-2 bg-white rounded-full border border-gray-200 text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002 2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
        </div>

        @if($statusTerakhir)
        {{-- Z-Score Details --}}
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase mb-3">Nilai Z-Score Terbaru</p>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 rounded-lg border {{ $statusTerakhir->status_stunting === 'Normal' ? 'bg-green-50 border-green-100' : 'bg-orange-50 border-orange-100' }}">
                    <span class="text-sm font-medium text-gray-700">TB / Umur</span>
                    <span class="text-sm font-bold {{ $statusTerakhir->status_stunting === 'Normal' ? 'text-green-700' : 'text-orange-700' }}">
                        {{ number_format($statusTerakhir->zscore_tb_u, 2) }}
                    </span>
                </div>
                <div class="flex justify-between items-center p-3 rounded-lg bg-gray-50 border border-gray-200">
                    <span class="text-sm font-medium text-gray-700">BB / Umur</span>
                    <span class="text-sm font-bold text-gray-900">
                        {{ number_format($statusTerakhir->zscore_bb_u, 2) }}
                    </span>
                </div>
                <div class="flex justify-between items-center p-3 rounded-lg bg-gray-50 border border-gray-200">
                    <span class="text-sm font-medium text-gray-700">BB / TB</span>
                    <span class="text-sm font-bold text-gray-900">
                        {{ number_format($statusTerakhir->zscore_bb_tb, 2) }}
                    </span>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>