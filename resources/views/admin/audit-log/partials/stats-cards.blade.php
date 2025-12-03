<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- Total Logs --}}
    <div class="bg-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-blue-100 text-sm font-medium mb-1">Total Aktivitas</p>
                <h3 class="text-3xl font-bold">{{ number_format($totalLogs) }}</h3>
                <p class="text-blue-100 text-xs mt-2">Semua waktu</p>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Today's Logs --}}
    <div class="bg-green-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-green-100 text-sm font-medium mb-1">Aktivitas Hari Ini</p>
                <h3 class="text-3xl font-bold">{{ number_format($todayLogs) }}</h3>
                <p class="text-green-100 text-xs mt-2">{{ now()->format('d M Y') }}</p>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Week's Logs --}}
    <div class="bg-purple-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-purple-100 text-sm font-medium mb-1">7 Hari Terakhir</p>
                <h3 class="text-3xl font-bold">{{ number_format($weekLogs) }}</h3>
                <p class="text-purple-100 text-xs mt-2">{{ now()->subDays(7)->format('d M') }} - {{ now()->format('d M') }}</p>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>