<div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
    <div class="flex items-start space-x-3">
        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="flex-1">
            <h3 class="text-sm font-semibold text-blue-900">Informasi Puskesmas</h3>
            <div class="mt-2 text-sm text-blue-800 space-y-1">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">ID Puskesmas:</span>
                    <code class="bg-blue-100 px-2 py-0.5 rounded font-mono text-xs">{{ $puskesmas->id_puskesmas }}</code>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Dibuat pada:</span>
                    <span class="font-medium">{{ $puskesmas->created_at ? $puskesmas->created_at->format('d M Y, H:i') : 'N/A' }}</span>
                </div>
                @if($puskesmas->posyandu_count > 0)
                <div class="flex items-center justify-between mt-2 pt-2 border-t border-blue-200">
                    <span class="text-gray-600">Posyandu Binaan:</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        {{ $puskesmas->posyandu_count }} Unit
                    </span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>