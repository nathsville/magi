<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    {{-- Header Solid Blue --}}
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span>Data Anak</span>
        </h2>
    </div>

    <div class="p-6">
        <div class="flex items-start space-x-6">
            <div class="flex-shrink-0 w-24 h-24 bg-blue-50 rounded-xl flex items-center justify-center border border-blue-100">
                <span class="text-4xl font-bold text-[#000878]">
                    {{ substr($dataStunting->dataPengukuran->anak->nama_anak, 0, 1) }}
                </span>
            </div>
            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-medium">Nama Lengkap</p>
                    <p class="text-base font-semibold text-gray-900 mt-0.5">{{ $dataStunting->dataPengukuran->anak->nama_anak }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-medium">NIK</p>
                    <p class="text-base font-mono font-medium text-gray-900 mt-0.5 bg-gray-50 px-2 py-0.5 rounded w-fit">
                        {{ $dataStunting->dataPengukuran->anak->nik_anak }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-medium">Jenis Kelamin</p>
                    <p class="text-sm font-medium text-gray-900 mt-0.5 flex items-center">
                        @if($dataStunting->dataPengukuran->anak->jenis_kelamin === 'L')
                            <span class="text-blue-600 mr-1">♂</span> Laki-laki
                        @else
                            <span class="text-pink-600 mr-1">♀</span> Perempuan
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-medium">Tanggal Lahir</p>
                    <p class="text-sm font-medium text-gray-900 mt-0.5">
                        {{ \Carbon\Carbon::parse($dataStunting->dataPengukuran->anak->tanggal_lahir)->locale('id')->isoFormat('D MMMM Y') }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-medium">Umur (saat ukur)</p>
                    <p class="text-sm font-medium text-gray-900 mt-0.5">{{ $dataStunting->dataPengukuran->umur_bulan }} bulan</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-medium">Posyandu</p>
                    <p class="text-sm font-medium text-gray-900 mt-0.5">{{ $dataStunting->dataPengukuran->posyandu->nama_posyandu }}</p>
                </div>
            </div>
        </div>
        
        {{-- Orang Tua Info --}}
        <div class="mt-6 pt-6 border-t border-gray-100">
            <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Informasi Orang Tua
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 rounded-lg p-4">
                <div>
                    <p class="text-xs text-gray-500">Nama Ibu</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $dataStunting->dataPengukuran->anak->orangTua->nama_ibu ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Nama Ayah</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $dataStunting->dataPengukuran->anak->orangTua->nama_ayah ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">No. Telepon</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $dataStunting->dataPengukuran->anak->orangTua->telepon ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>