<div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-2xl p-8 my-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        <span class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center text-white mr-3">
            <i class="fas fa-info-circle"></i>
        </span>
        Tahukah Anda?
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($fakta as $fact)
            <div class="bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-check-circle text-orange-500 mt-1"></i>
                    <p class="text-gray-700 text-sm">{{ $fact }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>