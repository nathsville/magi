<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <form method="GET" action="{{ route('orangtua.anak.index') }}" id="filterForm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Search --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search mr-2"></i>Cari Nama Anak
                </label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Ketik nama anak..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>

            {{-- Status Filter --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-filter mr-2"></i>Status Gizi
                </label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="Normal" {{ request('status') === 'Normal' ? 'selected' : '' }}>Normal</option>
                    <option value="Stunting" {{ request('status') === 'Stunting' ? 'selected' : '' }}>Perlu Perhatian</option>
                </select>
            </div>

            {{-- Actions --}}
            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 px-6 py-2 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
                <button type="button" onclick="clearFilters()" class="px-6 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
                    <i class="fas fa-redo mr-2"></i>Reset
                </button>
            </div>
        </div>
    </form>
</div>