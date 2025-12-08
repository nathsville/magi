<div class="flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Kelola Laporan</h1>
        <p class="text-gray-600 mt-1">Generate dan kelola laporan stunting secara berkala</p>
    </div>
    
    <div class="flex items-center space-x-3">
        {{-- Refresh Button --}}
        <button onclick="location.reload()" 
            class="flex items-center px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Refresh
        </button>

        {{-- Generate Laporan Button --}}
        <a href="{{ route('puskesmas.laporan.create') }}" 
            class="flex items-center px-6 py-2.5 text-white bg-primary rounded-lg hover:bg-blue-700 transition shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 4v16m8-8H4"></path>
            </svg>
            Generate Laporan Baru
        </a>
    </div>
</div>