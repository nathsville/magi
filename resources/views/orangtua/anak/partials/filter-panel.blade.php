<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-bold text-white flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Filter & Pencarian
        </h2>
    </div>

    <form method="GET" action="{{ route('orangtua.anak.index') }}" id="filterForm" class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Search --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Cari Nama Anak
                </label>
                <div class="relative">
                    <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Ketik nama anak..."
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            {{-- Status Filter --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status Gizi
                </label>
                <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]">
                    <option value="">Semua Status</option>
                    <option value="Normal" {{ request('status') === 'Normal' ? 'selected' : '' }}>Normal</option>
                    <option value="Stunting" {{ request('status') === 'Stunting' ? 'selected' : '' }}>Perlu Perhatian</option>
                </select>
            </div>

            {{-- Actions --}}
            <div class="flex items-end space-x-3">
                <button type="button" onclick="clearFilters()" 
                    class="px-4 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">
                    Reset
                </button>
                <button type="submit" 
                    class="flex-1 px-6 py-2.5 bg-[#000878] text-white font-medium rounded-lg hover:bg-blue-900 transition flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari
                </button>
            </div>
        </div>
    </form>
</div>