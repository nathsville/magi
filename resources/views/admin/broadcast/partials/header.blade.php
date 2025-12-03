<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 flex items-center space-x-3">
            <div class="w-10 h-10 bg-[#000878] rounded-xl flex items-center justify-center shadow-md">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                </svg>
            </div>
            <span>Broadcast Pesan</span>
        </h1>
        <p class="text-sm text-gray-600 mt-1">Kirim notifikasi & edukasi ke Orang Tua via WhatsApp atau Email</p>
    </div>

    <a href="{{ route('admin.broadcast.history') }}" 
        class="flex items-center space-x-2 px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="text-sm font-medium">Riwayat Broadcast</span>
    </a>
</div>