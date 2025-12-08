<div class="bg-gradient-to-br from-green-50 to-teal-50 rounded-2xl p-8 my-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        <span class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white mr-3">
            <i class="fas fa-utensils"></i>
        </span>
        Contoh Menu MPASI
    </h2>

    <div class="space-y-3">
        @foreach($menu as $item)
            <div class="bg-white rounded-lg p-4 shadow-sm flex items-center space-x-3">
                <i class="fas fa-bowl-food text-green-500 text-xl"></i>
                <p class="text-gray-700 font-medium">{{ $item }}</p>
            </div>
        @endforeach
    </div>
</div>