@if($anakList->isEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-1">Tidak Ada Data Anak</h3>
        <p class="text-gray-500 mb-4 text-sm">
            @if(request()->has('search') || request()->has('status'))
                Tidak ditemukan anak dengan kriteria pencarian Anda.
            @else
                Belum ada data anak yang terdaftar dalam sistem.
            @endif
        </p>
        @if(request()->has('search') || request()->has('status'))
            <button onclick="clearFilters()" class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                Reset Filter
            </button>
        @endif
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($anakList as $anak)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition duration-300 flex flex-col h-full">
            {{-- Card Header --}}
            <div class="p-6 border-b border-gray-100 flex-1">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center text-xl font-bold text-white shadow-sm
                            {{ $anak->jenis_kelamin === 'L' ? 'bg-blue-600' : 'bg-pink-500' }}">
                            {{ strtoupper(substr($anak->nama_anak, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 line-clamp-1">{{ $anak->nama_anak }}</h3>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium mt-1
                                {{ $anak->jenis_kelamin === 'L' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-pink-50 text-pink-700 border border-pink-100' }}">
                                {{ $anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Info Grid --}}
                <div class="space-y-3 text-sm">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d F Y') }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 6.58-10.18 6.777-13.434 5.932-3.63-1.243-8.254-4.106-7.548-10.156.26-2.227 1.697-3.918 3.58-4.993 4.296-2.454 8.718.337 9.873.79 1.137.447 2.656-.818 3.736-.316 2.127.99 3.322 3.86 3.793 8.643z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->age }} thn {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now()) % 12 }} bln</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="line-clamp-1">{{ $anak->posyandu->nama_posyandu ?? 'N/A' }}</span>
                    </div>
                </div>

                {{-- Status Badges --}}
                <div class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-2 gap-3">
                    <div class="bg-gray-50 rounded-lg p-2 text-center">
                        <p class="text-xs text-gray-500 mb-1">Status Gizi</p>
                        @if($anak->stuntingTerakhir)
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full
                                {{ $anak->stuntingTerakhir->status_stunting === 'Normal' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                {{ $anak->stuntingTerakhir->status_stunting }}
                            </span>
                        @else
                            <span class="text-xs font-medium text-gray-400">-</span>
                        @endif
                    </div>
                    
                    @if($anak->pengukuranTerakhir)
                    <div class="bg-gray-50 rounded-lg p-2 text-center">
                        <p class="text-xs text-gray-500 mb-1">Terakhir Ukur</p>
                        <p class="text-xs font-bold text-gray-700">
                            {{ \Carbon\Carbon::parse($anak->pengukuranTerakhir->tanggal_ukur)->format('d M y') }}
                        </p>
                    </div>
                    @else
                    <div class="bg-gray-50 rounded-lg p-2 text-center">
                        <p class="text-xs text-gray-500 mb-1">Pengukuran</p>
                        <p class="text-xs text-gray-400">Belum ada</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Footer Action --}}
            <a href="{{ route('orangtua.anak.detail', $anak->id_anak) }}" 
               class="block w-full py-3 bg-gray-50 text-[#000878] text-center text-sm font-semibold hover:bg-[#000878] hover:text-white transition-colors border-t border-gray-100 group">
                Lihat Detail Lengkap
                <svg class="w-4 h-4 inline-block ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
        @endforeach
    </div>
@endif