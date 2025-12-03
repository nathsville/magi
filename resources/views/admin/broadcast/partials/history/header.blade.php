<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 flex items-center space-x-3">
            <div class="w-10 h-10 bg-[#000878] rounded-xl flex items-center justify-center shadow-sm">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span>Riwayat Broadcast</span>
        </h1>
        <p class="text-sm text-gray-600 mt-1">Histori semua broadcast yang telah dikirim</p>
    </div>

    <a href="{{ route('admin.broadcast') }}" 
        class="flex items-center space-x-2 px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span class="text-sm font-medium">Kembali</span>
    </a>
</div>