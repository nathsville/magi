<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    {{-- Total Anak --}}
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium mb-2">Total Anak</p>
                <p class="text-3xl font-bold">{{ $totalAnak }}</p>
                <p class="text-blue-100 text-xs mt-2">Terdaftar di Puskesmas</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Laki-laki --}}
    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-indigo-100 text-sm font-medium mb-2">Laki-laki</p>
                <p class="text-3xl font-bold">{{ $totalLakiLaki }}</p>
                <p class="text-indigo-100 text-xs mt-2">
                    {{ $totalAnak > 0 ? round(($totalLakiLaki / $totalAnak) * 100, 1) : 0 }}% dari total
                </p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Perempuan --}}
    <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-pink-100 text-sm font-medium mb-2">Perempuan</p>
                <p class="text-3xl font-bold">{{ $totalPerempuan }}</p>
                <p class="text-pink-100 text-xs mt-2">
                    {{ $totalAnak > 0 ? round(($totalPerempuan / $totalAnak) * 100, 1) : 0 }}% dari total
                </p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Rata-rata Umur --}}
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium mb-2">Rata-rata Umur</p>
                <p class="text-3xl font-bold">{{ $rataUmur }}</p>
                <p class="text-green-100 text-xs mt-2">Bulan</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>