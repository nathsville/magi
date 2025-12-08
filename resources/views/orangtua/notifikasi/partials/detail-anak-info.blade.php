<div class="bg-purple-50 border-t border-purple-100 p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">
        <i class="fas fa-child text-purple-600 mr-2"></i>Informasi Anak Terkait
    </h3>

    <div class="bg-white rounded-xl p-4 shadow-sm">
        <div class="flex items-start space-x-4">
            {{-- Avatar --}}
            <div class="flex-shrink-0">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                    {{ strtoupper(substr($anak->nama_anak, 0, 1)) }}
                </div>
            </div>

            {{-- Info --}}
            <div class="flex-1">
                <h4 class="text-lg font-bold text-gray-800 mb-1">{{ $anak->nama_anak }}</h4>
                <div class="space-y-1 text-sm text-gray-600">
                    <div class="flex items-center">
                        <i class="fas fa-venus-mars w-5 text-gray-400"></i>
                        <span>{{ $anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-birthday-cake w-5 text-gray-400"></i>
                        <span>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->age }} tahun 
                            ({{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now()) }} bulan)</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt w-5 text-gray-400"></i>
                        <span>{{ $anak->posyandu->nama_posyandu ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            {{-- Action Button --}}
            <div class="flex-shrink-0">
                <a href="{{ route('orangtua.anak.detail', $anak->id_anak) }}" 
                   class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition">
                    <i class="fas fa-chart-line mr-2"></i>Lihat Detail
                </a>
            </div>
        </div>
    </div>
</div>