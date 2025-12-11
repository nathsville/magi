<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    {{-- Header --}}
    <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
        <h3 class="font-bold text-gray-800 flex items-center">
            <svg class="w-5 h-5 mr-2 text-[#000878]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            Notifikasi
        </h3>
        <a href="{{ route('posyandu.notifikasi.index') }}" class="text-xs font-medium text-blue-600 hover:text-blue-800">
            Lihat Semua
        </a>
    </div>

    @if($notifications->isEmpty())
        <div class="p-6 text-center">
            <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <p class="text-sm text-gray-500">Belum ada notifikasi baru</p>
        </div>
    @else
        <div class="divide-y divide-gray-100">
            @foreach($notifications->take(5) as $notif)
            <div class="p-4 hover:bg-gray-50 transition {{ $notif->status_baca === 'Belum Dibaca' ? 'bg-blue-50/50' : '' }}">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 mt-0.5">
                        @php
                            $colors = [
                                'Validasi' => 'text-green-500 bg-green-100',
                                'Peringatan' => 'text-orange-500 bg-orange-100',
                                'Informasi' => 'text-blue-500 bg-blue-100'
                            ];
                            $icons = [
                                'Validasi' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                                'Peringatan' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>',
                                'Informasi' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                            ];
                            $type = $notif->tipe_notifikasi ?? 'Informasi';
                        @endphp
                        <span class="flex items-center justify-center w-8 h-8 rounded-lg {{ $colors[$type] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $icons[$type] !!}
                            </svg>
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $notif->judul }}</p>
                        <p class="text-xs text-gray-600 mt-0.5 line-clamp-2">{{ Str::limit($notif->pesan, 60) }}</p>
                        <p class="text-[10px] text-gray-400 mt-1 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $notif->tanggal_kirim->diffForHumans() }}
                        </p>
                    </div>
                    @if($notif->status_baca === 'Belum Dibaca')
                        <span class="w-2 h-2 bg-blue-600 rounded-full mt-2"></span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>