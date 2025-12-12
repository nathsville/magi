<div class="bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-800 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            {{-- Title Section --}}
            <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-white">Statistik & Analisis</h1>
                    <p class="text-purple-100 text-sm mt-1">Dashboard analisis data stunting mendalam</p>
                </div>
            </div>
            
            {{-- Action Buttons --}}
            <div class="flex items-center space-x-3">
                {{-- Refresh --}}
                <button onclick="refreshAllData()" 
                    class="px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-lg transition flex items-center space-x-2 backdrop-blur-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span class="hidden sm:inline">Refresh</span>
                </button>
                
                {{-- Export --}}
                <button onclick="openModalExport()" 
                    class="px-4 py-2 bg-white text-purple-700 hover:bg-purple-50 rounded-lg transition flex items-center space-x-2 font-medium shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Export Data</span>
                </button>
                
                {{-- Back --}}
                <a href="{{ route('dppkb.dashboard') }}" 
                    class="px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-lg transition flex items-center space-x-2 backdrop-blur-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="hidden sm:inline">Dashboard</span>
                </a>
            </div>
        </div>
        
        {{-- Live Indicator --}}
        <div class="mt-4 flex items-center space-x-2 text-purple-100 text-sm">
            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
            <span>Data Real-Time</span>
            <span class="mx-2">•</span>
            <span id="lastUpdate">Terakhir update: -</span>
        </div>
    </div>
</div>