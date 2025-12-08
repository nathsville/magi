@if($anakList->isEmpty())
    <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
        <i class="fas fa-child text-gray-300 text-6xl mb-4"></i>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak Ada Data Anak</h3>
        <p class="text-gray-600 mb-4">
            @if(request()->has('search') || request()->has('status'))
                Tidak ditemukan anak dengan kriteria pencarian Anda.
            @else
                Belum ada data anak yang terdaftar dalam sistem.
            @endif
        </p>
        @if(request()->has('search') || request()->has('status'))
            <button onclick="clearFilters()" class="px-6 py-2 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition">
                <i class="fas fa-redo mr-2"></i>Reset Filter
            </button>
        @endif
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($anakList as $anak)
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
            {{-- Card Header --}}
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center text-3xl">
                        {{ $anak->jenis_kelamin === 'L' ? '👦' : '👧' }}
                    </div>
                    <span class="px-3 py-1 bg-white bg-opacity-20 rounded-full text-sm font-medium">
                        {{ $anak->jenis_kelamin === 'L' ? '♂ Laki-laki' : '♀ Perempuan' }}
                    </span>
                </div>
                <h3 class="text-xl font-bold">{{ $anak->nama_anak }}</h3>
            </div>

            {{-- Card Body --}}
            <div class="p-6">
                {{-- Info --}}
                <div class="space-y-3 mb-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-calendar-alt w-6 text-purple-500"></i>
                        <span>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d F Y') }}</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-birthday-cake w-6 text-purple-500"></i>
                        <span>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->age }} tahun 
                            ({{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now()) }} bulan)</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-map-marker-alt w-6 text-purple-500"></i>
                        <span>{{ $anak->posyandu->nama_posyandu ?? 'N/A' }}</span>
                    </div>
                </div>

                {{-- Latest Status --}}
                @if($anak->stuntingTerakhir)
                <div class="mb-4 p-3 rounded-lg {{ $anak->stuntingTerakhir->status_stunting === 'Normal' ? 'bg-green-50' : 'bg-orange-50' }}">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Status Terakhir:</span>
                        <span class="px-3 py-1 text-sm font-bold rounded-full {{ $anak->stuntingTerakhir->status_stunting === 'Normal' ? 'bg-green-200 text-green-800' : 'bg-orange-200 text-orange-800' }}">
                            {{ $anak->stuntingTerakhir->status_stunting }}
                        </span>
                    </div>
                </div>
                @else
                <div class="mb-4 p-3 rounded-lg bg-gray-50">
                    <p class="text-sm text-gray-600 text-center">Belum ada data pengukuran</p>
                </div>
                @endif

                {{-- Latest Measurement --}}
                @if($anak->pengukuranTerakhir)
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div class="text-center p-2 bg-blue-50 rounded-lg">
                        <p class="text-xs text-gray-600">Berat Badan</p>
                        <p class="text-lg font-bold text-blue-700">{{ number_format($anak->pengukuranTerakhir->berat_badan, 1) }} kg</p>
                    </div>
                    <div class="text-center p-2 bg-purple-50 rounded-lg">
                        <p class="text-xs text-gray-600">Tinggi Badan</p>
                        <p class="text-lg font-bold text-purple-700">{{ number_format($anak->pengukuranTerakhir->tinggi_badan, 1) }} cm</p>
                    </div>
                </div>
                @endif

                {{-- Action Button --}}
                <a href="{{ route('orangtua.anak.detail', $anak->id_anak) }}" 
                   class="block w-full py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-center font-bold rounded-lg hover:from-purple-700 hover:to-pink-700 transition shadow-lg">
                    <i class="fas fa-chart-line mr-2"></i>Lihat Detail & Grafik
                </a>
            </div>
        </div>
        @endforeach
    </div>
@endif