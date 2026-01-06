@php
    $status = $anak->stuntingTerakhir->status_stunting;
    $statusConfig = match($status) {
        'Normal' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-200', 'icon' => 'text-green-600'],
        'Stunting Ringan' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'border' => 'border-yellow-200', 'icon' => 'text-yellow-600'],
        'Stunting Sedang' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-200', 'icon' => 'text-orange-600'],
        'Stunting Berat' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'icon' => 'text-red-600'],
        default => ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'border' => 'border-gray-200', 'icon' => 'text-gray-600']
    };
@endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-900">Status Gizi Terkini</h3>
        <span class="text-xs text-gray-500">
            Per {{ \Carbon\Carbon::parse($anak->pengukuranTerakhir->tanggal_ukur)->translatedFormat('d M Y') }}
        </span>
    </div>

    <div class="p-4 rounded-xl border-2 {{ $statusConfig['bg'] }} {{ $statusConfig['border'] }} mb-6 text-center">
        <p class="text-sm font-medium {{ $statusConfig['text'] }} opacity-80 uppercase tracking-wider">Kesimpulan</p>
        <p class="text-2xl font-black {{ $statusConfig['text'] }} mt-1">{{ $status }}</p>
    </div>

    <div class="grid grid-cols-3 gap-4">
        <div class="p-3 rounded-lg bg-gray-50 border border-gray-100 text-center">
            <p class="text-xs text-gray-500 mb-1">TB / U</p>
            <p class="font-bold text-gray-900 text-lg">{{ number_format($anak->stuntingTerakhir->zscore_tb_u, 2) }}</p>
            <p class="text-[10px] text-gray-400">Z-Score</p>
        </div>
        <div class="p-3 rounded-lg bg-gray-50 border border-gray-100 text-center">
            <p class="text-xs text-gray-500 mb-1">BB / U</p>
            <p class="font-bold text-gray-900 text-lg">{{ number_format($anak->stuntingTerakhir->zscore_bb_u, 2) }}</p>
            <p class="text-[10px] text-gray-400">Z-Score</p>
        </div>
        <div class="p-3 rounded-lg bg-gray-50 border border-gray-100 text-center">
            <p class="text-xs text-gray-500 mb-1">BB / TB</p>
            <p class="font-bold text-gray-900 text-lg">{{ number_format($anak->stuntingTerakhir->zscore_bb_tb, 2) }}</p>
            <p class="text-[10px] text-gray-400">Z-Score</p>
        </div>
    </div>
    
    @if($status !== 'Normal')
    <div class="mt-6 flex items-start p-3 bg-blue-50 rounded-lg border border-blue-100">
        <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="text-sm text-blue-800">
            <p class="font-semibold mb-1">Rekomendasi:</p>
            <ul class="list-disc list-inside text-xs space-y-1">
                <li>Konsultasi ke petugas kesehatan/ahli gizi</li>
                <li>Perbaiki pola makan dan asupan gizi</li>
                <li>Pantau pertumbuhan rutin setiap bulan</li>
            </ul>
        </div>
    </div>
    @endif
</div>