<div class="relative h-80 bg-cover bg-center" style="background-image: url('{{ $artikel['gambar'] }}')">
    <div class="absolute inset-0 bg-gradient-to-t from-[#000878]/90 via-[#000878]/40 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
        <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-bold mb-3 border border-white/20">
            {{ $artikel['kategori'] }}
        </span>
        <h1 class="text-3xl md:text-4xl font-bold leading-tight mb-2 shadow-sm">{{ $artikel['judul'] }}</h1>
    </div>
</div>