<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" id="historySection">
    {{-- Table Header --}}
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Riwayat Laporan
            </h3>
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <input type="text" 
                        id="searchHistory"
                        placeholder="Cari laporan..."
                        class="pl-10 pr-4 py-2 text-sm bg-white bg-opacity-20 border border-white border-opacity-30 rounded-lg text-white placeholder-white placeholder-opacity-70 focus:bg-white focus:text-gray-900 focus:placeholder-gray-500 transition">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <select id="filterHistoryPeriode" 
                    onchange="loadLaporanHistory()"
                    class="px-4 py-2 text-sm bg-white bg-opacity-20 border border-white border-opacity-30 rounded-lg text-white focus:bg-white focus:text-gray-900 transition">
                    <option value="semua">Semua Periode</option>
                    <option value="bulan_ini">Bulan Ini</option>
                    <option value="3_bulan">3 Bulan Terakhir</option>
                    <option value="tahun_ini">Tahun Ini</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Table Body --}}
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        No
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Jenis Laporan
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Periode
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Wilayah
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Format
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Dibuat
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200" id="historyTableBody">
                {{-- Loading State --}}
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center">
                        <div class="inline-block animate-spin rounded-full h-10 w-10 border-4 border-indigo-600 border-t-transparent mb-3"></div>
                        <p class="text-gray-600 text-sm">Memuat riwayat laporan...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200" id="historyPagination">
        {{-- Pagination will be inserted here --}}
    </div>
</div>