<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-bold text-white flex items-center">
            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
            </svg>
            Riwayat Intervensi
        </h3>
    </div>

    @if($intervensiList->isEmpty())
        <div class="p-6 text-center text-sm text-gray-500">
            Belum ada data intervensi
        </div>
    @else
        <div class="divide-y divide-gray-100">
            @foreach($intervensiList as $intervensi)
            <div class="p-4 hover:bg-gray-50 transition">
                <div class="flex justify-between items-start mb-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wide
                        {{ $intervensi->jenis_intervensi === 'PMT' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ $intervensi->jenis_intervensi }}
                    </span>
                    <span class="text-xs text-gray-500">
                        {{ \Carbon\Carbon::parse($intervensi->tanggal_pelaksanaan)->format('d M Y') }}
                    </span>
                </div>
                <p class="text-sm text-gray-800 font-medium mb-1 line-clamp-2">
                    {{ $intervensi->deskripsi }}
                </p>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-xs text-gray-500 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        {{ $intervensi->petugas->nama ?? 'Petugas' }}
                    </span>
                    <span class="text-xs font-medium {{ $intervensi->status_tindak_lanjut === 'Selesai' ? 'text-green-600' : 'text-orange-600' }}">
                        {{ $intervensi->status_tindak_lanjut }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>