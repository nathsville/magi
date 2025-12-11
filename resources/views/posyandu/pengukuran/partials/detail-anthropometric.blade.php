<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <span>Data Antropometri</span>
        </h2>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            {{-- Berat Badan --}}
            <div class="text-center p-4 rounded-xl border border-blue-100 bg-blue-50/50">
                <p class="text-xs text-gray-500 font-medium uppercase mb-1">Berat Badan</p>
                <div class="flex items-baseline justify-center">
                    <span class="text-2xl font-bold text-gray-900">{{ number_format($pengukuran->berat_badan, 1) }}</span>
                    <span class="text-xs text-gray-500 ml-1">kg</span>
                </div>
            </div>
            
            {{-- Tinggi Badan --}}
            <div class="text-center p-4 rounded-xl border border-green-100 bg-green-50/50">
                <p class="text-xs text-gray-500 font-medium uppercase mb-1">Tinggi Badan</p>
                <div class="flex items-baseline justify-center">
                    <span class="text-2xl font-bold text-gray-900">{{ number_format($pengukuran->tinggi_badan, 1) }}</span>
                    <span class="text-xs text-gray-500 ml-1">cm</span>
                </div>
            </div>
            
            {{-- Lingkar Kepala --}}
            <div class="text-center p-4 rounded-xl border border-yellow-100 bg-yellow-50/50">
                <p class="text-xs text-gray-500 font-medium uppercase mb-1">Lingkar Kepala</p>
                <div class="flex items-baseline justify-center">
                    <span class="text-2xl font-bold text-gray-900">{{ number_format($pengukuran->lingkar_kepala, 1) }}</span>
                    <span class="text-xs text-gray-500 ml-1">cm</span>
                </div>
            </div>
            
            {{-- Lingkar Lengan --}}
            <div class="text-center p-4 rounded-xl border border-red-100 bg-red-50/50">
                <p class="text-xs text-gray-500 font-medium uppercase mb-1">Lingkar Lengan</p>
                <div class="flex items-baseline justify-center">
                    <span class="text-2xl font-bold text-gray-900">{{ number_format($pengukuran->lingkar_lengan, 1) }}</span>
                    <span class="text-xs text-gray-500 ml-1">cm</span>
                </div>
            </div>
        </div>
    </div>
</div>