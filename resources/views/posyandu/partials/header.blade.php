<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    {{-- Identity --}}
    <div class="flex items-center space-x-4">
        <div class="w-12 h-12 bg-[#000878] rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
            {{-- Icon slot or default --}}
            @if(isset($icon))
                <div class="text-white w-6 h-6">{!! $icon !!}</div>
            @else
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            @endif
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $title ?? 'Posyandu Dashboard' }}</h1>
            <p class="text-sm text-gray-600 mt-1">{{ $subtitle ?? 'Sistem Monitoring Stunting Terintegrasi' }}</p>
        </div>
    </div>
    
    {{-- Actions Slot --}}
    <div class="flex items-center space-x-3">
        {{ $slot ?? '' }}
        
        {{-- Default Refresh Button if no slot --}}
        @if(!isset($slot))
        <button onclick="location.reload()" 
            class="flex items-center px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm">
            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            <span class="font-medium text-sm">Refresh</span>
        </button>
        @endif
    </div>
</div>