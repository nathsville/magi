<div class="p-8">
    {{-- Message Content --}}
    <div class="prose max-w-none">
        <div class="text-gray-800 leading-relaxed text-lg whitespace-pre-wrap">{{ $notifikasi->pesan }}</div>
    </div>

    {{-- Metadata --}}
    <div class="mt-8 pt-6 border-t border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-center text-sm text-gray-600">
                <i class="fas fa-calendar-alt w-6 text-purple-500"></i>
                <span>Dikirim: {{ \Carbon\Carbon::parse($notifikasi->tanggal_kirim)->format('d F Y, H:i') }} WIB</span>
            </div>
            <div class="flex items-center text-sm text-gray-600">
                <i class="fas fa-tag w-6 text-purple-500"></i>
                <span>Kategori: {{ $notifikasi->tipe_notifikasi }}</span>
            </div>
            @if($notifikasi->status_baca === 'Sudah Dibaca')
            <div class="flex items-center text-sm text-gray-600">
                <i class="fas fa-check-double w-6 text-green-500"></i>
                <span>Status: Sudah Dibaca</span>
            </div>
            @endif
        </div>
    </div>
</div>