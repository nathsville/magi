@if($notifikasiList->isEmpty())
    <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
        <i class="fas fa-bell-slash text-gray-300 text-6xl mb-4"></i>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak Ada Notifikasi</h3>
        <p class="text-gray-600 mb-4">
            @if(request()->has('status') || request()->has('tipe'))
                Tidak ditemukan notifikasi dengan filter yang dipilih.
            @else
                Anda belum memiliki notifikasi saat ini.
            @endif
        </p>
        @if(request()->has('status') || request()->has('tipe'))
            <button onclick="clearFilters()" class="px-6 py-2 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition">
                <i class="fas fa-redo mr-2"></i>Reset Filter
            </button>
        @endif
    </div>
@else
    <div class="space-y-3">
        @foreach($notifikasiList as $notif)
        <a href="{{ route('orangtua.notifikasi.show', $notif->id_notifikasi) }}" 
           class="block bg-white rounded-xl shadow-lg hover:shadow-xl transition {{ $notif->status_baca === 'Belum Dibaca' ? 'border-l-4 border-purple-500' : '' }}">
            <div class="p-5">
                <div class="flex items-start justify-between">
                    {{-- Icon & Content --}}
                    <div class="flex items-start space-x-4 flex-1">
                        {{-- Icon --}}
                        <div class="flex-shrink-0">
                            @php
                                $iconBg = 'bg-blue-100';
                                $iconColor = 'text-blue-600';
                                $icon = 'fa-info-circle';
                                
                                if ($notif->tipe_notifikasi === 'Peringatan') {
                                    $iconBg = 'bg-orange-100';
                                    $iconColor = 'text-orange-600';
                                    $icon = 'fa-exclamation-triangle';
                                } elseif ($notif->tipe_notifikasi === 'Validasi') {
                                    $iconBg = 'bg-green-100';
                                    $iconColor = 'text-green-600';
                                    $icon = 'fa-check-circle';
                                }
                            @endphp
                            <div class="w-12 h-12 {{ $iconBg }} rounded-full flex items-center justify-center">
                                <i class="fas {{ $icon }} {{ $iconColor }} text-xl"></i>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2 mb-1">
                                <h3 class="text-lg font-bold text-gray-800 {{ $notif->status_baca === 'Belum Dibaca' ? '' : 'text-gray-600' }}">
                                    {{ $notif->judul }}
                                </h3>
                                @if($notif->status_baca === 'Belum Dibaca')
                                <span class="flex-shrink-0 w-2 h-2 bg-purple-600 rounded-full"></span>
                                @endif
                            </div>

                            <p class="text-gray-600 text-sm mb-2 line-clamp-2">
                                {{ Str::limit($notif->pesan, 120) }}
                            </p>

                            <div class="flex items-center space-x-4 text-xs text-gray-500">
                                <span>
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ \Carbon\Carbon::parse($notif->tanggal_kirim)->diffForHumans() }}
                                </span>
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $iconBg }} {{ $iconColor }}">
                                    {{ $notif->tipe_notifikasi }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Arrow --}}
                    <div class="flex-shrink-0 ml-4">
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
@endif