<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="bg-[#000878] px-6 py-4">
        <h2 class="text-lg font-semibold text-white flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Filter Data Anak
        </h2>
    </div>

    <div class="p-6">
        <form method="GET" action="{{ route('posyandu.anak.index') }}" id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Search --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Anak</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Nama, NIK, atau Nama Orang Tua..."
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                {{-- Status Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Gizi</label>
                    <select name="status" onchange="document.getElementById('filterForm').submit()"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]">
                        <option value="">Semua Status</option>
                        <option value="Normal" {{ request('status') === 'Normal' ? 'selected' : '' }}>Normal</option>
                        <option value="Stunting" {{ request('status') === 'Stunting' ? 'selected' : '' }}>Stunting</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                <div class="text-sm text-gray-600">
                    Menampilkan <span class="font-bold text-gray-900">{{ $anakList->count() }}</span> dari <span class="font-bold text-gray-900">{{ $anakList->total() }}</span> anak
                </div>
                <div class="flex space-x-2">
                    <button type="submit" class="px-4 py-2 bg-[#000878] text-white text-sm font-medium rounded-lg hover:bg-blue-900 transition">
                        Cari
                    </button>
                    <button type="button" onclick="clearFilters()" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                        Reset
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>