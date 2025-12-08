{{-- Berat Badan Chart --}}
<div class="bg-white rounded-2xl shadow-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold text-gray-800">
            <i class="fas fa-weight text-blue-600 mr-2"></i>Grafik Berat Badan
        </h3>
        <span class="text-sm text-gray-500">Dalam Kilogram (kg)</span>
    </div>
    <div class="chart-container">
        <canvas id="beratBadanChart"></canvas>
    </div>
    <div class="mt-4 flex items-center justify-center space-x-6 text-xs">
        <div class="flex items-center">
            <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
            <span class="text-gray-600">Batas Bawah WHO</span>
        </div>
        <div class="flex items-center">
            <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
            <span class="text-gray-600">Data Anak</span>
        </div>
        <div class="flex items-center">
            <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
            <span class="text-gray-600">Median WHO</span>
        </div>
    </div>
</div>

{{-- Tinggi Badan Chart --}}
<div class="bg-white rounded-2xl shadow-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold text-gray-800">
            <i class="fas fa-ruler-vertical text-purple-600 mr-2"></i>Grafik Tinggi Badan
        </h3>
        <span class="text-sm text-gray-500">Dalam Sentimeter (cm)</span>
    </div>
    <div class="chart-container">
        <canvas id="tinggiBadanChart"></canvas>
    </div>
    <div class="mt-4 flex items-center justify-center space-x-6 text-xs">
        <div class="flex items-center">
            <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
            <span class="text-gray-600">Batas Bawah WHO</span>
        </div>
        <div class="flex items-center">
            <span class="w-3 h-3 bg-purple-500 rounded-full mr-2"></span>
            <span class="text-gray-600">Data Anak</span>
        </div>
        <div class="flex items-center">
            <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
            <span class="text-gray-600">Median WHO</span>
        </div>
    </div>
</div>

{{-- Lingkar Kepala & Lengan Chart --}}
<div class="bg-white rounded-2xl shadow-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold text-gray-800">
            <i class="fas fa-chart-area text-orange-600 mr-2"></i>Lingkar Kepala & Lengan
        </h3>
        <span class="text-sm text-gray-500">Dalam Sentimeter (cm)</span>
    </div>
    <div class="chart-container">
        <canvas id="lingkarChart"></canvas>
    </div>
    <div class="mt-4 flex items-center justify-center space-x-6 text-xs">
        <div class="flex items-center">
            <span class="w-3 h-3 bg-orange-500 rounded-full mr-2"></span>
            <span class="text-gray-600">Lingkar Kepala</span>
        </div>
        <div class="flex items-center">
            <span class="w-3 h-3 bg-teal-500 rounded-full mr-2"></span>
            <span class="text-gray-600">Lingkar Lengan</span>
        </div>
    </div>
</div>