<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($edukasiContent as $artikel)
    <a href="{{ route('orangtua.edukasi.show', $artikel['slug']) }}" class="group bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col h-full">
        <div class="h-48 bg-cover bg-center relative" style="background-image: url('{{ $artikel['gambar'] }}')">
            <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition"></div>
            <span class="absolute top-3 right-3 px-2.5 py-1 bg-white/90 text-[#000878] text-xs font-bold rounded shadow-sm">
                {{ $artikel['kategori'] }}
            </span>
        </div>
        <div class="p-5 flex-1 flex flex-col">
            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-[#000878] transition">
                {{ $artikel['judul'] }}
            </h3>
            <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-1">
                {{ $artikel['ringkasan'] }}
            </p>
            <div class="flex items-center justify-between text-xs text-gray-500 pt-4 border-t border-gray-100">
                <span class="flex items-center">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $artikel['durasi_baca'] }} menit
                </span>
                <span class="flex items-center">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ \Carbon\Carbon::parse($artikel['tanggal'])->format('d M Y') }}
                </span>
            </div>
        </div>
    </a>
    @empty
    <div class="col-span-full py-12 text-center text-gray-500 bg-white rounded-xl border border-gray-200 border-dashed">
        <p>Artikel tidak ditemukan</p>
    </div>
    @endforelse
</div>