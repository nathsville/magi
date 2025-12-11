<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    {{-- Generate New --}}
    <button onclick="focusGenerateForm()" 
        class="bg-gradient-to-br from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-lg font-bold mb-1">Generate Laporan</h3>
        <p class="text-sm text-teal-100">Buat laporan baru</p>
    </button>

    {{-- Laporan Bulan Ini --}}
    <button onclick="generateCurrentMonth()" 
        class="bg-white border-2 border-blue-200 hover:border-blue-400 rounded-xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-1">Bulan Ini</h3>
        <p class="text-sm text-gray-600">{{ now()->isoFormat('MMMM YYYY') }}</p>
    </button>

    {{-- Laporan Tahunan --}}
    <button onclick="generateYearly()" 
        class="bg-white border-2 border-purple-200 hover:border-purple-400 rounded-xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-1">Laporan Tahunan</h3>
        <p class="text-sm text-gray-600">Tahun {{ now()->year }}</p>
    </button>

    {{-- History --}}
    <button onclick="scrollToHistory()" 
        class="bg-white border-2 border-orange-200 hover:border-orange-400 rounded-xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-1">Riwayat</h3>
        <p class="text-sm text-gray-600" id="historyCount">0 laporan</p>
    </button>
</div>