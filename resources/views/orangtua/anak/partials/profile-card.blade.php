<div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl shadow-2xl overflow-hidden">
    <div class="p-8 text-white">
        <div class="flex items-start justify-between">
            {{-- Avatar & Info --}}
            <div class="flex items-center space-x-6">
                {{-- Avatar --}}
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 bg-white bg-opacity-20 rounded-full flex items-center justify-center text-6xl backdrop-blur-sm border-4 border-white border-opacity-30">
                        {{ $anak->jenis_kelamin === 'L' ? '👦' : '👧' }}
                    </div>
                </div>

                {{-- Info --}}
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ $anak->nama_anak }}</h1>
                    <div class="flex items-center space-x-4 text-purple-100">
                        <span class="flex items-center">
                            <i class="fas fa-venus-mars mr-2"></i>
                            {{ $anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d F Y') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Badge --}}
            <div class="flex flex-col items-end space-y-2">
                <span class="px-4 py-2 bg-white bg-opacity-20 rounded-full text-sm font-medium backdrop-blur-sm">
                    NIK: {{ $anak->nik_anak }}
                </span>
            </div>
        </div>

        {{-- Detail Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
            <div class="bg-white bg-opacity-10 rounded-lg p-4 backdrop-blur-sm">
                <p class="text-purple-200 text-sm mb-1">Usia</p>
                <p class="text-2xl font-bold">{{ floor($umurBulan / 12) }} tahun</p>
                <p class="text-purple-200 text-xs">{{ $umurBulan }} bulan</p>
            </div>

            <div class="bg-white bg-opacity-10 rounded-lg p-4 backdrop-blur-sm">
                <p class="text-purple-200 text-sm mb-1">Tempat Lahir</p>
                <p class="text-lg font-bold">{{ $anak->tempat_lahir ?? 'N/A' }}</p>
            </div>

            <div class="bg-white bg-opacity-10 rounded-lg p-4 backdrop-blur-sm">
                <p class="text-purple-200 text-sm mb-1">Anak Ke</p>
                <p class="text-2xl font-bold">{{ $anak->anak_ke ?? '-' }}</p>
            </div>

            <div class="bg-white bg-opacity-10 rounded-lg p-4 backdrop-blur-sm">
                <p class="text-purple-200 text-sm mb-1">Posyandu</p>
                <p class="text-sm font-bold">{{ $anak->posyandu->nama_posyandu ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>