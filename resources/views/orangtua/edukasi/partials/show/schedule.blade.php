<div class="my-8 bg-purple-50 rounded-xl p-6 border border-purple-100">
    <h3 class="flex items-center text-lg font-bold text-purple-900 mb-4">
        <span class="flex items-center justify-center w-8 h-8 bg-purple-600 rounded-full mr-3 text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </span>
        Jadwal Imunisasi
    </h3>

    <div class="space-y-3">
        @foreach($jadwal as $item)
            <div class="bg-white rounded-lg p-3 border border-purple-100 shadow-sm flex items-start transition hover:shadow-md">
                <div class="flex-shrink-0 mt-0.5 mr-3 text-purple-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-gray-700 text-sm font-medium">{{ $item }}</p>
            </div>
        @endforeach
    </div>
</div>