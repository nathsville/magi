<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    {{-- Header Solid Blue --}}
    <div class="bg-[#000878] px-6 py-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                <span>Tren Kasus Stunting</span>
            </h2>
            <span class="px-3 py-1 text-xs font-medium text-blue-100 bg-white/10 rounded-full border border-white/20">
                6 Bulan Terakhir
            </span>
        </div>
    </div>

    <div class="p-6">
        {{-- Legend --}}
        <div class="flex items-center justify-end mb-4">
            <div class="flex items-center space-x-2 px-3 py-1 bg-gray-50 rounded-lg border border-gray-100">
                <span class="w-3 h-3 bg-red-500 rounded-full shadow-sm"></span>
                <span class="text-sm font-medium text-gray-600">Kasus Stunting</span>
            </div>
        </div>

        {{-- Chart Canvas --}}
        <div class="relative h-[300px] w-full">
            <canvas id="trendChart"></canvas>
        </div>

        {{-- Hidden data for Chart.js --}}
        {{-- Pastikan controller mengirimkan data dengan key 'bulan' dan 'kasus' --}}
        <div id="chartData" class="hidden" 
            data-labels='@json(array_column($laporanStunting ?? [], "bulan"))'
            data-values='@json(array_column($laporanStunting ?? [], "kasus"))'>
        </div>
    </div>
</div>