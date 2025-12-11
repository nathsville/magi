{{-- Berat Badan Chart --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">Grafik Berat Badan</h3>
                <p class="text-xs text-gray-500">Satuan: Kilogram (kg)</p>
            </div>
        </div>
    </div>
    <div class="chart-container">
        <canvas id="beratBadanChart"></canvas>
    </div>
</div>

{{-- Tinggi Badan Chart --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-green-50 rounded-lg text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">Grafik Tinggi Badan</h3>
                <p class="text-xs text-gray-500">Satuan: Sentimeter (cm)</p>
            </div>
        </div>
    </div>
    <div class="chart-container">
        <canvas id="tinggiBadanChart"></canvas>
    </div>
</div>

{{-- Lingkar Kepala & Lengan Chart --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-purple-50 rounded-lg text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">Lingkar Kepala & Lengan</h3>
                <p class="text-xs text-gray-500">Satuan: Sentimeter (cm)</p>
            </div>
        </div>
    </div>
    <div class="chart-container">
        <canvas id="lingkarChart"></canvas>
    </div>
</div>