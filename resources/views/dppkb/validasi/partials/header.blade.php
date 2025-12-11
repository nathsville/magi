<div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-xl shadow-lg overflow-hidden">
    <div class="px-6 py-8">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">Validasi Final</h1>
                        <p class="text-purple-100 text-sm mt-1">Persetujuan akhir data stunting dari Puskesmas</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-6 text-sm text-purple-100 mt-4">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span id="headerTime">{{ now()->format('H:i') }} WITA</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ now()->isoFormat('dddd, D MMMM YYYY') }}</span>
                    </div>
                </div>
            </div>

            <div class="hidden lg:block">
                <div class="flex items-center space-x-4">
                    <button onclick="refreshData()" 
                        class="px-4 py-2.5 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-lg transition flex items-center space-x-2 backdrop-blur-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span class="text-sm font-medium">Refresh</span>
                    </button>
                    <a href="{{ route('dppkb.dashboard') }}" 
                        class="px-4 py-2.5 bg-white text-purple-700 hover:bg-purple-50 rounded-lg transition flex items-center space-x-2 font-medium shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="text-sm">Dashboard</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>