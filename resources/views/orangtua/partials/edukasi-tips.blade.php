<div class="bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl shadow-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-800">
            <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>Tips Kesehatan
        </h3>
        <a href="{{ route('orangtua.edukasi.index') }}" class="text-purple-600 hover:text-purple-700 text-sm font-medium">
            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>

    <div class="space-y-4">
        @foreach($edukasiTips as $tip)
        <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition">
            <div class="flex items-start space-x-3">
                <div class="text-3xl">{{ $tip['icon'] }}</div>
                <div class="flex-1">
                    <h4 class="font-bold text-gray-800 text-sm mb-1">{{ $tip['title'] }}</h4>
                    <p class="text-gray-600 text-xs leading-relaxed">{{ $tip['description'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4 pt-4 border-t border-purple-200">
        <a href="{{ route('orangtua.edukasi.index') }}" 
           class="block w-full py-2 bg-purple-600 text-white text-center text-sm font-medium rounded-lg hover:bg-purple-700 transition">
            <i class="fas fa-book-open mr-2"></i>Pelajari Lebih Lanjut
        </a>
    </div>
</div>