<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="font-bold text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-[#000878]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Statistik Bulan Ini
        </h3>
        <span class="px-3 py-1 bg-blue-50 text-[#000878] text-xs font-semibold rounded-full border border-blue-100">
            {{ \Carbon\Carbon::create()->month($stats['bulan'])->format('F') }} {{ $stats['tahun'] }}
        </span>
    </div>

    <div class="p-6">
        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            {{-- Total Anak --}}
            <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 font-medium">Total Anak</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_anak'] }}</p>
            </div>

            {{-- Pengukuran --}}
            <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002 2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 font-medium">Pengukuran</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_pengukuran'] }}</p>
            </div>

            {{-- Normal --}}
            <div class="p-4 rounded-xl border border-green-200 bg-green-50/50">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 bg-green-100 text-green-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-green-700">{{ $stats['persentase_normal'] }}%</span>
                </div>
                <p class="text-xs text-green-700 font-medium">Gizi Normal</p>
                <p class="text-2xl font-bold text-green-800">{{ $stats['normal'] }}</p>
            </div>

            {{-- Stunting --}}
            <div class="p-4 rounded-xl border border-red-200 bg-red-50/50">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 bg-red-100 text-red-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-red-700">{{ $stats['persentase_stunting'] }}%</span>
                </div>
                <p class="text-xs text-red-700 font-medium">Stunting</p>
                <p class="text-2xl font-bold text-red-800">{{ $stats['total_stunting'] }}</p>
            </div>
        </div>

        {{-- Breakdown Chart --}}
        <div>
            <h4 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wide">Detail Status Gizi</h4>
            
            <div class="space-y-4">
                {{-- Normal --}}
                <div>
                    <div class="flex items-center justify-between mb-1 text-xs">
                        <span class="text-gray-600">Normal</span>
                        <span class="font-semibold text-gray-900">{{ $stats['normal'] }} ({{ $stats['persentase_normal'] }}%)</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $stats['persentase_normal'] }}%"></div>
                    </div>
                </div>

                {{-- Stunting Ringan --}}
                <div>
                    <div class="flex items-center justify-between mb-1 text-xs">
                        <span class="text-gray-600">Stunting Ringan</span>
                        <span class="font-semibold text-gray-900">{{ $stats['stunting_ringan'] }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        @php $persen = $stats['total_pengukuran'] > 0 ? ($stats['stunting_ringan'] / $stats['total_pengukuran']) * 100 : 0; @endphp
                        <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $persen }}%"></div>
                    </div>
                </div>

                {{-- Stunting Sedang --}}
                <div>
                    <div class="flex items-center justify-between mb-1 text-xs">
                        <span class="text-gray-600">Stunting Sedang</span>
                        <span class="font-semibold text-gray-900">{{ $stats['stunting_sedang'] }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        @php $persen = $stats['total_pengukuran'] > 0 ? ($stats['stunting_sedang'] / $stats['total_pengukuran']) * 100 : 0; @endphp
                        <div class="bg-orange-500 h-2 rounded-full" style="width: {{ $persen }}%"></div>
                    </div>
                </div>

                {{-- Stunting Berat --}}
                <div>
                    <div class="flex items-center justify-between mb-1 text-xs">
                        <span class="text-gray-600">Stunting Berat</span>
                        <span class="font-semibold text-gray-900">{{ $stats['stunting_berat'] }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        @php $persen = $stats['total_pengukuran'] > 0 ? ($stats['stunting_berat'] / $stats['total_pengukuran']) * 100 : 0; @endphp
                        <div class="bg-red-600 h-2 rounded-full" style="width: {{ $persen }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>