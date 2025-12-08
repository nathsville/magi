<div class="bg-white rounded-2xl shadow-lg p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-gray-800">
            <i class="fas fa-child text-purple-600 mr-2"></i>Data Anak Saya
        </h3>
        <a href="{{ route('orangtua.anak.index') }}" class="text-purple-600 hover:text-purple-700 text-sm font-medium">
            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>

    @if($anakList->isEmpty())
        <div class="text-center py-12">
            <i class="fas fa-child text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500 mb-4">Belum ada data anak yang terdaftar</p>
            <p class="text-gray-400 text-sm">Hubungi Petugas Posyandu untuk mendaftarkan anak Anda</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($anakList as $anak)
            <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    {{-- Anak Info --}}
                    <div class="flex items-start space-x-4 flex-1">
                        {{-- Avatar --}}
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                                {{ strtoupper(substr($anak->nama_anak, 0, 1)) }}
                            </div>
                        </div>

                        {{-- Details --}}
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1">
                                <h4 class="text-lg font-bold text-gray-800">{{ $anak->nama_anak }}</h4>
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $anak->jenis_kelamin === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                    {{ $anak->jenis_kelamin === 'L' ? '♂ Laki-laki' : '♀ Perempuan' }}
                                </span>
                            </div>

                            <div class="text-sm text-gray-600 space-y-1">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt w-5 text-gray-400"></i>
                                    <span>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d F Y') }} 
                                        ({{ \Carbon\Carbon::parse($anak->tanggal_lahir)->age }} tahun)</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt w-5 text-gray-400"></i>
                                    <span>{{ $anak->posyandu->nama_posyandu ?? 'N/A' }}</span>
                                </div>
                            </div>

                            {{-- Latest Status --}}
                            @if($anak->stuntingTerakhir)
                            <div class="mt-3">
                                @php
                                    $status = $anak->stuntingTerakhir->status_stunting;
                                    $badgeClass = $status === 'Normal' ? 'bg-green-100 text-green-700 border-green-200' : 'bg-orange-100 text-orange-700 border-orange-200';
                                    $icon = $status === 'Normal' ? 'fa-check-circle' : 'fa-exclamation-triangle';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full border {{ $badgeClass }}">
                                    <i class="fas {{ $icon }} mr-2"></i>{{ $status }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('orangtua.anak.detail', $anak->id_anak) }}" 
                           class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition text-center">
                            <i class="fas fa-chart-line mr-2"></i>Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>