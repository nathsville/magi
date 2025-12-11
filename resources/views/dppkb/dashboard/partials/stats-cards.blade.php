<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    {{-- Total Anak Terdaftar --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition group">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Anak Terdaftar</p>
                    <p class="text-3xl font-bold text-gray-900">
                        {{ number_format($totalAnak) }}
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        <span class="text-green-600 font-semibold">↑ 12%</span> dari bulan lalu
                    </p>
                </div>
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-2">
            <a href="{{ route('dppkb.monitoring') }}" class="text-xs font-medium text-blue-700 hover:text-blue-800 flex items-center justify-between group">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>

    {{-- Total Kasus Stunting --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition group">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-1">Kasus Stunting</p>
                    <p class="text-3xl font-bold text-gray-900">
                        {{ number_format($totalStunting) }}
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        <span class="text-red-600 font-semibold">{{ $persentaseStunting }}%</span> dari total anak
                    </p>
                </div>
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-red-100 to-red-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-red-50 to-red-100 px-6 py-2">
            <a href="{{ route('dppkb.monitoring') }}" class="text-xs font-medium text-red-700 hover:text-red-800 flex items-center justify-between group">
                <span>Analisis Detail</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>

    {{-- Persentase Stunting --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition group">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-1">Prevalensi Stunting</p>
                    <p class="text-3xl font-bold text-gray-900">
                        {{ $persentaseStunting }}%
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        Target: <span class="font-semibold text-orange-600">14%</span> (2024)
                    </p>
                </div>
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-orange-100 to-orange-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-orange-50 to-orange-100 px-6 py-2">
            <a href="{{ route('dppkb.statistik') }}" class="text-xs font-medium text-orange-700 hover:text-orange-800 flex items-center justify-between group">
                <span>Lihat Tren</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>

    {{-- Pending Validasi --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition group">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-1">Pending Validasi</p>
                    <p class="text-3xl font-bold text-gray-900">
                        {{ number_format($pendingValidasi) }}
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        Perlu <span class="font-semibold text-purple-600">persetujuan final</span>
                    </p>
                </div>
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-purple-100 to-purple-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-2">
            <a href="{{ route('dppkb.validasi') }}" class="text-xs font-medium text-purple-700 hover:text-purple-800 flex items-center justify-between group">
                <span>Validasi Sekarang</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</div>