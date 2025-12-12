<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        {{-- Search --}}
        <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Notifikasi</label>
            <div class="relative">
                <input type="text" 
                    id="searchNotifikasi"
                    placeholder="Cari judul atau isi pesan..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
        
        {{-- Type Filter --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe</label>
            <select id="filterType" 
                onchange="applyNotifikasiFilter()"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="all">Semua Tipe</option>
                <option value="validasi">Validasi</option>
                <option value="peringatan">Peringatan</option>
                <option value="informasi">Informasi</option>
            </select>
        </div>
        
        {{-- Status Filter --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
            <select id="filterStatus" 
                onchange="applyNotifikasiFilter()"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="all">Semua Status</option>
                <option value="belum_dibaca">Belum Dibaca</option>
                <option value="sudah_dibaca">Sudah Dibaca</option>
            </select>
        </div>
        
        {{-- Actions --}}
        <div class="flex items-end space-x-2">
            <button onclick="resetNotifikasiFilter()" 
                class="flex-1 px-4 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                Reset
            </button>
            <button onclick="applyNotifikasiFilter()" 
                class="flex-1 px-4 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition font-medium shadow-lg">
                Filter
            </button>
        </div>
    </div>
</div>