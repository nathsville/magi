<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-bold text-white flex items-center">
            <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
            Tips Kesehatan
        </h3>
    </div>

    <div class="p-5 space-y-4">
        @foreach($edukasiTips as $tip)
        <div class="flex items-start space-x-3 p-3 rounded-lg border border-blue-100 bg-blue-50/50 hover:bg-blue-50 transition">
            <div class="text-2xl flex-shrink-0">{{ $tip['icon'] }}</div>
            <div>
                <h4 class="text-sm font-bold text-gray-800 mb-1">{{ $tip['title'] }}</h4>
                <p class="text-xs text-gray-600 leading-relaxed">{{ $tip['description'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="px-5 py-3 border-t border-gray-200 bg-gray-50">
        <a href="{{ route('orangtua.edukasi.index') }}" 
           class="block w-full py-2 bg-white border border-gray-300 text-gray-700 text-center text-xs font-semibold rounded-lg hover:bg-gray-50 hover:text-[#000878] hover:border-blue-300 transition">
            Baca Artikel Edukasi
        </a>
    </div>
</div>