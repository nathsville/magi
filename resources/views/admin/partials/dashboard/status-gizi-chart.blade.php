<div class="bg-white rounded-xl border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-gray-900">Distribusi Status Gizi</h3>
        <button onclick="showInfoModal('distribusi')" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </button>
    </div>

    {{-- Donut Chart --}}
    <div class="flex items-center justify-center mb-6">
        <div class="relative">
            <svg class="w-48 h-48 transform -rotate-90">
                <circle cx="96" cy="96" r="80" stroke="#f3f4f6" stroke-width="24" fill="none" />
                {{-- Normal (Green) --}}
                <circle cx="96" cy="96" r="80" stroke="#22c55e" stroke-width="24" fill="none" 
                        stroke-dasharray="502" stroke-dashoffset="{{ 502 - (502 * ((100 - $persentaseStunting) / 100)) }}" stroke-linecap="round" />
                {{-- Stunting (Red) --}}
                <circle cx="96" cy="96" r="80" stroke="#ef4444" stroke-width="24" fill="none" 
                        stroke-dasharray="502" stroke-dashoffset="{{ 502 * ((100 - $persentaseStunting) / 100) }}" stroke-linecap="round" />
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <p class="text-3xl font-bold text-gray-900">{{ $totalAnak }}</p>
                <p class="text-xs text-gray-500">Total Anak</p>
            </div>
        </div>
    </div>

    {{-- Legend --}}
    <div class="space-y-3">
        <div onclick="showDetailModal('normal')" class="flex items-center justify-between p-3 bg-green-50 rounded-lg hover:bg-green-100 transition cursor-pointer">
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                <span class="text-sm font-medium text-gray-700">Normal</span>
            </div>
            <div class="text-right">
                <p class="text-lg font-bold text-gray-900">{{ $totalAnak - $totalStunting }}</p>
                <p class="text-xs text-gray-500">{{ number_format(100 - $persentaseStunting, 1) }}%</p>
            </div>
        </div>

        <div onclick="showDetailModal('stunting')" class="flex items-center justify-between p-3 bg-red-50 rounded-lg hover:bg-red-100 transition cursor-pointer">
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                <span class="text-sm font-medium text-gray-700">Stunting</span>
            </div>
            <div class="text-right">
                <p class="text-lg font-bold text-gray-900">{{ $totalStunting }}</p>
                <p class="text-xs text-gray-500">{{ number_format($persentaseStunting, 1) }}%</p>
            </div>
        </div>
    </div>

    <button onclick="window.location='#detail-gizi'" class="mt-6 w-full text-sm text-primary hover:text-blue-700 font-medium flex items-center justify-center space-x-1 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
        <span>Lihat Detail Lengkap</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>
</div>