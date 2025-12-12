<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Time Range --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Periode Waktu</label>
            <select id="filterTimeRange" 
                onchange="applyStatistikFilter()"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="6_bulan">6 Bulan Terakhir</option>
                <option value="1_tahun" selected>1 Tahun Terakhir</option>
                <option value="2_tahun">2 Tahun Terakhir</option>
                <option value="semua">Semua Data</option>
                <option value="custom">Custom Range</option>
            </select>
        </div>
        
        {{-- Custom Date Range (Hidden by default) --}}
        <div id="customRangeInputs" class="hidden lg:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Custom</label>
            <div class="grid grid-cols-2 gap-2">
                <input type="date" 
                    id="filterStartDate"
                    class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <input type="date" 
                    id="filterEndDate"
                    class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
        </div>
        
        {{-- Wilayah Filter --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Wilayah</label>
            <select id="filterWilayah" 
                onchange="applyStatistikFilter()"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="all">Seluruh Kota Parepare</option>
                <option value="bacukiki">Kec. Bacukiki</option>
                <option value="bacukiki_barat">Kec. Bacukiki Barat</option>
                <option value="ujung">Kec. Ujung</option>
                <option value="soreang">Kec. Soreang</option>
            </select>
        </div>
        
        {{-- Metric Type --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Metrik</label>
            <select id="filterMetric" 
                onchange="applyStatistikFilter()"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="prevalensi">Prevalensi (%)</option>
                <option value="jumlah">Jumlah Kasus</option>
                <option value="pertumbuhan">Tingkat Pertumbuhan</option>
            </select>
        </div>
        
        {{-- Actions --}}
        <div class="flex items-end space-x-2">
            <button onclick="resetStatistikFilter()" 
                class="flex-1 px-4 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                Reset
            </button>
            <button onclick="applyStatistikFilter()" 
                class="flex-1 px-4 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition font-medium shadow-lg">
                Terapkan
            </button>
        </div>
    </div>
    
    {{-- Active Filters Display --}}
    <div id="activeFiltersDisplay" class="hidden mt-4 pt-4 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex flex-wrap gap-2" id="activeFiltersTags">
                {{-- Tags will be inserted here --}}
            </div>
            <button onclick="resetStatistikFilter()" 
                class="text-sm text-red-600 hover:text-red-700 font-medium">
                Hapus Semua
            </button>
        </div>
    </div>
</div>