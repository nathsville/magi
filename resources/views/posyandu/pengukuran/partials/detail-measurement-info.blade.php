<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide flex items-center">
            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Info Pengukuran
        </h3>
    </div>

    <div class="p-5 space-y-4">
        <div class="flex justify-between items-center text-sm border-b border-gray-50 pb-2">
            <span class="text-gray-500">Tanggal Ukur</span>
            <span class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($pengukuran->tanggal_ukur)->format('d F Y') }}</span>
        </div>

        <div class="flex justify-between items-center text-sm border-b border-gray-50 pb-2">
            <span class="text-gray-500">Umur Saat Ukur</span>
            <span class="font-semibold text-gray-900">{{ $pengukuran->umur_bulan }} bulan</span>
        </div>

        <div class="flex justify-between items-center text-sm border-b border-gray-50 pb-2">
            <span class="text-gray-500">Cara Ukur</span>
            <span class="font-semibold text-gray-900">{{ $pengukuran->cara_ukur ?? '-' }}</span>
        </div>

        <div class="flex justify-between items-center text-sm border-b border-gray-50 pb-2">
            <span class="text-gray-500">Petugas</span>
            <span class="font-semibold text-gray-900">{{ $pengukuran->petugas->nama ?? '-' }}</span>
        </div>

        <div class="flex justify-between items-center text-sm">
            <span class="text-gray-500">Posyandu</span>
            <span class="font-semibold text-gray-900">{{ $pengukuran->posyandu->nama_posyandu ?? '-' }}</span>
        </div>
    </div>
</div>