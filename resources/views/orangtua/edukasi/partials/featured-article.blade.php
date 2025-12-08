<div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl shadow-2xl overflow-hidden mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2">
        {{-- Image --}}
        <div class="h-64 md:h-auto bg-cover bg-center" 
             style="background-image: url('{{ $featured['gambar'] }}')">
            <div class="w-full h-full bg-gradient-to-r from-purple-900 to-transparent opacity-60"></div>
        </div>

        {{-- Content --}}
        <div class="p-8 text-white">
            <div class="flex items-center space-x-2 mb-4">
                <span class="px-3 py-1 bg-white bg-opacity-20 rounded-full text-sm font-medium backdrop-blur-sm">
                    <i class="fas fa-star mr-1"></i>Artikel Unggulan
                </span>
                <span class="px-3 py-1 bg-white bg-opacity-20 rounded-full text-sm font-medium backdrop-blur-sm">
                    {{ $featured['kategori'] }}
                </span>
            </div>

            <h2 class="text-3xl font-bold mb-4">{{ $featured['judul'] }}</h2>
            <p class="text-lg text-purple-100 mb-6 leading-relaxed">{{ $featured['ringkasan'] }}</p>

            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4 text-sm text-purple-200">
                    <span><i class="fas fa-clock mr-2"></i>{{ $featured['durasi_baca'] }} menit</span>
                    <span><i class="fas fa-calendar mr-2"></i>{{ \Carbon\Carbon::parse($featured['tanggal'])->format('d M Y') }}</span>
                </div>
                <a href="{{ route('orangtua.edukasi.show', $featured['slug']) }}" 
                   class="px-6 py-3 bg-white text-purple-600 font-bold rounded-lg hover:bg-purple-50 transition shadow-lg">
                    Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>