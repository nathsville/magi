@if($notifikasiList->isEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-1">Tidak Ada Notifikasi</h3>
        <p class="text-gray-500 mb-4 text-sm">
            @if(request()->has('status') || request()->has('tipe'))
                Tidak ditemukan notifikasi dengan filter yang dipilih.
            @else
                Anda belum memiliki notifikasi saat ini.
            @endif
        </p>
        @if(request()->has('status') || request()->has('tipe'))
            <button onclick="clearFilters()" class="px-6 py-2.5 bg-[#000878] text-white font-medium rounded-lg hover:bg-blue-900 transition">
                Reset Filter
            </button>
        @endif
    </div>
@else
    <div class="space-y-3">
        @foreach($notifikasiList as $notif)
        <a href="{{ route('orangtua.notifikasi.show', $notif->id_notifikasi) }}" 
           class="block bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition p-5 
                  {{ $notif->status_baca === 'Belum Dibaca' ? 'border-l-4 border-l-[#000878]' : 'border-l-4 border-l-transparent' }}">
            
            <div class="flex items-start justify-between">
                {{-- Icon & Content --}}
                <div class="flex items-start space-x-4 flex-1">
                    {{-- Icon --}}
                    <div class="flex-shrink-0">
                        @php
                            $iconBg = 'bg-blue-50';
                            $iconColor = 'text-blue-600';
                            
                            if ($notif->tipe_notifikasi === 'Peringatan') {
                                $iconBg = 'bg-orange-50';
                                $iconColor = 'text-orange-600';
                            } elseif ($notif->tipe_notifikasi === 'Validasi') {
                                $iconBg = 'bg-green-50';
                                $iconColor = 'text-green-600';
                            }
                        @endphp
                        <div class="w-10 h-10 {{ $iconBg }} rounded-full flex items-center justify-center">
                            @if($notif->tipe_notifikasi === 'Peringatan')
                                <svg class="w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            @elseif($notif->tipe_notifikasi === 'Validasi')
                                <svg class="w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @else
                                <svg class="w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @endif
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="text-base font-bold text-gray-900 {{ $notif->status_baca === 'Belum Dibaca' ? '' : 'font-medium text-gray-600' }}">
                                {{ $notif->judul }}
                            </h3>
                            @if($notif->status_baca === 'Belum Dibaca')
                                <span class="flex-shrink-0 w-2 h-2 bg-[#000878] rounded-full"></span>
                            @endif
                        </div>

                        <p class="text-gray-600 text-sm mb-2 line-clamp-2">
                            {{ Str::limit($notif->pesan, 120) }}
                        </p>

                        <div class="flex items-center space-x-4 text-xs text-gray-500">
                            <div class="flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ \Carbon\Carbon::parse($notif->tanggal_kirim)->diffForHumans() }}
                            </div>
                            <span class="px-2 py-0.5 rounded text-xs font-medium {{ $iconBg }} {{ $iconColor }}">
                                {{ $notif->tipe_notifikasi }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Arrow --}}
                <div class="flex-shrink-0 ml-4 self-center">
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>
        </a>
        @endforeach
    </div>
@endif