<div id="modalDetailWilayah" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="bg-white rounded-2xl shadow-2xl max-w-5xl w-full transform transition-all" 
            onclick="event.stopPropagation()">
            
            {{-- Header --}}
            <div class="bg-gradient-to-r from-purple-600 to-indigo-700 px-6 py-5 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Detail Wilayah</h3>
                            <p class="text-purple-100 text-sm" id="detailWilayahNama">-</p>
                        </div>
                    </div>
                    <button onclick="closeModalDetailWilayah()" 
                        class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                
                {{-- Quick Stats --}}
                <div class="grid grid-cols-4 gap-4 mb-6">
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <p class="text-xs text-blue-600 font-medium mb-1">Total Anak</p>
                        <p class="text-2xl font-bold text-blue-900" id="detailTotalAnak">-</p>
                    </div>
                    <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                        <p class="text-xs text-red-600 font-medium mb-1">Stunting</p>
                        <p class="text-2xl font-bold text-red-900" id="detailStunting">-</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                        <p class="text-xs text-green-600 font-medium mb-1">Normal</p>
                        <p class="text-2xl font-bold text-green-900" id="detailNormal">-</p>
                    </div>
                    <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                        <p class="text-xs text-orange-600 font-medium mb-1">Prevalensi</p>
                        <p class="text-2xl font-bold text-orange-900" id="detailPrevalensi">-%</p>
                    </div>
                </div>
                
                {{-- Tren Chart --}}
                <div class="mb-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-4">Tren Prevalensi 6 Bulan Terakhir</h4>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200" style="height: 250px;">
                        <canvas id="chartDetailTren"></canvas>
                    </div>
                </div>
                
                {{-- Posyandu List --}}
                <div>
                    <h4 class="text-lg font-bold text-gray-900 mb-4">Daftar Posyandu</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 border-b border-gray-300">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">No</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Nama Posyandu</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700">Total Anak</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700">Stunting</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700">Prevalensi</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700">Status</th>
                                </tr>
                            </thead>
                            <tbody id="detailPosyanduList" class="divide-y divide-gray-200">
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                        Memuat data...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <button onclick="closeModalDetailWilayah()" 
                        class="px-6 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium">
                        Tutup
                    </button>
                    <button onclick="exportDetailWilayah()" 
                        class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition font-medium shadow-lg flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Export Detail</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>