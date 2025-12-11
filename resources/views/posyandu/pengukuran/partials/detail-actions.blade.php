<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Aksi</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <button onclick="window.print()" 
                class="flex items-center justify-center px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm font-medium text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak Halaman
            </button>

            <a href="{{ route('posyandu.anak.show', $pengukuran->anak->id_anak) }}" 
                class="flex items-center justify-center px-4 py-2.5 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-sm font-medium text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Lihat Profil Anak
            </a>

            <a href="{{ route('posyandu.pengukuran.form', ['id_anak' => $pengukuran->anak->id_anak]) }}" 
                class="flex items-center justify-center px-4 py-2.5 text-white bg-purple-600 rounded-lg hover:bg-purple-700 transition shadow-sm font-medium text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Ukur Lagi
            </a>
        </div>
    </div>
</div>