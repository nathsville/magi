@if($notifikasiList->isEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden p-12 text-center">
        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 border border-gray-100">
            <i class="fas fa-bell-slash text-gray-400 text-3xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak Ada Notifikasi</h3>
        <p class="text-gray-500 mb-6 max-w-sm mx-auto">
            @if(request()->hasAny(['status', 'tipe']))
                Tidak ditemukan notifikasi yang sesuai dengan filter yang Anda pilih.
            @else
                Anda belum memiliki notifikasi terbaru saat ini.
            @endif
        </p>
        @if(request()->hasAny(['status', 'tipe']))
        <button onclick="clearFilters()" class="inline-flex items-center px-6 py-2.5 bg-[#000878] text-white font-bold rounded-lg hover:bg-blue-900 transition shadow-sm">
            <i class="fas fa-redo mr-2"></i>Reset Filter
        </button>
        @endif
    </div>
@else
    <div class="space-y-4">
        @foreach($notifikasiList as $notifikasi)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition duration-300 {{ $notifikasi->status_baca === 'Belum Dibaca' ? 'border-l-4 border-l-[#000878]' : '' }}">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    {{-- Left Content --}}
                    <div class="flex-1">
                        <div class="flex items-center mb-3">
                            {{-- Icon based on type --}}
                            @php
                                $icons = [
                                    'Validasi' => ['icon' => 'fa-check-circle', 'bg' => 'bg-blue-50', 'text' => 'text-blue-600'],
                                    'Peringatan' => ['icon' => 'fa-exclamation-triangle', 'bg' => 'bg-orange-50', 'text' => 'text-orange-600'],
                                    'Informasi' => ['icon' => 'fa-info-circle', 'bg' => 'bg-teal-50', 'text' => 'text-teal-600']
                                ];
                                $iconData = $icons[$notifikasi->tipe_notifikasi] ?? ['icon' => 'fa-bell', 'bg' => 'bg-gray-50', 'text' => 'text-gray-600'];
                            @endphp
                            
                            <div class="w-10 h-10 rounded-lg {{ $iconData['bg'] }} flex items-center justify-center mr-3 border border-gray-100">
                                <i class="fas {{ $iconData['icon'] }} {{ $iconData['text'] }} text-lg"></i>
                            </div>

                            <div class="flex-1">
                                <div class="flex items-center flex-wrap gap-2">
                                    <h3 class="text-lg font-bold text-gray-900">{{ $notifikasi->judul }}</h3>
                                    @if($notifikasi->status_baca === 'Belum Dibaca')
                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-800 text-[10px] font-bold rounded uppercase tracking-wider">BARU</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 mt-0.5 flex items-center">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ \Carbon\Carbon::parse($notifikasi->tanggal_kirim)->locale('id')->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        {{-- Message --}}
                        <div class="pl-13 ml-13">
                            <p class="text-sm text-gray-700 mb-3 leading-relaxed">{{ $notifikasi->pesan }}</p>

                            {{-- Type Badge --}}
                            @php
                                $typeClasses = [
                                    'Validasi' => 'bg-blue-50 text-blue-700 border-blue-100',
                                    'Peringatan' => 'bg-orange-50 text-orange-700 border-orange-100',
                                    'Informasi' => 'bg-teal-50 text-teal-700 border-teal-100'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium border {{ $typeClasses[$notifikasi->tipe_notifikasi] ?? 'bg-gray-50 text-gray-700 border-gray-200' }}">
                                {{ $notifikasi->tipe_notifikasi }}
                            </span>
                        </div>
                    </div>

                    {{-- Right Actions --}}
                    <div class="ml-4 flex flex-col space-y-2">
                        @if($notifikasi->status_baca === 'Belum Dibaca')
                        <form method="POST" action="{{ route('posyandu.notifikasi.mark-as-read', $notifikasi->id_notifikasi) }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center px-3 py-2 bg-white border border-gray-300 text-gray-700 text-xs font-bold rounded-lg hover:bg-gray-50 transition shadow-sm">
                                <i class="fas fa-check mr-2 text-green-600"></i>Tandai Dibaca
                            </button>
                        </form>
                        @endif

                        <form method="POST" action="{{ route('posyandu.notifikasi.delete', $notifikasi->id_notifikasi) }}" 
                              onsubmit="return confirm('Hapus notifikasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full flex items-center justify-center px-3 py-2 bg-white border border-red-200 text-red-600 text-xs font-medium rounded-lg hover:bg-red-50 transition whitespace-nowrap shadow-sm">
                                <i class="fas fa-trash-alt mr-1.5"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($notifikasiList->hasPages())
    <div class="mt-6 px-4 py-3 bg-white border border-gray-200 rounded-xl shadow-sm">
        {{ $notifikasiList->appends(request()->query())->links() }}
    </div>
    @endif
@endif