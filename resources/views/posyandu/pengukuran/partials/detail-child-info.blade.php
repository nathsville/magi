<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span>Data Anak</span>
        </h2>
    </div>

    <div class="p-6">
        <div class="flex flex-col items-center text-center mb-6">
            <div class="w-20 h-20 rounded-full flex items-center justify-center text-3xl font-bold text-white mb-3 shadow-sm
                {{ $pengukuran->anak->jenis_kelamin === 'L' ? 'bg-gradient-to-br from-blue-500 to-blue-600' : 'bg-gradient-to-br from-pink-500 to-pink-600' }}">
                {{ substr($pengukuran->anak->nama_anak, 0, 1) }}
            </div>
            <h3 class="text-lg font-bold text-gray-900">{{ $pengukuran->anak->nama_anak }}</h3>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-1
                {{ $pengukuran->anak->jenis_kelamin === 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                {{ $pengukuran->anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
            </span>
        </div>

        <div class="space-y-3 border-t border-gray-100 pt-4">
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-500">NIK</span>
                <span class="font-mono font-medium text-gray-900 bg-gray-50 px-2 py-0.5 rounded">{{ $pengukuran->anak->nik_anak }}</span>
            </div>
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-500">Tanggal Lahir</span>
                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($pengukuran->anak->tanggal_lahir)->locale('id')->isoFormat('D MMMM Y') }}</span>
            </div>
            <div class="flex justify-between items-start text-sm">
                <span class="text-gray-500">Orang Tua</span>
                <span class="font-medium text-gray-900 text-right">{{ $pengukuran->anak->orangTua->nama_ibu ?? $pengukuran->anak->orangTua->nama_ayah ?? '-' }}</span>
            </div>
        </div>
    </div>
</div>