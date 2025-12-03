<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4">
        <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <span>Distribusi Aksi</span>
        </h2>
        <p class="text-green-100 text-xs mt-1">30 hari terakhir</p>
    </div>

    <div class="p-6 space-y-4">
        @php
            $total = $actionStats->sum('count');
            $colors = [
                'CREATE' => ['bg' => 'bg-green-500', 'text' => 'text-green-700', 'light' => 'bg-green-100'],
                'UPDATE' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-700', 'light' => 'bg-blue-100'],
                'DELETE' => ['bg' => 'bg-red-500', 'text' => 'text-red-700', 'light' => 'bg-red-100'],
                'LOGIN' => ['bg' => 'bg-purple-500', 'text' => 'text-purple-700', 'light' => 'bg-purple-100'],
                'LOGOUT' => ['bg' => 'bg-gray-500', 'text' => 'text-gray-700', 'light' => 'bg-gray-100'],
                'VIEW' => ['bg' => 'bg-yellow-500', 'text' => 'text-yellow-700', 'light' => 'bg-yellow-100'],
            ];
            $icons = [
                'CREATE' => 'M12 6v6m0 0v6m0-6h6m-6 0H6',
                'UPDATE' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
                'DELETE' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
                'LOGIN' => 'M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1',
                'LOGOUT' => 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1',
                'VIEW' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
            ];
        @endphp

        @forelse($actionStats as $stat)
        @php
            $percentage = $total > 0 ? ($stat->count / $total) * 100 : 0;
            $color = $colors[$stat->action] ?? ['bg' => 'bg-gray-500', 'text' => 'text-gray-700', 'light' => 'bg-gray-100'];
            $icon = $icons[$stat->action] ?? 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
        @endphp

        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    {{-- Ikon menggunakan warna solid background light --}}
                    <div class="flex-shrink-0 w-8 h-8 {{ $color['light'] }} rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 {{ $color['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">{{ $stat->action }}</p>
                        <p class="text-xs text-gray-600">{{ number_format($stat->count) }} kali</p>
                    </div>
                </div>
                <span class="text-sm font-bold {{ $color['text'] }}">{{ number_format($percentage, 1) }}%</span>
            </div>

            {{-- Progress Bar (Solid Color) --}}
            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                <div class="{{ $color['bg'] }} h-2 rounded-full transition-all duration-500 ease-out" 
                    style="width: {{ $percentage }}%"></div>
            </div>
        </div>
        @empty
        <div class="text-center py-8">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <p class="text-sm text-gray-600">Belum ada statistik</p>
        </div>
        @endforelse
    </div>

    {{-- Total Summary --}}
    @if($actionStats->count() > 0)
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-gray-700">Total Aktivitas</span>
            {{-- MODIFIKASI: Text warna solid blue tua --}}
            <span class="text-lg font-bold text-[#000878]">{{ number_format($total) }}</span>
        </div>
    </div>
    @endif
</div>