@if($notifikasiList->isEmpty())
    <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
        <i class="fas fa-bell-slash text-gray-300 text-6xl mb-4"></i>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak Ada Notifikasi</h3>
        <p class="text-gray-600 mb-6">
            @if(request()->hasAny(['status', 'tipe']))
                Tidak ditemukan notifikasi yang sesuai dengan filter.
            @else
                Anda belum memiliki notifikasi.
            @endif
        </p>
        @if(request()->hasAny(['status', 'tipe']))
        <button onclick="clearFilters()" class="px-6 py-3 bg-gray-600 text-white font-bold rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-redo mr-2"></i>Reset Filter
        </button>
        @endif
    </div>
@else
    <div class="space-y-4">
        @foreach($notifikasiList as $notifikasi)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition {{ $notifikasi->status_baca === 'Belum Dibaca' ? 'border-l-4 border-teal-500' : '' }}">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    {{-- Left Content --}}
                    <div class="flex-1">
                        <div class="flex items-center mb-3">
                            {{-- Icon based on type --}}
                            @php
                                $icons = [
                                    'Validasi' => ['icon' => 'fa-check-circle', 'color' => 'bg-blue-100 text-blue-600'],
                                    'Peringatan' => ['icon' => 'fa-exclamation-triangle', 'color' => 'bg-orange-100 text-orange-600'],
                                    'Informasi' => ['icon' => 'fa-info-circle', 'color' => 'bg-teal-100 text-teal-600']
                                ];
                                $iconData = $icons[$notifikasi->tipe_notifikasi] ?? ['icon' => 'fa-bell', 'color' => 'bg-gray-100 text-gray-600'];
                            @endphp
                            <div class="w-10 h-10 rounded-full {{ $iconData['color'] }} flex items-center justify-center mr-3">
                                <i class="fas {{ $iconData['icon'] }} text-lg"></i>
                            </div>

                            <div class="flex-1">
                                <div class="flex items-center">
                                    <h3 class="text-lg font-bold text-gray-800">{{ $notifikasi->judul }}</h3>
                                    @if($notifikasi->status_baca === 'Belum Dibaca')
                                    <span class="ml-3 px-2 py-1 bg-teal-100 text-teal-700 text-xs font-bold rounded-full">BARU</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ \Carbon\Carbon::parse($notifikasi->tanggal_kirim)->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        {{-- Message --}}
                        <p class="text-sm text-gray-700 mb-3 pl-13">{{ $notifikasi->pesan }}</p>

                        {{-- Type Badge --}}
                        <div class="pl-13">
                            @php
                                $typeBadges = [
                                    'Validasi' => 'bg-blue-100 text-blue-700',
                                    'Peringatan' => 'bg-orange-100 text-orange-700',
                                    'Informasi' => 'bg-teal-100 text-teal-700'
                                ];
                            @endphp
                            <span class="px-3 py-1 {{ $typeBadges[$notifikasi->tipe_notifikasi] ?? 'bg-gray-100 text-gray-700' }} text-xs font-medium rounded-full">
                                {{ $notifikasi->tipe_notifikasi }}
                            </span>
                        </div>
                    </div>

                    {{-- Right Actions --}}
                    <div class="ml-4 flex flex-col space-y-2">
                        @if($notifikasi->status_baca === 'Belum Dibaca')
                        <form method="POST" action="{{ route('posyandu.notifikasi.mark-as-read', $notifikasi->id_notifikasi) }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-teal-600 text-white text-sm font-medium rounded-lg hover:bg-teal-700 transition whitespace-nowrap">
                                <i class="fas fa-check mr-1"></i>Tandai Dibaca
                            </button>
                        </form>
                        @endif

                        <form method="POST" action="{{ route('posyandu.notifikasi.delete', $notifikasi->id_notifikasi) }}" 
                              onsubmit="return confirm('Hapus notifikasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition whitespace-nowrap">
                                <i class="fas fa-trash mr-1"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $notifikasiList->links() }}
    </div>
@endif