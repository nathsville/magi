<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    {{-- Chart Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-bold text-gray-900">Perbandingan Antar Wilayah</h3>
            <p class="text-sm text-gray-600 mt-1">Komparasi prevalensi per kecamatan</p>
        </div>
        <button onclick="showDetailWilayah()" 
            class="px-3 py-1.5 text-purple-600 hover:bg-purple-50 text-sm rounded-lg transition font-medium">
            Detail →
        </button>
    </div>
    
    {{-- Chart Canvas --}}
    <div class="relative" style="height: 350px;">
        <canvas id="chartPerbandinganWilayah"></canvas>
    </div>
    
    {{-- Target Line Info --}}
    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm text-yellow-800">
                Garis putus-putus menunjukkan target nasional <span class="font-bold">14%</span>
            </p>
        </div>
    </div>
</div>