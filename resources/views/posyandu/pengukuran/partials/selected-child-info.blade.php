<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6">
        <div class="flex items-start justify-between">
            <div class="flex items-start space-x-5">
                <div class="flex-shrink-0 w-16 h-16 rounded-xl flex items-center justify-center text-2xl font-bold text-white shadow-sm
                    {{ $anak->jenis_kelamin === 'L' ? 'bg-gradient-to-br from-blue-500 to-blue-600' : 'bg-gradient-to-br from-pink-500 to-pink-600' }}">
                    {{ substr($anak->nama_anak, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $anak->nama_anak }}</h3>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                            {{ $anak->nik_anak }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border
                            {{ $anak->jenis_kelamin === 'L' ? 'bg-blue-50 text-blue-700 border-blue-100' : 'bg-pink-50 text-pink-700 border-pink-100' }}">
                            {{ $anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                            {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->age }} Tahun
                        </span>
                    </div>
                </div>
            </div>
            <a href="{{ route('posyandu.anak.show', $anak->id_anak) }}" target="_blank"
               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-[#000878] bg-blue-50 rounded-lg hover:bg-blue-100 transition border border-blue-100">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                Detail
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6 pt-6 border-t border-gray-100">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Orang Tua</p>
                <p class="text-sm font-semibold text-gray-900 mt-1">{{ $anak->orangTua->nama_ibu ?? $anak->orangTua->nama_ayah ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">No. Telepon</p>
                <p class="text-sm font-semibold text-gray-900 mt-1">{{ $anak->orangTua->telepon ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>