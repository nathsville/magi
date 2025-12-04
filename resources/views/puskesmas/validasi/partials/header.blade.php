<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    {{-- Title & Identity --}}
    <div class="flex items-center space-x-4">
        <div class="w-12 h-12 bg-[#000878] rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Validasi Data Stunting</h1>
            <p class="text-sm text-gray-600 mt-1">Verifikasi keakuratan data pengukuran dari Posyandu</p>
        </div>
    </div>
    
    {{-- Action Buttons --}}
    <div class="flex items-center space-x-3">
        {{-- Info Button --}}
        <button onclick="showInfoModal()" 
            class="flex items-center px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm">
            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium text-sm">Panduan</span>
        </button>

        {{-- Refresh Button --}}
        <button onclick="location.reload()" 
            class="flex items-center px-5 py-2.5 text-white bg-[#000878] rounded-lg hover:bg-blue-900 transition shadow-md hover:shadow-lg">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            <span class="font-medium text-sm">Refresh Data</span>
        </button>
    </div>
</div>