<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <svg class="w-5 h-5 text-[#000878] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
            </svg>
            Sebaran Stunting Per Kecamatan
        </h3>
        <p class="text-sm text-gray-600 mt-1">Distribusi kasus stunting di 4 kecamatan Kota Parepare</p>
    </div>

    <div class="p-6">
        <div class="space-y-4">
            @foreach($sebaranKecamatan as $item)
                @php
                    $color = $item->persentase >= 20 ? 'red' : ($item->persentase >= 14 ? 'orange' : 'green');
                    $bgColor = $color === 'red' ? 'bg-red-500' : ($color === 'orange' ? 'bg-orange-500' : 'bg-green-500');
                @endphp
                
                <div class="group hover:bg-gray-50 p-4 rounded-lg transition cursor-pointer" 
                     onclick="showKecamatanDetail('{{ $item->kecamatan }}')">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-50 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#000878]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Kec. {{ $item->kecamatan }}</h4>
                                <p class="text-xs text-gray-500">
                                    {{ number_format($item->total_stunting) }} dari {{ number_format($item->total_anak) }} anak
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold {{ $color === 'red' ? 'text-red-600' : ($color === 'orange' ? 'text-orange-600' : 'text-green-600') }}">
                                {{ number_format($item->persentase, 1) }}%
                            </p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $color === 'red' ? 'bg-red-100 text-red-800' : ($color === 'orange' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800') }}">
                                {{ $color === 'red' ? 'Zona Merah' : ($color === 'orange' ? 'Zona Kuning' : 'Zona Hijau') }}
                            </span>
                        </div>
                    </div>
                    
                    {{-- Progress Bar --}}
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                        <div class="{{ $bgColor }} h-2 rounded-full transition-all duration-500" 
                             style="width: {{ min($item->persentase, 100) }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4 text-xs">
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                    <span class="text-gray-600">< 14% (Zona Hijau)</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 bg-orange-500 rounded-full"></span>
                    <span class="text-gray-600">14-20% (Zona Kuning)</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                    <span class="text-gray-600">> 20% (Zona Merah)</span>
                </div>
            </div>
            <a href="{{ route('dppkb.monitoring') }}" 
                class="text-sm font-medium text-[#000878] hover:text-blue-900 flex items-center group">
                <span>Lihat Peta</span>
                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showKecamatanDetail(kecamatan) {
    window.location.href = `{{ route('dppkb.monitoring.wilayah', ':kecamatan') }}`.replace(':kecamatan', kecamatan);
}
</script>
@endpush