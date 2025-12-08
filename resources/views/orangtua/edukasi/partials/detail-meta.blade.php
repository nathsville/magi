<div class="flex items-center justify-between pb-6 mb-8 border-b border-gray-200">
    <div class="flex items-center space-x-6 text-sm text-gray-600">
        <span class="flex items-center">
            <i class="fas fa-calendar text-purple-600 mr-2"></i>
            {{ \Carbon\Carbon::parse($artikel['tanggal'])->format('d F Y') }}
        </span>
        <span class="flex items-center">
            <i class="fas fa-clock text-purple-600 mr-2"></i>
            {{ $artikel['durasi_baca'] }} menit baca
        </span>
        <span class="flex items-center">
            <i class="fas fa-folder text-purple-600 mr-2"></i>
            {{ $artikel['kategori'] }}
        </span>
    </div>

    {{-- Share Buttons --}}
    <div class="flex items-center space-x-2">
        <button onclick="shareArticle()" class="p-2 text-gray-600 hover:text-purple-600 transition">
            <i class="fas fa-share-alt"></i>
        </button>
        <button onclick="printArticle()" class="p-2 text-gray-600 hover:text-purple-600 transition">
            <i class="fas fa-print"></i>
        </button>
    </div>
</div>