<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <svg class="w-5 h-5 text-[#000878] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            Top 5 Puskesmas - Kasus Tertinggi
        </h3>
        <p class="text-sm text-gray-600 mt-1">Puskesmas dengan jumlah kasus stunting terbanyak</p>
    </div>

    <div class="p-6">
        @if($topPuskesmas->count() > 0)
            <div class="space-y-3">
                @foreach($topPuskesmas as $index => $pusk)
                    <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-white rounded-lg border border-gray-200 hover:shadow-md transition group">
                        {{-- Rank Badge --}}
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg
                                {{ $index === 0 ? 'bg-gradient-to-br from-yellow-400 to-yellow-600 text-white shadow-lg' : '' }}
                                {{ $index === 1 ? 'bg-gradient-to-br from-gray-300 to-gray-500 text-white shadow-md' : '' }}
                                {{ $index === 2 ? 'bg-gradient-to-br from-orange-400 to-orange-600 text-white shadow-md' : '' }}
                                {{ $index > 2 ? 'bg-gradient-to-br from-blue-100 to-blue-200 text-[#000878]' : '' }}">
                                {{ $index + 1 }}
                            </div>
                        </div>

                        {{-- Puskesmas Info --}}
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-gray-900 truncate group-hover:text-[#000878] transition">
                                {{ $pusk->nama_puskesmas }}
                            </h4>
                            <p class="text-xs text-gray-500 flex items-center mt-1">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Kec. {{ $pusk->kecamatan }}
                            </p>
                        </div>

                        {{-- Stats --}}
                        <div class="text-right ml-4">
                            <p class="text-2xl font-bold text-red-600">
                                {{ number_format($pusk->total_stunting) }}
                            </p>
                            <p class="text-xs text-gray-500">kasus</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-sm">Belum ada data tersedia</p>
            </div>
        @endif
    </div>

    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        <a href="{{ route('dppkb.monitoring') }}" 
            class="text-sm font-medium text-[#000878] hover:text-blue-900 flex items-center justify-center group">
            <span>Lihat Semua Puskesmas</span>
            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
</div>