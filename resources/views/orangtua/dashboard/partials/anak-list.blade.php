<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    {{-- Header Solid Blue --}}
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-bold text-white flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            Data Anak Saya
        </h3>
        <a href="{{ route('orangtua.anak.index') }}" class="text-xs font-medium text-white/80 hover:text-white transition flex items-center">
            Lihat Semua
            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>

    @if($anakList->isEmpty())
        <div class="p-8 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <p class="text-gray-500 font-medium">Belum ada data anak</p>
            <p class="text-gray-400 text-xs mt-1">Data akan muncul setelah didaftarkan oleh petugas.</p>
        </div>
    @else
        <div class="divide-y divide-gray-100">
            @foreach($anakList as $anak)
            <div class="p-5 hover:bg-gray-50 transition group">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4">
                        {{-- Avatar --}}
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-xl font-bold text-white shadow-sm
                                {{ $anak->jenis_kelamin === 'L' ? 'bg-blue-600' : 'bg-pink-500' }}">
                                {{ strtoupper(substr($anak->nama_anak, 0, 1)) }}
                            </div>
                        </div>

                        {{-- Details --}}
                        <div>
                            <div class="flex items-center space-x-2 mb-1">
                                <h4 class="text-base font-bold text-gray-900 group-hover:text-[#000878] transition-colors">{{ $anak->nama_anak }}</h4>
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full border
                                    {{ $anak->jenis_kelamin === 'L' ? 'bg-blue-50 text-blue-700 border-blue-100' : 'bg-pink-50 text-pink-700 border-pink-100' }}">
                                    {{ $anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-center text-xs text-gray-500 space-y-1 sm:space-y-0 sm:space-x-3">
                                <span class="flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->age }} tahun ({{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now()) }} bln)
                                </span>
                                <span class="hidden sm:inline text-gray-300">|</span>
                                <span class="flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $anak->posyandu->nama_posyandu ?? 'Posyandu -' }}
                                </span>
                            </div>

                            {{-- Latest Status Badge --}}
                            @if($anak->stuntingTerakhir)
                            <div class="mt-2">
                                @php
                                    $status = $anak->stuntingTerakhir->status_stunting;
                                    $colorClass = $status === 'Normal' ? 'text-green-700 bg-green-50 border-green-200' : 'text-orange-700 bg-orange-50 border-orange-200';
                                    $icon = $status === 'Normal' ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z';
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium border {{ $colorClass }}">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path></svg>
                                    {{ $status }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <a href="{{ route('orangtua.anak.detail', $anak->id_anak) }}" 
                       class="flex items-center px-3 py-1.5 bg-white border border-gray-300 text-gray-700 text-xs font-medium rounded-lg hover:bg-gray-50 hover:text-[#000878] hover:border-blue-300 transition">
                        Detail
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>