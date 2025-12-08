<div class="bg-white rounded-2xl shadow-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-800">
            <i class="fas fa-bell text-purple-600 mr-2"></i>Notifikasi Terbaru
        </h3>
        <a href="{{ route('orangtua.notifikasi.index') }}" class="text-purple-600 hover:text-purple-700 text-sm font-medium">
            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>

    @if($latestNotifications->isEmpty())
        <div class="text-center py-8">
            <i class="fas fa-bell-slash text-gray-300 text-4xl mb-3"></i>
            <p class="text-gray-500 text-sm">Belum ada notifikasi</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($latestNotifications as $notif)
            <a href="{{ route('orangtua.notifikasi.show', $notif->id_notifikasi) }}" 
               class="block p-3 rounded-lg border {{ $notif->status_baca === 'Belum Dibaca' ? 'bg-purple-50 border-purple-200' : 'bg-gray-50 border-gray-200' }} hover:shadow-md transition">
                <div class="flex items-start space-x-3">
                    {{-- Icon --}}
                    <div class="flex-shrink-0">
                        @php
                            $iconClass = 'fa-info-circle text-blue-500';
                            if ($notif->tipe_notifikasi === 'Validasi') {
                                $iconClass = 'fa-check-circle text-green-500';
                            } elseif ($notif->tipe_notifikasi === 'Peringatan') {
                                $iconClass = 'fa-exclamation-triangle text-orange-500';
                            }
                        @endphp
                        <i class="fas {{ $iconClass }} text-xl"></i>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ $notif->judul }}</p>
                        <p class="text-xs text-gray-600 mt-1 line-clamp-2">{{ Str::limit($notif->pesan, 60) }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($notif->tanggal_kirim)->diffForHumans() }}</p>
                    </div>

                    {{-- Unread Badge --}}
                    @if($notif->status_baca === 'Belum Dibaca')
                    <div class="flex-shrink-0">
                        <span class="w-2 h-2 bg-purple-600 rounded-full block"></span>
                    </div>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    @endif
</div>