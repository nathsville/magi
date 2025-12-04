<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-6">
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Input Terbaru</span>
            </h2>
            <span class="text-[10px] font-medium text-blue-100 bg-white/10 px-2 py-1 rounded border border-white/10">
                Sesi Ini
            </span>
        </div>
    </div>
    
    <div class="divide-y divide-gray-100">
        @php
            // Get recent inputs from session or database
            $recentInputs = session('recent_inputs', []);
        @endphp
        
        @forelse($recentInputs as $input)
        <div class="p-4 hover:bg-gray-50 transition group">
            <div class="flex justify-between items-start">
                {{-- Info Anak --}}
                <div class="flex-1 min-w-0 pr-3">
                    <p class="text-sm font-bold text-gray-900 group-hover:text-[#000878] transition-colors truncate">
                        {{ $input['nama_anak'] }}
                    </p>
                    
                    <div class="flex items-center space-x-3 mt-1.5">
                        <div class="flex items-center text-xs text-gray-600 bg-gray-100 px-1.5 py-0.5 rounded border border-gray-200">
                            <svg class="w-3 h-3 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                            </svg>
                            {{ $input['berat_badan'] }} kg
                        </div>
                        <div class="flex items-center text-xs text-gray-600 bg-gray-100 px-1.5 py-0.5 rounded border border-gray-200">
                            <svg class="w-3 h-3 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                            {{ $input['tinggi_badan'] }} cm
                        </div>
                    </div>
                </div>

                {{-- Status & Time --}}
                <div class="text-right flex flex-col items-end">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide border
                        {{ $input['status_gizi'] === 'Normal' ? 'bg-green-50 text-green-700 border-green-100' : 'bg-red-50 text-red-700 border-red-100' }}">
                        {{ $input['status_gizi'] }}
                    </span>
                    <span class="text-[10px] text-gray-400 mt-1 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $input['time_ago'] }}
                    </span>
                </div>
            </div>
        </div>
        @empty
        <div class="p-8 text-center">
            <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 border border-gray-100">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002 2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-900">Belum Ada Data</h3>
            <p class="text-xs text-gray-500 mt-1">Data yang Anda input sesi ini akan muncul di sini.</p>
        </div>
        @endforelse
    </div>
    
    @if(count($recentInputs) > 0)
    <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
        <a href="{{ route('puskesmas.monitoring') }}" 
            class="flex items-center justify-center text-sm font-medium text-[#000878] hover:text-blue-900 transition-colors group">
            Lihat Semua Riwayat
            <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg>
        </a>
    </div>
    @endif
</div>