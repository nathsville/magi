<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    {{-- Chart Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-bold text-gray-900">Tren Prevalensi Stunting</h3>
            <p class="text-sm text-gray-600 mt-1">Pergerakan prevalensi dari waktu ke waktu</p>
        </div>
        <div class="flex items-center space-x-2">
            <button onclick="toggleTrenChartType('line')" 
                id="btnTrenLine"
                class="px-3 py-1.5 bg-purple-600 text-white text-sm rounded-lg transition font-medium">
                Line
            </button>
            <button onclick="toggleTrenChartType('bar')" 
                id="btnTrenBar"
                class="px-3 py-1.5 bg-white text-gray-700 border border-gray-300 text-sm rounded-lg hover:bg-gray-50 transition">
                Bar
            </button>
        </div>
    </div>
    
    {{-- Chart Canvas --}}
    <div class="relative" style="height: 350px;">
        <canvas id="chartTrenPrevalensi"></canvas>
    </div>
    
    {{-- Chart Stats --}}
    <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-200">
        <div class="text-center">
            <p class="text-sm text-gray-600 mb-1">Tertinggi</p>
            <p class="text-2xl font-bold text-red-600" id="statTertinggi">-</p>
        </div>
        <div class="text-center">
            <p class="text-sm text-gray-600 mb-1">Rata-rata</p>
            <p class="text-2xl font-bold text-blue-600" id="statRataRata">-</p>
        </div>
        <div class="text-center">
            <p class="text-sm text-gray-600 mb-1">Terendah</p>
            <p class="text-2xl font-bold text-green-600" id="statTerendah">-</p>
        </div>
    </div>
</div>