<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    {{-- Total Pengukuran --}}
    <div class="bg-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-[1.02] transition-transform duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium mb-1">Total Pengukuran</p>
                <h3 class="text-3xl font-bold">{{ $stats['total'] }}</h3>
                <p class="text-blue-100 text-xs mt-2">Data tercatat</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002 2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Bulan Ini --}}
    <div class="bg-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-[1.02] transition-transform duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium mb-1">Bulan Ini</p>
                <h3 class="text-3xl font-bold">{{ $stats['bulan_ini'] }}</h3>
                <p class="text-green-100 text-xs mt-2">{{ now()->format('F Y') }}</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Hari Ini --}}
    <div class="bg-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-[1.02] transition-transform duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium mb-1">Hari Ini</p>
                <h3 class="text-3xl font-bold">{{ $stats['hari_ini'] }}</h3>
                <p class="text-purple-100 text-xs mt-2">{{ now()->format('d F Y') }}</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>