<div class="relative rounded-xl overflow-hidden shadow-md group">
    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="h-64 md:h-auto bg-cover bg-center relative" style="background-image: url('{{ $featured['gambar'] }}')">
            <div class="absolute inset-0 bg-[#000878]/40 group-hover:bg-[#000878]/30 transition-colors"></div>
        </div>
        <div class="p-8 bg-[#000878] text-white flex flex-col justify-center">
            <div class="flex items-center space-x-2 mb-3">
                <span class="px-2 py-0.5 bg-yellow-500 text-white text-xs font-bold uppercase rounded">Unggulan</span>
                <span class="px-2 py-0.5 bg-white/20 text-white text-xs font-medium rounded">{{ $featured['kategori'] }}</span>
            </div>
            <h2 class="text-2xl font-bold mb-3">{{ $featured['judul'] }}</h2>
            <p class="text-blue-100 mb-6 line-clamp-3 text-sm leading-relaxed">{{ $featured['ringkasan'] }}</p>
            
            <a href="{{ route('orangtua.edukasi.show', $featured['slug']) }}" 
               class="inline-flex items-center px-5 py-2.5 bg-white text-[#000878] font-bold text-sm rounded-lg hover:bg-blue-50 transition w-fit">
                Baca Selengkapnya
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</div>