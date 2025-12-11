<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    {{-- Chart Header --}}
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                </svg>
                Tren Stunting 6 Bulan Terakhir
            </h3>
            <div class="flex items-center space-x-2">
                <button onclick="toggleChartType('trenChart', 'line')" 
                    id="btnTrenLine"
                    class="px-3 py-1.5 bg-white text-indigo-700 text-sm rounded-lg transition font-medium">
                    Line
                </button>
                <button onclick="toggleChartType('trenChart', 'bar')" 
                    id="btnTrenBar"
                    class="px-3 py-1.5 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm rounded-lg transition">
                    Bar
                </button>
            </div>
        </div>
    </div>

    {{-- Chart Body --}}
    <div class="p-6">
        <div class="relative" style="height: 300px;">
            <canvas id="trenChart"></canvas>
        </div>

        {{-- Chart Summary --}}
        <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-200">
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-1">Total Kasus</p>
                <p class="text-2xl font-bold text-indigo-900" id="trenTotalKasus">0</p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-1">Rata-rata/Bulan</p>
                <p class="text-2xl font-bold text-indigo-900" id="trenRataRata">0</p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-1">Tren</p>
                <div class="flex items-center justify-center space-x-2" id="trenDirection">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"></path>
                    </svg>
                    <span class="text-sm font-semibold text-gray-600">Stabil</span>
                </div>
            </div>
        </div>
    </div>
</div>