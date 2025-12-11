<div class="my-8 bg-orange-50 rounded-xl p-6 border border-orange-100">
    <h3 class="flex items-center text-lg font-bold text-orange-900 mb-4">
        <span class="flex items-center justify-center w-8 h-8 bg-orange-500 rounded-full mr-3 text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </span>
        Tahukah Anda?
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        @foreach($fakta as $fact)
        <div class="bg-white p-3 rounded-lg border border-orange-100 shadow-sm flex items-start">
            <svg class="w-5 h-5 text-orange-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-sm text-gray-700">{{ $fact }}</span>
        </div>
        @endforeach
    </div>
</div>