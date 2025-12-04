<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-amber-500 rounded-xl shadow-sm p-6 text-white flex items-center justify-between hover:bg-amber-600 transition group">
        <div>
            <p class="text-white/80 text-sm font-medium uppercase tracking-wide">Menunggu Validasi</p>
            <h3 class="text-4xl font-bold mt-1">{{ number_format($totalPending) }}</h3>
            <div class="mt-2 text-xs flex items-center text-white/90">
                @if($totalPending > 0)
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span class="font-medium">Perlu segera diproses</span>
                @else
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-medium">Semua Selesai</span>
                @endif
            </div>
        </div>
        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>

    <div class="bg-green-600 rounded-xl shadow-sm p-6 text-white flex items-center justify-between hover:bg-green-700 transition group">
        <div>
            <p class="text-white/80 text-sm font-medium uppercase tracking-wide">Divalidasi Hari Ini</p>
            <h3 class="text-4xl font-bold mt-1">{{ number_format($validatedToday) }}</h3>
            <div class="mt-2 text-xs flex items-center text-white/90">
                <span class="font-medium bg-white/20 px-2 py-0.5 rounded text-xs">
                    + Data Terverifikasi
                </span>
            </div>
        </div>
        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>

    <div class="bg-red-600 rounded-xl shadow-sm p-6 text-white flex items-center justify-between hover:bg-red-700 transition group">
        <div>
            <p class="text-white/80 text-sm font-medium uppercase tracking-wide">Ditolak Hari Ini</p>
            <h3 class="text-4xl font-bold mt-1">{{ number_format($rejectedToday) }}</h3>
            <div class="mt-2 text-xs flex items-center text-white/90">
                <span class="font-medium bg-white/20 px-2 py-0.5 rounded text-xs">
                    Perlu Input Ulang
                </span>
            </div>
        </div>
        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>
</div>