<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    {{-- Chart Header --}}
    <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                </svg>
                Distribusi Status Gizi
            </h3>
            <div class="flex items-center space-x-2">
                <button onclick="toggleChartType('distribusiChart', 'pie')" 
                    id="btnDistribusiPie"
                    class="px-3 py-1.5 bg-white text-purple-700 text-sm rounded-lg transition font-medium">
                    Pie
                </button>
                <button onclick="toggleChartType('distribusiChart', 'doughnut')" 
                    id="btnDistribusiDoughnut"
                    class="px-3 py-1.5 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm rounded-lg transition">
                    Doughnut
                </button>
            </div>
        </div>
    </div>

    {{-- Chart Body --}}
    <div class="p-6">
        <div class="relative" style="height: 300px;">
            <canvas id="distribusiChart"></canvas>
        </div>

        {{-- Legend Detail --}}
        <div class="grid grid-cols-2 gap-3 mt-6 pt-6 border-t border-gray-200">
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-green-500 rounded"></div>
                    <span class="text-sm font-medium text-gray-700">Normal</span>
                </div>
                <span class="text-lg font-bold text-green-700" id="distNormal">0</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-yellow-500 rounded"></div>
                    <span class="text-sm font-medium text-gray-700">Stunting Ringan</span>
                </div>
                <span class="text-lg font-bold text-yellow-700" id="distRingan">0</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg">
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-orange-500 rounded"></div>
                    <span class="text-sm font-medium text-gray-700">Stunting Sedang</span>
                </div>
                <span class="text-lg font-bold text-orange-700" id="distSedang">0</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-red-500 rounded"></div>
                    <span class="text-sm font-medium text-gray-700">Stunting Berat</span>
                </div>
                <span class="text-lg font-bold text-red-700" id="distBerat">0</span>
            </div>
        </div>
    </div>
</div>