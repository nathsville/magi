<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
        </svg>
    </div>
    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Riwayat Broadcast</h3>
    <p class="text-sm text-gray-600 mb-6">Riwayat broadcast yang Anda kirim akan muncul di sini</p>
    <a href="{{ route('admin.broadcast') }}" 
        class="inline-flex items-center space-x-2 px-6 py-3 bg-[#000878] text-white rounded-lg hover:bg-blue-900 transition font-medium shadow-sm hover:shadow-md">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        <span>Kirim Broadcast Pertama</span>
    </a>
</div>