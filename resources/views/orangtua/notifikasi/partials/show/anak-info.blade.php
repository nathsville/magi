<div class="bg-gray-50 border-t border-gray-200 p-6">
    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4 flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        Data Anak Terkait
    </h3>

    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition">
        <div class="flex items-start justify-between">
            <div class="flex items-center space-x-4">
                {{-- Avatar --}}
                <div class="flex-shrink-0">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center text-xl font-bold text-white shadow-sm
                        {{ $anak->jenis_kelamin === 'L' ? 'bg-blue-600' : 'bg-pink-500' }}">
                        {{ strtoupper(substr($anak->nama_anak, 0, 1)) }}
                    </div>
                </div>

                {{-- Info --}}
                <div>
                    <h4 class="text-lg font-bold text-gray-900">{{ $anak->nama_anak }}</h4>
                    <div class="flex items-center text-sm text-gray-600 mt-1 space-x-3">
                        <span class="flex items-center">
                            {{ $anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                        <span class="text-gray-300">•</span>
                        <span>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->age }} tahun</span>
                    </div>
                    @if($anak->posyandu)
                    <div class="text-xs text-gray-500 mt-1 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $anak->posyandu->nama_posyandu }}
                    </div>
                    @endif
                </div>
            </div>

            {{-- Action Button --}}
            <a href="{{ route('orangtua.anak.detail', $anak->id_anak) }}" 
               class="hidden md:flex items-center px-4 py-2 bg-white border border-[#000878] text-[#000878] text-sm font-medium rounded-lg hover:bg-blue-50 transition">
                Lihat Grafik
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </a>
        </div>
        
        {{-- Mobile Button --}}
        <a href="{{ route('orangtua.anak.detail', $anak->id_anak) }}" 
           class="md:hidden mt-4 flex justify-center w-full items-center px-4 py-2 bg-white border border-[#000878] text-[#000878] text-sm font-medium rounded-lg hover:bg-blue-50 transition">
            Lihat Grafik Pertumbuhan
        </a>
    </div>
</div>