<div class="mt-12">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        <i class="fas fa-book-reader text-purple-600 mr-2"></i>Artikel Terkait
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($relatedArticles as $related)
        <a href="{{ route('orangtua.edukasi.show', $related['slug']) }}" 
           class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-2">
            <div class="h-40 bg-cover bg-center" style="background-image: url('{{ $related['gambar'] }}')"></div>
            <div class="p-4">
                <span class="text-xs font-medium text-purple-600">{{ $related['kategori'] }}</span>
                <h3 class="font-bold text-gray-800 mt-2 mb-2 line-clamp-2">{{ $related['judul'] }}</h3>
                <p class="text-sm text-gray-600 line-clamp-2">{{ $related['ringkasan'] }}</p>
                <div class="mt-3 text-xs text-gray-500">
                    <i class="fas fa-clock mr-1"></i>{{ $related['durasi_baca'] }} menit
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>