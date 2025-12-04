<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span>Hasil Analisis Z-Score</span>
        </h2>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            {{-- Z-Score TB/U --}}
            <div class="p-4 rounded-xl border text-center
                {{ $dataStunting->zscore_tb_u < -2 ? 'bg-red-50 border-red-100' : 'bg-green-50 border-green-100' }}">
                <p class="text-xs text-gray-600 font-medium">TB / U</p>
                <p class="text-2xl font-bold mt-1 {{ $dataStunting->zscore_tb_u < -2 ? 'text-red-700' : 'text-green-700' }}">
                    {{ number_format($dataStunting->zscore_tb_u, 2) }}
                </p>
                <p class="text-[10px] text-gray-500 mt-1">Z-Score</p>
            </div>
            
            {{-- Z-Score BB/U --}}
            <div class="p-4 rounded-xl border text-center
                {{ $dataStunting->zscore_bb_u < -2 ? 'bg-red-50 border-red-100' : 'bg-green-50 border-green-100' }}">
                <p class="text-xs text-gray-600 font-medium">BB / U</p>
                <p class="text-2xl font-bold mt-1 {{ $dataStunting->zscore_bb_u < -2 ? 'text-red-700' : 'text-green-700' }}">
                    {{ number_format($dataStunting->zscore_bb_u, 2) }}
                </p>
                <p class="text-[10px] text-gray-500 mt-1">Z-Score</p>
            </div>
            
            {{-- Z-Score BB/TB --}}
            <div class="p-4 rounded-xl border text-center
                {{ $dataStunting->zscore_bb_tb < -2 ? 'bg-red-50 border-red-100' : 'bg-green-50 border-green-100' }}">
                <p class="text-xs text-gray-600 font-medium">BB / TB</p>
                <p class="text-2xl font-bold mt-1 {{ $dataStunting->zscore_bb_tb < -2 ? 'text-red-700' : 'text-green-700' }}">
                    {{ number_format($dataStunting->zscore_bb_tb, 2) }}
                </p>
                <p class="text-[10px] text-gray-500 mt-1">Z-Score</p>
            </div>
        </div>
        
        {{-- Status Final --}}
        @php
            $statusClass = match($dataStunting->status_stunting) {
                'Normal' => 'bg-green-50 border-green-200 text-green-800',
                'Stunting Ringan' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
                'Stunting Sedang' => 'bg-orange-50 border-orange-200 text-orange-800',
                'Stunting Berat' => 'bg-red-50 border-red-200 text-red-800',
                default => 'bg-gray-50 border-gray-200 text-gray-800'
            };
        @endphp

        <div class="p-5 rounded-xl border-2 {{ $statusClass }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-80">Kesimpulan Status Gizi:</p>
                    <p class="text-2xl font-extrabold mt-1 uppercase tracking-wide">
                        {{ $dataStunting->status_stunting }}
                    </p>
                </div>
                <div>
                    @if($dataStunting->status_stunting === 'Normal')
                        <div class="p-3 bg-white/50 rounded-full">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    @else
                        <div class="p-3 bg-white/50 rounded-full animate-pulse">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>