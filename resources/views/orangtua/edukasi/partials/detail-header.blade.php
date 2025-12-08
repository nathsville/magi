<div class="relative h-96 bg-cover bg-center" style="background-image: url('{{ $artikel['gambar'] }}')">
    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
    
    <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
        <div class="max-w-4xl mx-auto">
            {{-- Category Badge --}}
            <div class="flex items-center space-x-3 mb-4">
                <span class="text-5xl">{{ $artikel['icon'] }}</span>
                <span class="px-4 py-2 bg-white bg-opacity-20 rounded-full text-sm font-bold backdrop-blur-sm">
                    {{ $artikel['kategori'] }}
                </span>
            </div>

            {{-- Title --}}
            <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
                {{ $artikel['judul'] }}
            </h1>

            {{-- Summary --}}
            <p class="text-xl text-gray-200 leading-relaxed">
                {{ $artikel['ringkasan'] }}
            </p>
        </div>
    </div>
</div>