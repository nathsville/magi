<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4">
        <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span>Pengguna Teraktif</span>
        </h2>
        <p class="text-blue-100 text-xs mt-1">30 hari terakhir</p>
    </div>

    <div class="p-6 space-y-4">
        @forelse($topUsers as $index => $item)
        <div class="flex items-center space-x-4">
            {{-- Rank Badge (Solid Colors) --}}
            <div class="flex-shrink-0 w-8 h-8 
                @if($index === 0) bg-yellow-400
                @elseif($index === 1) bg-gray-400
                @elseif($index === 2) bg-orange-400
                @else bg-blue-100
                @endif
                rounded-full flex items-center justify-center">
                <span class="text-sm font-bold 
                    @if($index < 3) text-white 
                    @else text-blue-700
                    @endif">
                    {{ $index + 1 }}
                </span>
            </div>

            {{-- User Avatar (Solid Color) --}}
            <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                <span class="text-sm font-semibold text-indigo-700">
                    {{ substr($item->user->nama ?? 'U', 0, 1) }}
                </span>
            </div>

            {{-- User Info --}}
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-900 truncate">
                    {{ $item->user->nama ?? 'Unknown' }}
                </p>
                <p class="text-xs text-gray-600">
                    @{{ $item->user->username ?? 'N/A' }}
                </p>
            </div>

            {{-- Activity Count --}}
            <div class="flex-shrink-0 text-right">
                <p class="text-lg font-bold text-[#000878]">{{ number_format($item->activity_count) }}</p>
                <p class="text-xs text-gray-500">aktivitas</p>
            </div>
        </div>
        @empty
        <div class="text-center py-8">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <p class="text-sm text-gray-600">Belum ada data aktivitas</p>
        </div>
        @endforelse
    </div>
</div>