<div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-8 my-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        <span class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white mr-3">
            <i class="fas fa-lightbulb"></i>
        </span>
        Tips Praktis
    </h2>

    <div class="space-y-4">
        @foreach($tips as $index => $tip)
            <div class="flex items-start space-x-4 bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition">
                <div class="flex-shrink-0">
                    <span class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        {{ $index + 1 }}
                    </span>
                </div>
                <p class="text-gray-700 flex-1">{{ $tip }}</p>
            </div>
        @endforeach
    </div>
</div>