@php
    $isNormal = $status->status_stunting === 'Normal';
    $bgClass = $isNormal ? 'bg-green-50 border-green-200' : 'bg-orange-50 border-orange-200';
    $textClass = $isNormal ? 'text-green-800' : 'text-orange-800';
    $iconClass = $isNormal ? 'fa-check-circle text-green-600' : 'fa-exclamation-triangle text-orange-600';
@endphp

<div class="mt-6 {{ $bgClass }} border-l-4 border rounded-xl p-6">
    <div class="flex items-start space-x-4">
        <div class="flex-shrink-0">
            <i class="fas {{ $iconClass }} text-3xl"></i>
        </div>
        <div class="flex-1">
            <h3 class="text-xl font-bold {{ $textClass }} mb-2">
                Status Gizi: {{ $status->status_stunting }}
            </h3>
            
            @if($isNormal)
                <p class="text-green-700 mb-3">
                    <i class="fas fa-smile mr-2"></i>
                    Alhamdulillah! Status gizi anak Anda saat ini <strong>Normal</strong>. 
                    Tetap jaga pola makan bergizi dan rutin kontrol ke Posyandu.
                </p>
            @else
                <p class="text-orange-700 mb-3">
                    <i class="fas fa-info-circle mr-2"></i>
                    Anak Anda terindikasi <strong>{{ $status->status_stunting }}</strong>. 
                    Segera konsultasi dengan petugas kesehatan untuk penanganan lebih lanjut.
                </p>
            @endif

            {{-- Z-Scores --}}
            <div class="grid grid-cols-3 gap-4 mt-4">
                <div class="bg-white bg-opacity-50 rounded-lg p-3">
                    <p class="text-xs {{ $textClass }} font-medium mb-1">Z-Score TB/U</p>
                    <p class="text-lg font-bold {{ $textClass }}">{{ number_format($status->zscore_tb_u, 2) }}</p>
                </div>
                <div class="bg-white bg-opacity-50 rounded-lg p-3">
                    <p class="text-xs {{ $textClass }} font-medium mb-1">Z-Score BB/U</p>
                    <p class="text-lg font-bold {{ $textClass }}">{{ number_format($status->zscore_bb_u, 2) }}</p>
                </div>
                <div class="bg-white bg-opacity-50 rounded-lg p-3">
                    <p class="text-xs {{ $textClass }} font-medium mb-1">Z-Score BB/TB</p>
                    <p class="text-lg font-bold {{ $textClass }}">{{ number_format($status->zscore_bb_tb, 2) }}</p>
                </div>
            </div>

            @if(!$isNormal)
                <div class="mt-4 p-3 bg-white rounded-lg">
                    <p class="text-sm font-medium text-gray-800 mb-2">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>Rekomendasi:
                    </p>
                    <ul class="text-sm text-gray-700 space-y-1 ml-6">
                        <li>• Tingkatkan asupan protein hewani (telur, ikan, daging)</li>
                        <li>• Berikan MPASI 4 bintang dengan porsi yang cukup</li>
                        <li>• Rutin kontrol ke Posyandu setiap bulan</li>
                        <li>• Konsultasi dengan petugas kesehatan untuk penanganan khusus</li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>