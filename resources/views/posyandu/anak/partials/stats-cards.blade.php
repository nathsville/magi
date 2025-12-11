<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- Total Anak --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Total Anak Terdaftar</p>
            <h3 class="text-3xl font-bold text-gray-900">{{ $totalAnak }}</h3>
            <p class="text-xs text-blue-600 mt-1 font-medium">Aktif di Posyandu</p>
        </div>
        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </div>
    </div>

    {{-- Status Normal --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Status Normal</p>
            <h3 class="text-3xl font-bold text-green-600">{{ $anakNormal }}</h3>
            @if($totalAnak > 0)
                <p class="text-xs text-green-600 mt-1 font-medium">{{ round(($anakNormal / $totalAnak) * 100, 1) }}% dari total</p>
            @endif
        </div>
        <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-green-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>

    {{-- Perlu Perhatian --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Perlu Perhatian</p>
            <h3 class="text-3xl font-bold text-orange-600">{{ $anakStunting }}</h3>
            @if($totalAnak > 0)
                <p class="text-xs text-orange-600 mt-1 font-medium">{{ round(($anakStunting / $totalAnak) * 100, 1) }}% dari total</p>
            @endif
        </div>
        <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
    </div>
</div>