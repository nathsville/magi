<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    {{-- Rata-rata Prevalensi --}}
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div class="flex items-center space-x-1 text-sm">
                <span id="trendAvgPrevalensi" class="font-medium">-</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                </svg>
            </div>
        </div>
        <p class="text-blue-100 text-sm mb-1">Rata-rata Prevalensi</p>
        <p class="text-3xl font-bold" id="avgPrevalensi">-</p>
        <p class="text-blue-100 text-xs mt-2">Target: <span class="font-semibold">14%</span></p>
    </div>
    
    {{-- Wilayah Prioritas --}}
    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="px-2 py-1 bg-white bg-opacity-20 rounded-full text-xs font-semibold">
                Urgent
            </div>
        </div>
        <p class="text-red-100 text-sm mb-1">Wilayah Prioritas</p>
        <p class="text-3xl font-bold" id="wilayahPrioritas">-</p>
        <p class="text-red-100 text-xs mt-2">Prevalensi > 20%</p>
    </div>
    
    {{-- Tren Bulanan --}}
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <div class="flex items-center space-x-1" id="trendIndicator">
                <span class="text-sm font-medium">-</span>
            </div>
        </div>
        <p class="text-green-100 text-sm mb-1">Tren Bulanan</p>
        <p class="text-3xl font-bold" id="trenBulanan">-</p>
        <p class="text-green-100 text-xs mt-2">vs Bulan Lalu</p>
    </div>
    
    {{-- Posyandu Termonitor --}}
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div class="px-2 py-1 bg-white bg-opacity-20 rounded-full text-xs font-semibold" id="coverageBadge">
                -
            </div>
        </div>
        <p class="text-purple-100 text-sm mb-1">Posyandu Termonitor</p>
        <p class="text-3xl font-bold" id="posyanduMonitored">-</p>
        <p class="text-purple-100 text-xs mt-2">dari <span id="totalPosyandu">-</span> total</p>
    </div>
</div>