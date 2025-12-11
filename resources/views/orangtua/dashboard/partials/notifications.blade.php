<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200 flex justify-between items-center">
<h3 class="text-lg font-bold text-white flex items-center">
            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            Notifikasi Terbaru
        </h3>
        <a href="{{ route('orangtua.notifikasi.index') }}" class="text-xs font-medium text-white/80 hover:text-white transition flex items-center">
            Lihat Semua
        </a>
    </div>

    @if($latestNotifications->isEmpty())
        <div class="p-6 text-center">
            <p class="text-gray-500 text-sm">Tidak ada notifikasi baru</p>
        </div>
    @else
        <div class="divide-y divide-gray-100">
            @foreach($latestNotifications as $notif)
            <a href="{{ route('orangtua.notifikasi.show', $notif->id_notifikasi) }}" 
               class="block p-4 hover:bg-gray-50 transition group">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 mt-0.5">
                        @php
                            $iconColor = 'text-blue-500';
                            if ($notif->tipe_notifikasi === 'Peringatan') $iconColor = 'text-orange-500';
                            if ($notif->tipe_notifikasi === 'Validasi') $iconColor = 'text-green-500';
                        @endphp
                        <svg class="w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($notif->tipe_notifikasi === 'Peringatan')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            @elseif($notif->tipe_notifikasi === 'Validasi')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            @endif
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start mb-0.5">
                            <p class="text-sm font-medium text-gray-900 group-hover:text-[#000878] transition-colors truncate pr-2">
                                {{ $notif->judul }}
                            </p>
                            @if($notif->status_baca === 'Belum Dibaca')
                                <span class="block w-2 h-2 bg-red-500 rounded-full flex-shrink-0"></span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 line-clamp-1 mb-1">{{ $notif->pesan }}</p>
                        <p class="text-[10px] text-gray-400">
                            {{ \Carbon\Carbon::parse($notif->tanggal_kirim)->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @endif
</div>