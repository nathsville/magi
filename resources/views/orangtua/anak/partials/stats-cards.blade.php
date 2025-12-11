<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- Total Anak --}}
    <div class="bg-blue-600 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium mb-1">Total Anak</p>
                <h3 class="text-3xl font-bold">{{ $totalAnak }}</h3>
            </div>
            <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Normal --}}
    <div class="bg-green-600 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium mb-1">Status Normal</p>
                <h3 class="text-3xl font-bold">{{ $anakNormal }}</h3>
                <p class="text-green-100 text-xs mt-1">
                    {{ $totalAnak > 0 ? round(($anakNormal / $totalAnak) * 100, 1) : 0 }}% dari total
                </p>
            </div>
            <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Stunting --}}
    <div class="bg-orange-500 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium mb-1">Perlu Perhatian</p>
                <h3 class="text-3xl font-bold">{{ $anakStunting }}</h3>
                <p class="text-orange-100 text-xs mt-1">
                    {{ $totalAnak > 0 ? round(($anakStunting / $totalAnak) * 100, 1) : 0 }}% dari total
                </p>
            </div>
            <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>