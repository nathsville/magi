@if($anakList->isEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">Tidak Ada Data Anak</h3>
        <p class="text-gray-500 mb-6">
            @if(request()->has('search') || request()->has('status'))
                Tidak ditemukan anak yang sesuai kriteria.
            @else
                Belum ada anak terdaftar.
            @endif
        </p>
        <div class="flex justify-center space-x-3">
            @if(request()->has('search') || request()->has('status'))
            <button onclick="clearFilters()" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium">
                Reset Filter
            </button>
            @endif
            <a href="{{ route('posyandu.anak.create') }}" class="px-4 py-2 bg-[#000878] text-white rounded-lg hover:bg-blue-900 text-sm font-medium">
                Daftar Anak Baru
            </a>
        </div>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($anakList as $anak)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow group">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold text-white
                            {{ $anak->jenis_kelamin === 'L' ? 'bg-blue-600' : 'bg-pink-500' }}">
                            {{ substr($anak->nama_anak, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 truncate max-w-[150px]" title="{{ $anak->nama_anak }}">
                                {{ $anak->nama_anak }}
                            </h3>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium
                                {{ $anak->jenis_kelamin === 'L' ? 'bg-blue-50 text-blue-700' : 'bg-pink-50 text-pink-700' }}">
                                {{ $anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="space-y-2 text-sm text-gray-600 mb-4">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                        </svg>
                        <span class="truncate">{{ $anak->nik_anak }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->age }} Tahun</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="truncate">{{ $anak->orangTua->nama_ayah ?? $anak->orangTua->nama_ibu ?? '-' }}</span>
                    </div>
                </div>

                {{-- Status Badge --}}
                @if($anak->stuntingTerakhir)
                    @php
                        $status = $anak->stuntingTerakhir->status_stunting;
                        $colorClass = match($status) {
                            'Normal' => 'bg-green-50 text-green-700 border-green-200',
                            'Stunting Ringan' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                            'Stunting Sedang' => 'bg-orange-50 text-orange-700 border-orange-200',
                            'Stunting Berat' => 'bg-red-50 text-red-700 border-red-200',
                            default => 'bg-gray-50 text-gray-700 border-gray-200'
                        };
                    @endphp
                    <div class="mb-4 px-3 py-1.5 rounded border {{ $colorClass }} text-center text-xs font-bold">
                        {{ $status }}
                    </div>
                @endif

                <div class="flex space-x-2 pt-4 border-t border-gray-100">
                    <a href="{{ route('posyandu.anak.show', $anak->id_anak) }}" 
                       class="flex-1 flex justify-center items-center py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg text-sm font-medium transition border border-gray-200">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Detail
                    </a>
                    <a href="{{ route('posyandu.pengukuran.form', ['id_anak' => $anak->id_anak]) }}" 
                       class="flex-1 flex justify-center items-center py-2 bg-[#000878] hover:bg-blue-900 text-white rounded-lg text-sm font-medium transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Ukur
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $anakList->links() }}
    </div>
@endif