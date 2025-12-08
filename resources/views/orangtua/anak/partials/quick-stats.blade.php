<div class="bg-white rounded-2xl shadow-lg p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">
        <i class="fas fa-chart-pie text-purple-600 mr-2"></i>Ringkasan
    </h3>

    <div class="space-y-4">
        {{-- Total Pengukuran --}}
        <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-white"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Pengukuran</p>
                    <p class="text-2xl font-bold text-blue-700">{{ $totalPengukuran }}</p>
                </div>
            </div>
        </div>

        {{-- Status Terakhir --}}
        @if($statusTerakhir)
        <div class="flex items-center justify-between p-4 {{ $statusTerakhir->status_stunting === 'Normal' ? 'bg-green-50' : 'bg-orange-50' }} rounded-lg">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 {{ $statusTerakhir->status_stunting === 'Normal' ? 'bg-green-500' : 'bg-orange-500' }} rounded-full flex items-center justify-center">
                    <i class="fas {{ $statusTerakhir->status_stunting === 'Normal' ? 'fa-check' : 'fa-exclamation' }} text-white"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Status Saat Ini</p>
                    <p class="text-lg font-bold {{ $statusTerakhir->status_stunting === 'Normal' ? 'text-green-700' : 'text-orange-700' }}">
                        {{ $statusTerakhir->status_stunting }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        {{-- Z-Score Summary --}}
        @if($statusTerakhir)
        <div class="p-4 bg-purple-50 rounded-lg">
            <p class="text-sm font-medium text-gray-700 mb-3">Z-Score Terbaru:</p>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-600">TB/U:</span>
                    <span class="text-sm font-bold text-purple-700">{{ number_format($statusTerakhir->zscore_tb_u, 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-600">BB/U:</span>
                    <span class="text-sm font-bold text-purple-700">{{ number_format($statusTerakhir->zscore_bb_u, 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-600">BB/TB:</span>
                    <span class="text-sm font-bold text-purple-700">{{ number_format($statusTerakhir->zscore_bb_tb, 2) }}</span>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>