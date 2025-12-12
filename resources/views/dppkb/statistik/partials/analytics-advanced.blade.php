<div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-xl shadow-lg p-6 text-white">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-bold">Analisis Lanjutan</h3>
            <p class="text-indigo-100 text-sm mt-1">Insights & Prediksi Berbasis AI</p>
        </div>
        <div class="px-3 py-1 bg-white bg-opacity-20 rounded-full text-xs font-semibold backdrop-blur-sm">
            BETA
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Korelasi Faktor --}}
        <div class="bg-white bg-opacity-10 rounded-lg p-5 backdrop-blur-sm">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h4 class="font-bold">Korelasi Faktor</h4>
            </div>
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-indigo-100">Ekonomi</span>
                    <span class="text-sm font-bold" id="korelasiEkonomi">-</span>
                </div>
                <div class="w-full bg-white bg-opacity-20 rounded-full h-2">
                    <div class="bg-yellow-400 h-2 rounded-full" style="width: 0%;" id="barEkonomi"></div>
                </div>
                
                <div class="flex items-center justify-between mt-3">
                    <span class="text-sm text-indigo-100">Pendidikan</span>
                    <span class="text-sm font-bold" id="korelasiPendidikan">-</span>
                </div>
                <div class="w-full bg-white bg-opacity-20 rounded-full h-2">
                    <div class="bg-green-400 h-2 rounded-full" style="width: 0%;" id="barPendidikan"></div>
                </div>
            </div>
        </div>
        
        {{-- Prediksi 6 Bulan --}}
        <div class="bg-white bg-opacity-10 rounded-lg p-5 backdrop-blur-sm">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <h4 class="font-bold">Prediksi 6 Bulan</h4>
            </div>
            <div class="text-center">
                <p class="text-5xl font-bold mb-2" id="prediksiPrevalensi">-</p>
                <p class="text-indigo-100 text-sm">Prevalensi Prediksi</p>
                <div class="mt-4 flex items-center justify-center space-x-2">
                    <div class="flex items-center space-x-1" id="prediksiTrend">
                        {{-- Will be populated by JS --}}
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white border-opacity-20">
                <p class="text-xs text-indigo-100">
                    Confidence Level: <span class="font-bold" id="confidenceLevel">-</span>
                </p>
            </div>
        </div>
        
        {{-- Rekomendasi AI --}}
        <div class="bg-white bg-opacity-10 rounded-lg p-5 backdrop-blur-sm">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <h4 class="font-bold">Rekomendasi</h4>
            </div>
            <div id="rekomendasiList" class="space-y-2">
                {{-- Will be populated by JS --}}
                <div class="flex items-start space-x-2">
                    <div class="w-1.5 h-1.5 rounded-full bg-yellow-400 mt-2 flex-shrink-0"></div>
                    <p class="text-sm text-indigo-100">Memuat rekomendasi...</p>
                </div>
            </div>
        </div>
    </div>
</div>