<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-16">No</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Data Anak</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pengukuran</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Z-Score (TB/U)</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Lokasi</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($dataStunting as $index => $data)
                @php
                    $pengukuran = $data->dataPengukuran;
                    $anak = $pengukuran->anak ?? null;
                    $posyandu = $pengukuran->posyandu ?? null;
                    
                    // --- LOGIKA FORMAT UMUR (Tahun Bulan) ---
                    $umurTotal = $pengukuran->umur_bulan;
                    $thn = floor($umurTotal / 12);
                    $bln = round(fmod($umurTotal, 12));
                    
                    if ($bln == 12) {
                        $thn += 1;
                        $bln = 0;
                    }

                    $textUmur = '';
                    if ($thn > 0) {
                        $textUmur .= $thn . ' Thn ';
                    }
                    if ($bln > 0 || $thn == 0) {
                        $textUmur .= $bln . ' Bln';
                    }
                    // ----------------------------------------

                    $format = function($val) {
                        return (float)$val == (int)$val ? (int)$val : number_format($val, 1);
                    };
                @endphp

                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out group">
                    {{-- No --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 align-top">
                        {{ $dataStunting->firstItem() + $index }}
                    </td>

                    {{-- Data Anak --}}
                    <td class="px-6 py-4 align-top">
                        <div class="flex items-start space-x-3">
                            {{-- Avatar: Biru Solid (Tanpa Gradien) --}}
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-sm
                                    {{ $anak ? 'bg-blue-600' : 'bg-gray-200 text-gray-400' }}">
                                    {{ $anak ? strtoupper(substr($anak->nama_anak, 0, 2)) : '?' }}
                                </div>
                            </div>
                            
                            {{-- Info Text --}}
                            <div>
                                <div class="text-sm font-bold {{ $anak ? 'text-gray-900' : 'text-gray-400 italic' }}">
                                    {{ $anak->nama_anak ?? 'Data Anak Terhapus' }}
                                </div>
                                <div class="flex flex-col gap-1 mt-1">
                                    @if($anak)
                                        <span class="inline-flex w-fit items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                            {{ $anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </span>
                                        
                                        {{-- Umur --}}
                                        <span class="inline-flex items-center text-xs text-gray-500 font-medium mt-0.5">
                                            <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $textUmur }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-red-50 text-red-600 border border-red-100">
                                            Data Invalid
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- Pengukuran --}}
                    <td class="px-6 py-4 align-top">
                        <div class="grid grid-cols-[24px_1fr] gap-y-1 text-sm w-32">
                            <span class="text-xs font-bold text-gray-400 uppercase">BB</span>
                            <span class="font-medium text-gray-900 text-right">{{ $format($pengukuran->berat_badan) }} <span class="text-gray-400 text-xs font-normal">kg</span></span>
                            
                            <span class="text-xs font-bold text-gray-400 uppercase">TB</span>
                            <span class="font-medium text-gray-900 text-right">{{ $format($pengukuran->tinggi_badan) }} <span class="text-gray-400 text-xs font-normal">cm</span></span>
                            
                            <span class="text-xs font-bold text-gray-400 uppercase">LK</span>
                            <span class="font-medium text-gray-900 text-right">{{ $format($pengukuran->lingkar_kepala) }} <span class="text-gray-400 text-xs font-normal">cm</span></span>
                        </div>
                    </td>

                    {{-- Z-Score & Status --}}
                    <td class="px-6 py-4 whitespace-nowrap align-top">
                        <div class="flex flex-col items-start space-y-2">
                            <div class="flex items-center space-x-2">
                                <span class="text-xs text-gray-500">TB/U:</span>
                                <span class="text-sm font-bold {{ $data->zscore_tb_u < -2 ? 'text-red-600' : 'text-emerald-600' }}">
                                    {{ number_format($data->zscore_tb_u, 2) }}
                                </span>
                            </div>
                            
                            @php
                                $statusStyles = match($data->status_stunting) {
                                    'Normal' => 'bg-emerald-50 text-emerald-700 border-emerald-100 ring-emerald-600/20',
                                    'Stunting Ringan' => 'bg-yellow-50 text-yellow-700 border-yellow-100 ring-yellow-600/20',
                                    'Stunting Sedang' => 'bg-orange-50 text-orange-700 border-orange-100 ring-orange-600/20',
                                    'Stunting Berat' => 'bg-red-50 text-red-700 border-red-100 ring-red-600/20',
                                    default => 'bg-gray-50 text-gray-600 border-gray-100 ring-gray-500/10'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium border ring-1 ring-inset {{ $statusStyles }}">
                                {{ $data->status_stunting }}
                            </span>
                        </div>
                    </td>

                    {{-- Lokasi / Posyandu --}}
                    <td class="px-6 py-4 align-top">
                        <div class="text-sm">
                            <div class="font-bold text-gray-900">{{ $posyandu->nama_posyandu ?? '-' }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ $posyandu->kelurahan ?? 'Lokasi tdk diketahui' }}</div>
                        </div>
                    </td>

                    {{-- Tanggal --}}
                    <td class="px-6 py-4 whitespace-nowrap align-top">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-900">
                                {{ $pengukuran->tanggal_ukur ? \Carbon\Carbon::parse($pengukuran->tanggal_ukur)->format('d M Y') : '-' }}
                            </span>
                            <span class="text-xs text-gray-500 mt-0.5">
                                {{ $pengukuran->tanggal_ukur ? \Carbon\Carbon::parse($pengukuran->tanggal_ukur)->diffForHumans() : '' }}
                            </span>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium align-top">
                        <a href="{{ route('puskesmas.validasi.detail', $data->id_stunting) }}" 
                            class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-2 transition duration-150 inline-flex items-center shadow-sm">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500 bg-gray-50">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-base font-medium text-gray-900">Tidak ada data ditemukan</p>
                            <p class="text-sm mt-1">Coba sesuaikan filter pencarian Anda.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($dataStunting->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        {{ $dataStunting->links() }}
    </div>
    @endif
</div>