<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-purple-600 to-purple-800 text-white">
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                        No
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                        Data Anak
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                        Orang Tua
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                        Lokasi
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                        Status Gizi
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                        Validator Puskesmas
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200" id="tableBody">
                {{-- Data will be inserted here via AJAX --}}
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200" id="paginationContainer">
        {{-- Pagination will be inserted here --}}
    </div>
</div>