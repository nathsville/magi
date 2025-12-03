<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    {{-- Total Anak --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition cursor-pointer" onclick="showDetailModal('anak')">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full font-medium">+12.5%</span>
        </div>
        <p class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($totalAnak) }}</p>
        <p class="text-sm text-gray-500">Total Anak Terdaftar</p>
        <div class="mt-3 flex items-center text-xs text-gray-500">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
            <span>vs bulan lalu</span>
        </div>
    </div>

    {{-- Total Stunting --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition cursor-pointer" onclick="showDetailModal('stunting')">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <span class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded-full font-medium">-3.2%</span>
        </div>
        <p class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($totalStunting) }}</p>
        <p class="text-sm text-gray-500">Kasus Stunting</p>
        <div class="mt-3 flex items-center text-xs text-green-600">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
            </svg>
            <span>Menurun dari bulan lalu</span>
        </div>
    </div>

    {{-- Persentase Stunting --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition cursor-pointer" onclick="showDetailModal('persentase')">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <span class="text-xs px-2 py-1 {{ $persentaseStunting > 20 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }} rounded-full font-medium">
                {{ $persentaseStunting > 20 ? 'Tinggi' : 'Normal' }}
            </span>
        </div>
        <p class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($persentaseStunting, 1) }}%</p>
        <p class="text-sm text-gray-500">Persentase Stunting</p>
        <div class="mt-3 flex items-center text-xs text-gray-500">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Target nasional: &lt; 14%</span>
        </div>
    </div>

    {{-- Total Posyandu --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition cursor-pointer" onclick="window.location='{{ route('admin.posyandu') }}'">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <span class="text-xs text-gray-500">{{ \App\Models\Puskesmas::count() }} PKM</span>
        </div>
        <p class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($totalPosyandu) }}</p>
        <p class="text-sm text-gray-500">Total Posyandu Aktif</p>
        <div class="mt-3 flex items-center text-xs text-gray-500">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>100% Operasional</span>
        </div>
    </div>
</div>