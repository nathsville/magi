@if(empty($edukasiContent))
    <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
        <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Artikel Tidak Ditemukan</h3>
        <p class="text-gray-600 mb-4">Coba gunakan kata kunci lain atau ubah filter kategori</p>
        <button onclick="clearFilters()" class="px-6 py-2 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition">
            <i class="fas fa-redo mr-2"></i>Reset Pencarian
        </button>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($edukasiContent as $artikel)
        <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-2">
            {{-- Image --}}
            <div class="h-48 bg-cover bg-center relative" style="background-image: url('{{ $artikel['gambar'] }}')">
                <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-60"></div>
                <div class="absolute bottom-4 left-4">
                    <span class="text-5xl">{{ $artikel['icon'] }}</span>
                </div>
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 bg-white bg-opacity-90 text-purple-700 text-xs font-bold rounded-full">
                        {{ $artikel['kategori'] }}
                    </span>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 hover:text-purple-600 transition">
                    <a href="{{ route('orangtua.edukasi.show', $artikel['slug']) }}">
                        {{ $artikel['judul'] }}
                    </a>
                </h3>

                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                    {{ $artikel['ringkasan'] }}
                </p>

                {{-- Meta --}}
                <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                    <span><i class="fas fa-clock mr-1"></i>{{ $artikel['durasi_baca'] }} menit</span>
                    <span><i class="fas fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($artikel['tanggal'])->format('d M Y') }}</span>
                </div>

                {{-- Button --}}
                <a href="{{ route('orangtua.edukasi.show', $artikel['slug']) }}" 
                   class="block w-full py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-center font-bold rounded-lg hover:from-purple-700 hover:to-pink-700 transition shadow-lg">
                    Baca Artikel <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </article>
        @endforeach
    </div>
@endif