<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
    {{-- Total Anak --}}
    <div class="bg-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-[1.02] transition-transform duration-300">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-blue-100 text-sm font-medium mb-1">Total Anak</p>
                <h3 class="text-3xl font-bold">{{ $totalAnak }}</h3>
                <p class="text-blue-100 text-xs mt-2">Terdaftar</p>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Status Normal --}}
    <div class="bg-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-[1.02] transition-transform duration-300">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-green-100 text-sm font-medium mb-1">Status Normal</p>
                <h3 class="text-3xl font-bold">{{ $anakNormal }}</h3>
                <p class="text-green-100 text-xs mt-2">
                    {{ $totalAnak > 0 ? number_format(($anakNormal / $totalAnak) * 100, 1) : 0 }}% dari total
                </p>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Status Stunting (Warning) --}}
    <div class="bg-orange-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-[1.02] transition-transform duration-300">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-orange-100 text-sm font-medium mb-1">Perlu Perhatian</p>
                <h3 class="text-3xl font-bold">{{ $anakStunting }}</h3>
                <p class="text-orange-100 text-xs mt-2">
                    {{ $totalAnak > 0 ? number_format(($anakStunting / $totalAnak) * 100, 1) : 0 }}% dari total
                </p>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Notifikasi --}}
    <div class="bg-[#000878] rounded-xl shadow-lg p-6 text-white transform hover:scale-[1.02] transition-transform duration-300">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-blue-100 text-sm font-medium mb-1">Notifikasi Baru</p>
                <h3 class="text-3xl font-bold">{{ $unreadNotifications }}</h3>
                <p class="text-blue-100 text-xs mt-2">Belum dibaca</p>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
            </div>
        </div>
    </div>
</div>