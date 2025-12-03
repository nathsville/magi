<div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">Sebaran Stunting per Wilayah</h3>
            <p class="text-xs text-gray-500 mt-1">Data per Puskesmas di Kota Parepare</p>
        </div>
        
        <div class="flex items-center space-x-2">
            <div class="relative">
                <button onclick="toggleFilterDropdown()" class="px-3 py-1.5 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 flex items-center space-x-1">
                    <span id="filterText">Hari Ini</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="filterDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                    <a href="#" onclick="setFilter('Hari Ini'); return false;" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-t-lg">Hari Ini</a>
                    <a href="#" onclick="setFilter('Minggu Ini'); return false;" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Minggu Ini</a>
                    <a href="#" onclick="setFilter('Bulan Ini'); return false;" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Bulan Ini</a>
                    <a href="#" onclick="setFilter('Tahun Ini'); return false;" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-b-lg">Tahun Ini</a>
                </div>
            </div>
            <button onclick="toggleWilayahMenu()" class="p-2 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                </svg>
            </button>
        </div>
    </div>

    {{-- Chart Canvas --}}
    <div class="mb-6 bg-gradient-to-br from-blue-50 to-purple-50 rounded-xl p-6" style="min-height: 300px;">
        <canvas id="stuntingChart"></canvas>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left text-xs font-medium text-gray-500 uppercase pb-3">Wilayah</th>
                    <th class="text-left text-xs font-medium text-gray-500 uppercase pb-3">Total Anak</th>
                    <th class="text-left text-xs font-medium text-gray-500 uppercase pb-3">Stunting</th>
                    <th class="text-left text-xs font-medium text-gray-500 uppercase pb-3">Persentase</th>
                    <th class="text-left text-xs font-medium text-gray-500 uppercase pb-3">Status</th>
                    <th class="text-left text-xs font-medium text-gray-500 uppercase pb-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($stuntingPerWilayah ?? [] as $wilayah)
                <tr class="hover:bg-gray-50">
                    <td class="py-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                                <span class="text-white text-xs font-bold">{{ substr($wilayah->nama_puskesmas, 0, 1) }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-900">{{ $wilayah->nama_puskesmas }}</span>
                                <p class="text-xs text-gray-500">{{ $wilayah->kecamatan }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-3">
                        <span class="text-sm text-gray-900 font-medium">{{ $wilayah->total_anak }}</span>
                    </td>
                    <td class="py-3">
                        <span class="text-sm font-bold text-red-600">{{ $wilayah->jumlah_stunting }}</span>
                    </td>
                    <td class="py-3">
                        <div class="flex items-center space-x-2">
                            <div class="flex-1 bg-gray-200 rounded-full h-2 max-w-[100px]">
                                <div class="h-2 rounded-full transition-all
                                    @if($wilayah->persentase > 20) bg-red-500
                                    @elseif($wilayah->persentase > 10) bg-orange-500
                                    @else bg-green-500
                                    @endif" 
                                     style="width: {{ min($wilayah->persentase, 100) }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-700 min-w-[45px]">{{ number_format($wilayah->persentase, 1) }}%</span>
                        </div>
                    </td>
                    <td class="py-3">
                        @if($wilayah->persentase >= 30)
                            <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full font-medium">Kritis</span>
                        @elseif($wilayah->persentase >= 20)
                            <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs rounded-full font-medium">Tinggi</span>
                        @elseif($wilayah->persentase >= 10)
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full font-medium">Sedang</span>
                        @else
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium">Rendah</span>
                        @endif
                    </td>
                    <td class="py-3">
                        <button onclick="showWilayahDetail('{{ $wilayah->id_puskesmas }}')" class="text-primary hover:text-blue-700 text-sm font-medium">Detail</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="text-sm">Belum ada data Puskesmas</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>