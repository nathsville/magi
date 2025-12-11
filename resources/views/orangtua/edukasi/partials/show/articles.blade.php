<div class="mt-8">
    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Artikel Terkait</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($relatedArticles as $related)
        <a href="{{ route('orangtua.edukasi.show', $related['slug']) }}" class="group bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition">
            <div class="h-32 bg-cover bg-center" style="background-image: url('{{ $related['gambar'] }}')"></div>
            <div class="p-4">
                <h4 class="font-bold text-gray-800 text-sm mb-2 line-clamp-2 group-hover:text-[#000878]">{{ $related['judul'] }}</h4>
                <div class="flex items-center text-xs text-gray-500">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $related['durasi_baca'] }} menit
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>