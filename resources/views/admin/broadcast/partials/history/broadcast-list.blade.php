<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-[#000878]">
        <h2 class="text-lg font-semibold text-white">Daftar Broadcast</h2>
    </div>

    <div class="divide-y divide-gray-200">
        @foreach($broadcasts as $broadcast)
        <div class="p-6 hover:bg-gray-50 transition">
            <div class="flex items-start space-x-4">
                {{-- Icon (Solid Color) --}}
                <div class="flex-shrink-0 w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                </div>

                {{-- Content --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-base font-semibold text-gray-900">{{ $broadcast->judul }}</h3>
                            <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $broadcast->pesan }}</p>
                        </div>
                    </div>

                    {{-- Meta Info --}}
                    <div class="flex flex-wrap items-center gap-4 mt-3">
                        {{-- Penerima --}}
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>{{ $broadcast->user->nama ?? 'N/A' }}</span>
                        </div>

                        {{-- Tanggal --}}
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ $broadcast->tanggal_kirim->format('d M Y, H:i') }}</span>
                        </div>

                        {{-- Relative Time --}}
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $broadcast->tanggal_kirim->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($broadcasts->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $broadcasts->links() }}
    </div>
    @endif
</div>