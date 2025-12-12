<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    {{-- Chart Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-bold text-gray-900">Distribusi Stunting per Usia</h3>
            <p class="text-sm text-gray-600 mt-1">Sebaran kasus berdasarkan kelompok umur</p>
        </div>
        <div class="flex items-center space-x-2">
            <button onclick="toggleDistribusiChartType('doughnut')" 
                id="btnDistDoughnut"
                class="px-3 py-1.5 bg-purple-600 text-white text-sm rounded-lg transition font-medium">
                Doughnut
            </button>
            <button onclick="toggleDistribusiChartType('bar')" 
                id="btnDistBar"
                class="px-3 py-1.5 bg-white text-gray-700 border border-gray-300 text-sm rounded-lg hover:bg-gray-50 transition">
                Bar
            </button>
        </div>
    </div>
    
    {{-- Chart Canvas --}}
    <div class="relative" style="height: 350px;">
        <canvas id="chartDistribusiUsia"></canvas>
    </div>
    
    {{-- Legend Detail --}}
    <div class="grid grid-cols-2 gap-3 mt-6 pt-6 border-t border-gray-200">
        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-200">
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                <span class="text-sm font-medium text-gray-900">0-6 Bulan</span>
            </div>
            <span class="text-lg font-bold text-red-600" id="usia0_6">-</span>
        </div>
        <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg border border-orange-200">
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 rounded-full bg-orange-500"></div>
                <span class="text-sm font-medium text-gray-900">7-12 Bulan</span>
            </div>
            <span class="text-lg font-bold text-orange-600" id="usia7_12">-</span>
        </div>
        <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-200">
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                <span class="text-sm font-medium text-gray-900">13-24 Bulan</span>
            </div>
            <span class="text-lg font-bold text-yellow-600" id="usia13_24">-</span>
        </div>
        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-200">
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                <span class="text-sm font-medium text-gray-900">25-60 Bulan</span>
            </div>
            <span class="text-lg font-bold text-green-600" id="usia25_60">-</span>
        </div>
    </div>
</div>