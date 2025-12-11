<div class="my-8 bg-blue-50 rounded-xl p-6 border border-blue-100">
    <h3 class="flex items-center text-lg font-bold text-blue-900 mb-4">
        <span class="flex items-center justify-center w-8 h-8 bg-blue-600 rounded-full mr-3 text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
        </span>
        Tips Praktis
    </h3>
    <ul class="space-y-3">
        @foreach($tips as $tip)
        <li class="flex items-start text-blue-800 text-sm">
            <svg class="w-5 h-5 mr-2 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ $tip }}
        </li>
        @endforeach
    </ul>
</div>