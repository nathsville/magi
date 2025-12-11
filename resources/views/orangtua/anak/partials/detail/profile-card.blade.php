<div class="bg-[#000878] rounded-xl shadow-lg overflow-hidden relative">
    {{-- Decorative Pattern --}}
    <div class="absolute top-0 right-0 p-4 opacity-10 pointer-events-none">
        <svg class="w-64 h-64 text-white" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM4 10a6 6 0 1112 0 6 6 0 01-12 0z" clip-rule="evenodd" />
        </svg>
    </div>

    <div class="p-8 relative z-10 text-white">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            {{-- Avatar & Info --}}
            <div class="flex items-center space-x-6">
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 bg-white/10 rounded-full flex items-center justify-center text-5xl border-4 border-white/20 backdrop-blur-sm shadow-inner">
                        {{ $anak->jenis_kelamin === 'L' ? '👦' : '👧' }}
                    </div>
                </div>

                <div>
                    <h1 class="text-3xl font-bold mb-2 tracking-tight">{{ $anak->nama_anak }}</h1>
                    <div class="flex flex-wrap items-center gap-3 text-blue-100 text-sm">
                        <span class="flex items-center bg-white/10 px-3 py-1 rounded-full border border-white/10">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($anak->jenis_kelamin === 'L')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                @endif
                            </svg>
                            {{ $anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                        <span class="flex items-center bg-white/10 px-3 py-1 rounded-full border border-white/10">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d F Y') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- NIK Badge --}}
            <div class="bg-white/20 px-5 py-3 rounded-lg backdrop-blur-sm border border-white/10 text-right">
                <p class="text-xs text-blue-200 uppercase tracking-wider mb-1 font-medium">Nomor Induk Kependudukan</p>
                <p class="text-xl font-mono font-bold tracking-wide">{{ $anak->nik_anak }}</p>
            </div>
        </div>

        {{-- Detail Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-8 pt-6 border-t border-white/10">
            <div>
                <p class="text-blue-200 text-xs uppercase tracking-wide mb-1 font-medium">Usia Saat Ini</p>
                <p class="text-lg font-bold">{{ floor($umurBulan / 12) }} Thn {{ $umurBulan % 12 }} Bln</p>
            </div>
            <div>
                <p class="text-blue-200 text-xs uppercase tracking-wide mb-1 font-medium">Tempat Lahir</p>
                <p class="text-lg font-semibold">{{ $anak->tempat_lahir ?? '-' }}</p>
            </div>
            <div>
                <p class="text-blue-200 text-xs uppercase tracking-wide mb-1 font-medium">Anak Ke</p>
                <p class="text-lg font-semibold">{{ $anak->anak_ke ?? '-' }}</p>
            </div>
            <div>
                <p class="text-blue-200 text-xs uppercase tracking-wide mb-1 font-medium">Posyandu</p>
                <p class="text-lg font-semibold">{{ $anak->posyandu->nama_posyandu ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>