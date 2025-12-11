<div class="my-8 bg-green-50 rounded-xl p-6 border border-green-100">
    <h3 class="flex items-center text-lg font-bold text-green-900 mb-4">
        <span class="flex items-center justify-center w-8 h-8 bg-green-600 rounded-full mr-3 text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </span>
        Contoh Menu MPASI
    </h3>

    <div class="space-y-3">
        @foreach($menu as $item)
            <div class="bg-white rounded-lg p-3 border border-green-100 shadow-sm flex items-start transition hover:shadow-md">
                <div class="flex-shrink-0 mt-0.5 mr-3 text-green-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-gray-700 text-sm font-medium">{{ $item }}</p>
            </div>
        @endforeach
    </div>
</div>