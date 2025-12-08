<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- Total Intervensi --}}
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium mb-2">Total Intervensi</p>
                <p class="text-3xl font-bold">{{ $totalIntervensi }}</p>
                <p class="text-purple-100 text-xs mt-2">Program yang berjalan</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Sedang Berjalan --}}
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium mb-2">Sedang Berjalan</p>
                <p class="text-3xl font-bold">{{ $sedangBerjalan }}</p>
                <p class="text-orange-100 text-xs mt-2">
                    {{ $totalIntervensi > 0 ? round(($sedangBerjalan / $totalIntervensi) * 100, 1) : 0 }}% dari total
                </p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Selesai --}}
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium mb-2">Selesai</p>
                <p class="text-3xl font-bold">{{ $selesai }}</p>
                <p class="text-green-100 text-xs mt-2">
                    {{ $totalIntervensi > 0 ? round(($selesai / $totalIntervensi) * 100, 1) : 0 }}% dari total
                </p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>