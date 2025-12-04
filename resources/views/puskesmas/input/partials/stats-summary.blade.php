<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- 1. Total Input (Brand Blue) --}}
    <div class="bg-[#000878] rounded-xl shadow-sm p-6 text-white flex items-center justify-between hover:bg-blue-900 transition group">
        <div>
            <p class="text-white/80 text-sm font-medium uppercase tracking-wide">Input Hari Ini</p>
            <h3 class="text-4xl font-bold mt-1">{{ session('inputs_today', 0) }}</h3>
            <div class="mt-2 text-xs flex items-center text-white/90">
                <span class="bg-white/20 px-2 py-0.5 rounded text-xs font-medium">
                    Data Masuk
                </span>
            </div>
        </div>
        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
    </div>

    <div class="bg-red-600 rounded-xl shadow-sm p-6 text-white flex items-center justify-between hover:bg-red-700 transition group">
        <div>
            <p class="text-white/80 text-sm font-medium uppercase tracking-wide">Terdeteksi Stunting</p>
            <h3 class="text-4xl font-bold mt-1">{{ session('stunting_detected_today', 0) }}</h3>
            <div class="mt-2 text-xs flex items-center text-white/90">
                @if(session('stunting_detected_today', 0) > 0)
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span class="font-medium">Perhatian Khusus</span>
                @else
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-medium">Aman</span>
                @endif
            </div>
        </div>
        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>

    <div class="bg-green-600 rounded-xl shadow-sm p-6 text-white flex items-center justify-between hover:bg-green-700 transition group">
        <div>
            <p class="text-white/80 text-sm font-medium uppercase tracking-wide">Status Sistem</p>
            <h3 class="text-xl font-bold mt-2">Auto Validated</h3>
            <div class="mt-3 text-xs flex items-center text-white/90">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">Data Langsung Aktif</span>
            </div>
        </div>
        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
        </div>
    </div>
</div>