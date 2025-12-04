<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    {{-- Header Solid Blue --}}
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-white/10 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white">Intervensi Terbaru</h3>
                    <p class="text-xs text-blue-100">5 Tindakan terakhir</p>
                </div>
            </div>
            <a href="{{ route('puskesmas.intervensi.index') }}" 
                class="text-xs font-medium text-white bg-white/20 hover:bg-white/30 px-3 py-1.5 rounded-lg transition">
                Lihat Semua
            </a>
        </div>
    </div>

    <div class="divide-y divide-gray-100">
        @forelse($intervensiTerbaru as $intervensi)
        <div class="p-4 hover:bg-gray-50 transition group cursor-default">
            <div class="flex items-start space-x-4">
                {{-- Dynamic Icon & Color Logic --}}
                @php
                    $colorClass = match($intervensi->jenis_intervensi) {
                        'PMT' => 'bg-green-50 text-green-600 border-green-100',
                        'Suplemen/Vitamin' => 'bg-blue-50 text-blue-600 border-blue-100',
                        'Edukasi Gizi' => 'bg-yellow-50 text-yellow-600 border-yellow-100',
                        'Rujukan RS' => 'bg-red-50 text-red-600 border-red-100',
                        'Konseling' => 'bg-purple-50 text-purple-600 border-purple-100',
                        default => 'bg-gray-50 text-gray-600 border-gray-100',
                    };
                @endphp

                <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center border {{ $colorClass }}">
                    @if($intervensi->jenis_intervensi === 'PMT')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    @elseif($intervensi->jenis_intervensi === 'Suplemen/Vitamin')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    @elseif($intervensi->jenis_intervensi === 'Rujukan RS')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    @else
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    @endif
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-sm font-bold text-gray-900 group-hover:text-primary transition-colors">
                                {{ $intervensi->anak->nama_anak }}
                            </h4>
                            <div class="flex items-center mt-1 space-x-2">
                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide rounded-md
                                    {{ $intervensi->jenis_intervensi === 'PMT' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $intervensi->jenis_intervensi === 'Suplemen/Vitamin' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $intervensi->jenis_intervensi === 'Edukasi Gizi' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $intervensi->jenis_intervensi === 'Rujukan RS' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $intervensi->jenis_intervensi === 'Lainnya' ? 'bg-gray-100 text-gray-700' : '' }}">
                                    {{ $intervensi->jenis_intervensi }}
                                </span>
                                <span class="text-xs text-gray-400">•</span>
                                <span class="text-xs text-gray-500">
                                    {{ $intervensi->tanggal_pelaksanaan->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($intervensi->catatan_perkembangan)
                    <div class="mt-2 text-xs text-gray-600 bg-gray-50 p-2 rounded border border-gray-100 line-clamp-2">
                        {{ $intervensi->catatan_perkembangan }}
                    </div>
                    @endif

                    <div class="mt-3 flex items-center justify-between">
                        <div class="flex items-center text-xs text-gray-500">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $intervensi->tanggal_pelaksanaan->locale('id')->isoFormat('D MMM Y') }}
                        </div>

                        {{-- Status Pill --}}
                        <div class="flex items-center space-x-1.5">
                            <span class="relative flex h-2 w-2">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75 
                                {{ $intervensi->status_tindak_lanjut === 'Selesai' ? 'bg-green-400' : 'bg-yellow-400' }}"></span>
                              <span class="relative inline-flex rounded-full h-2 w-2 
                                {{ $intervensi->status_tindak_lanjut === 'Selesai' ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                            </span>
                            <span class="text-xs font-medium {{ $intervensi->status_tindak_lanjut === 'Selesai' ? 'text-green-700' : 'text-yellow-700' }}">
                                {{ $intervensi->status_tindak_lanjut }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        {{-- Empty State --}}
        <div class="p-8 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002 2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-900">Belum Ada Intervensi</h3>
            <p class="text-xs text-gray-500 mt-1 mb-4">Mulai catat tindakan intervensi untuk anak</p>
            <a href="{{ route('puskesmas.intervensi.index') }}" 
                class="inline-flex items-center px-4 py-2 text-xs font-medium text-white bg-[#000878] rounded-lg hover:bg-blue-900 transition shadow-sm">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Kelola Intervensi
            </a>
        </div>
        @endforelse
    </div>
</div>