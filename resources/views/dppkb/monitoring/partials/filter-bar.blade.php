<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            Filter Data
        </h3>
        <button onclick="resetMonitoringFilter()" 
            class="text-sm text-gray-600 hover:text-gray-900 flex items-center space-x-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            <span>Reset</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        {{-- Periode --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Periode Waktu
            </label>
            <select id="filterPeriode" 
                onchange="applyMonitoringFilter()"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="hari_ini">Hari Ini</option>
                <option value="minggu_ini">Minggu Ini</option>
                <option value="bulan_ini" selected>Bulan Ini</option>
                <option value="tahun_ini">Tahun Ini</option>
                <option value="semua">Semua Waktu</option>
            </select>
        </div>

        {{-- Kecamatan --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Kecamatan
            </label>
            <select id="filterKecamatan" 
                onchange="applyMonitoringFilter()"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Semua Kecamatan</option>
                <option value="Bacukiki">Bacukiki</option>
                <option value="Bacukiki Barat">Bacukiki Barat</option>
                <option value="Ujung">Ujung</option>
                <option value="Soreang">Soreang</option>
            </select>
        </div>

        {{-- Status Gizi --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Status Gizi
            </label>
            <select id="filterStatus" 
                onchange="applyMonitoringFilter()"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Semua Status</option>
                <option value="Normal">Normal</option>
                <option value="Stunting Ringan">Stunting Ringan</option>
                <option value="Stunting Sedang">Stunting Sedang</option>
                <option value="Stunting Berat">Stunting Berat</option>
            </select>
        </div>

        {{-- Tampilan --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Tampilan
            </label>
            <select id="filterTampilan" 
                onchange="changeViewMode()"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="map">Peta Interaktif</option>
                <option value="list">Daftar Detail</option>
                <option value="chart">Grafik & Statistik</option>
            </select>
        </div>
    </div>

    {{-- Active Filters Display --}}
    <div id="activeFiltersDisplay" class="mt-4 pt-4 border-t border-gray-200 hidden">
        <div class="flex items-center flex-wrap gap-2">
            <span class="text-sm text-gray-600 font-medium">Filter Aktif:</span>
            <div id="activeFilterTags" class="flex items-center flex-wrap gap-2">
                {{-- Tags will be inserted here --}}
            </div>
        </div>
    </div>
</div>