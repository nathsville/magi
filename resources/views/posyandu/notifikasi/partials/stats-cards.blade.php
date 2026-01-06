<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    {{-- Total Notifikasi --}}
    <div class="bg-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-[1.02] transition-transform duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium mb-1">Total Notifikasi</p>
                <h3 class="text-3xl font-bold">{{ $stats['total'] }}</h3>
                <p class="text-blue-100 text-xs mt-2">Semua waktu</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                <i class="fas fa-bell text-xl"></i>
            </div>
        </div>
    </div>

    {{-- Belum Dibaca --}}
    <div class="bg-orange-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-[1.02] transition-transform duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium mb-1">Belum Dibaca</p>
                <h3 class="text-3xl font-bold">{{ $stats['belum_dibaca'] }}</h3>
                <p class="text-orange-100 text-xs mt-2">Perlu perhatian</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                <i class="fas fa-envelope text-xl"></i>
            </div>
        </div>
    </div>

    {{-- Hari Ini --}}
    <div class="bg-[#000878] rounded-xl shadow-lg p-6 text-white transform hover:scale-[1.02] transition-transform duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium mb-1">Hari Ini</p>
                <h3 class="text-3xl font-bold">{{ $stats['hari_ini'] }}</h3>
                <p class="text-blue-100 text-xs mt-2">{{ now()->format('d F Y') }}</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                <i class="fas fa-calendar-day text-xl"></i>
            </div>
        </div>
    </div>
</div>