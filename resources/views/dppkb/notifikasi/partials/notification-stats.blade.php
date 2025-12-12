<div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- Total Notifikasi --}}
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
            </div>
        </div>
        <p class="text-blue-100 text-sm mb-1">Total Notifikasi</p>
        <p class="text-3xl font-bold" id="statTotalNotifikasi">-</p>
        <p class="text-blue-100 text-xs mt-2">Bulan ini</p>
    </div>
    
    {{-- Belum Dibaca --}}
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div class="px-2 py-1 bg-white bg-opacity-20 rounded-full text-xs font-semibold">
                New
            </div>
        </div>
        <p class="text-orange-100 text-sm mb-1">Belum Dibaca</p>
        <p class="text-3xl font-bold" id="statBelumDibaca">-</p>
        <p class="text-orange-100 text-xs mt-2">Perlu perhatian</p>
    </div>
    
    {{-- Terkirim Hari Ini --}}
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
            </div>
        </div>
        <p class="text-green-100 text-sm mb-1">Terkirim Hari Ini</p>
        <p class="text-3xl font-bold" id="statTerkirimHariIni">-</p>
        <p class="text-green-100 text-xs mt-2">24 jam terakhir</p>
    </div>
</div>