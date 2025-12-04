<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    {{-- Title & Identity --}}
    <div class="flex items-center space-x-4">
        <div class="w-12 h-12 bg-[#000878] rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard Puskesmas</h1>
            <div class="flex items-center text-sm text-gray-600 mt-1">
                <span class="font-semibold text-[#000878] bg-blue-50 px-2 py-0.5 rounded border border-blue-100">
                    {{ $puskesmas->nama_puskesmas ?? 'Nama Puskesmas' }}
                </span>
                <span class="mx-2 text-gray-300">•</span>
                <span>Kec. {{ $puskesmas->kecamatan ?? 'Kecamatan' }}</span>
            </div>
        </div>
    </div>
    
    {{-- Action Buttons --}}
    <div class="flex items-center space-x-3">
        {{-- Refresh Button --}}
        <button onclick="location.reload()" 
            class="group flex items-center px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition shadow-sm">
            <svg class="w-4 h-4 mr-2 text-gray-500 group-hover:text-gray-700 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            <span class="font-medium text-sm">Refresh</span>
        </button>

        {{-- Filter Button --}}
        <a href="{{ route('puskesmas.monitoring.filter') }}" 
            class="flex items-center px-5 py-2.5 text-white bg-[#000878] rounded-lg hover:bg-blue-900 transition shadow-md hover:shadow-lg">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <span class="font-medium text-sm">Filter Data</span>
        </a>
    </div>
</div>