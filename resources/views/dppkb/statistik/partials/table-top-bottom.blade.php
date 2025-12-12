<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    {{-- Header --}}
    <div class="mb-6">
        <h3 class="text-lg font-bold text-gray-900">Peringkat Posyandu</h3>
        <p class="text-sm text-gray-600 mt-1">5 Posyandu terendah & tertinggi prevalensi</p>
    </div>
    
    {{-- Toggle Buttons --}}
    <div class="flex items-center space-x-2 mb-4">
        <button onclick="showTopBottom('top')" 
            id="btnShowTop"
            class="flex-1 px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg font-medium shadow-sm">
            Terendah (Terbaik)
        </button>
        <button onclick="showTopBottom('bottom')" 
            id="btnShowBottom"
            class="flex-1 px-4 py-2 bg-white text-gray-700 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium">
            Tertinggi (Prioritas)
        </button>
    </div>
    
    {{-- Top 5 Table --}}
    <div id="tableTop" class="overflow-hidden">
        <table class="w-full">
            <thead class="bg-green-50 border-b border-green-200">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-green-900">Rank</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-green-900">Posyandu</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-green-900">Kecamatan</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-green-900">Prevalensi</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-green-900">Total Anak</th>
                </tr>
            </thead>
            <tbody id="tableTopBody" class="divide-y divide-gray-200">
                {{-- Loading --}}
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">
                        Memuat data...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    {{-- Bottom 5 Table --}}
    <div id="tableBottom" class="hidden overflow-hidden">
        <table class="w-full">
            <thead class="bg-red-50 border-b border-red-200">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-red-900">Rank</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-red-900">Posyandu</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-red-900">Kecamatan</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-red-900">Prevalensi</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-red-900">Total Anak</th>
                </tr>
            </thead>
            <tbody id="tableBottomBody" class="divide-y divide-gray-200">
                {{-- Loading --}}
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">
                        Memuat data...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>