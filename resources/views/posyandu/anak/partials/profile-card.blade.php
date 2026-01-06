<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] p-6 text-center">
        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-4xl mx-auto mb-3 ring-4 ring-white/20">
            {{ $anak->jenis_kelamin === 'L' ? '👦' : '👧' }}
        </div>
        <h2 class="text-xl font-bold text-white">{{ $anak->nama_anak }}</h2>
        <span class="inline-block mt-2 px-3 py-1 bg-white/20 text-white rounded-full text-xs font-medium">
            {{ $anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
        </span>
    </div>

    <div class="p-6 space-y-4">
        <div class="flex items-center justify-between py-2 border-b border-gray-100">
            <span class="text-sm text-gray-500">NIK</span>
            <span class="text-sm font-medium text-gray-900 font-mono">{{ $anak->nik_anak }}</span>
        </div>
        <div class="flex items-center justify-between py-2 border-b border-gray-100">
            <span class="text-sm text-gray-500">Usia</span>
            <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->age }} Thn ({{ round(\Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now()) % 12) }} Bln)</span>
        </div>
        <div class="flex items-center justify-between py-2 border-b border-gray-100">
            <span class="text-sm text-gray-500">Tgl Lahir</span>
            <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->translatedFormat('d F Y') }}</span>
        </div>
        <div class="flex items-center justify-between py-2 border-b border-gray-100">
            <span class="text-sm text-gray-500">Tempat Lahir</span>
            <span class="text-sm font-medium text-gray-900">{{ $anak->tempat_lahir }}</span>
        </div>
        
        <div class="pt-2">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Orang Tua</p>
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900">{{ $anak->orangTua->nama_ayah ?? $anak->orangTua->nama_ibu ?? '-' }}</p>
                    <p class="text-xs text-gray-500">{{ $anak->orangTua->telepon ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>