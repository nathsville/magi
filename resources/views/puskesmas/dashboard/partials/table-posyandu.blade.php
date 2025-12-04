<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-white/10 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white">Data Per Posyandu</h3>
                    <p class="text-xs text-blue-100">Ringkasan status gizi di setiap posyandu</p>
                </div>
            </div>
            <a href="{{ route('puskesmas.monitoring') }}" 
                class="text-xs font-medium text-white bg-white/20 hover:bg-white/30 px-3 py-1.5 rounded-lg transition flex items-center group">
                Lihat Detail
                <svg class="w-3 h-3 ml-1 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nama Posyandu
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Anak Terdaftar
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kasus Stunting
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">
                        Tingkat Stunting
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($dataPosyandu as $posyandu)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center border border-blue-100">
                                <span class="text-blue-700 font-bold text-lg">
                                    {{ substr($posyandu['nama'], 0, 1) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-gray-900">{{ $posyandu['nama'] }}</div>
                                <div class="text-xs text-gray-500">ID: #{{ $posyandu['id'] ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="inline-flex items-center px-3 py-1 bg-gray-100 rounded-full">
                            <span class="text-sm font-semibold text-gray-900">{{ $posyandu['anak_terdaftar'] }}</span>
                            <span class="text-xs text-gray-500 ml-1">Anak</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if($posyandu['kasus_stunting'] > 0)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-sm font-bold bg-red-100 text-red-700 border border-red-200">
                                {{ $posyandu['kasus_stunting'] }} Kasus
                            </span>
                        @else
                            <span class="text-sm text-gray-400 font-medium">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center align-middle">
                        <div class="w-full max-w-[140px] mx-auto">
                            <div class="flex justify-between items-end mb-1">
                                <span class="text-xs font-medium {{ $posyandu['persentase'] < 20 ? 'text-green-600' : 'text-gray-600' }}">
                                    {{ $posyandu['persentase'] }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden shadow-inner">
                                <div class="h-2 rounded-full transition-all duration-500
                                    {{ $posyandu['persentase'] < 20 ? 'bg-green-500' : ($posyandu['persentase'] < 30 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                    style="width: {{ min($posyandu['persentase'], 100) }}%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if($posyandu['persentase'] < 20)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Aman
                            </span>
                        @elseif($posyandu['persentase'] < 30)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Waspada
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Kritikal
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-900">Tidak ada data posyandu</h3>
                            <p class="text-xs text-gray-500 mt-1">Belum ada posyandu yang terdaftar atau aktif.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($dataPosyandu->count() > 0)
    <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 text-center">
        <p class="text-xs text-gray-500">
            Menampilkan data dari <span class="font-bold text-gray-700">{{ $dataPosyandu->count() }}</span> Posyandu Aktif
        </p>
    </div>
    @endif
</div>