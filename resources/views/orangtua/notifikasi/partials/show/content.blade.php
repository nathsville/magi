<div class="p-8">
    {{-- Message Content --}}
    <div class="prose max-w-none text-gray-700 leading-relaxed text-base whitespace-pre-wrap font-sans">
        {{ $notifikasi->pesan }}
    </div>

    {{-- Metadata --}}
    <div class="mt-8 pt-6 border-t border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-center text-sm text-gray-500 bg-gray-50 px-4 py-3 rounded-lg">
                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <div class="flex flex-col">
                    <span class="text-xs text-gray-400 uppercase font-semibold">Dikirim Pada</span>
                    <span class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($notifikasi->tanggal_kirim)->format('d F Y, H:i') }}</span>
                </div>
            </div>
            
            <div class="flex items-center text-sm text-gray-500 bg-gray-50 px-4 py-3 rounded-lg">
                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <div class="flex flex-col">
                    <span class="text-xs text-gray-400 uppercase font-semibold">Kategori</span>
                    <span class="font-medium text-gray-700">{{ $notifikasi->tipe_notifikasi }}</span>
                </div>
            </div>
        </div>
    </div>
</div>