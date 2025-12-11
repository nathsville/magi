<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
        <h3 class="text-lg font-bold text-white flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
            </svg>
            Data per Kecamatan
        </h3>
    </div>

    {{-- List Container --}}
    <div class="divide-y divide-gray-200" id="kecamatanListContainer">
        {{-- Items will be inserted here --}}
        <div class="flex items-center justify-center py-12">
            <div class="text-center">
                <div class="inline-block animate-spin rounded-full h-10 w-10 border-4 border-blue-600 border-t-transparent mb-3"></div>
                <p class="text-gray-600 text-sm">Memuat data...</p>
            </div>
        </div>
    </div>
</div>