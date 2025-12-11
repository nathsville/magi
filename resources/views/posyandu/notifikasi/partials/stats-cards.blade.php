<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    {{-- Total Notifikasi --}}
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-bell text-3xl"></i>
            </div>
            <span class="text-4xl">🔔</span>
        </div>
        <h3 class="text-4xl font-bold mb-1">{{ $stats['total'] }}</h3>
        <p class="text-sm text-blue-100">Total Notifikasi</p>
    </div>

    {{-- Belum Dibaca --}}
    <div class="bg-gradient-to-br from-orange-500 to-red-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-envelope text-3xl"></i>
            </div>
            <span class="text-4xl">✉️</span>
        </div>
        <h3 class="text-4xl font-bold mb-1">{{ $stats['belum_dibaca'] }}</h3>
        <p class="text-sm text-orange-100">Belum Dibaca</p>
    </div>

    {{-- Hari Ini --}}
    <div class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-calendar-day text-3xl"></i>
            </div>
            <span class="text-4xl">📅</span>
        </div>
        <h3 class="text-4xl font-bold mb-1">{{ $stats['hari_ini'] }}</h3>
        <p class="text-sm text-teal-100">Hari Ini</p>
    </div>
</div>