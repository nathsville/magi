<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-6">
    <div class="bg-[#000878] px-5 py-3 border-b border-gray-200">
        <h3 class="text-sm font-bold text-white uppercase tracking-wide flex items-center">
            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            Filter
        </h3>
    </div>

    <form method="GET" action="{{ route('orangtua.notifikasi.index') }}" id="filterForm" class="p-5">
        {{-- Status Filter --}}
        <div class="mb-4">
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Status Baca</label>
            <select name="status" onchange="document.getElementById('filterForm').submit()" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] text-sm">
                <option value="">Semua Status</option>
                <option value="Belum Dibaca" {{ request('status') === 'Belum Dibaca' ? 'selected' : '' }}>Belum Dibaca</option>
                <option value="Sudah Dibaca" {{ request('status') === 'Sudah Dibaca' ? 'selected' : '' }}>Sudah Dibaca</option>
            </select>
        </div>

        {{-- Type Filter --}}
        <div class="mb-6">
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Tipe Notifikasi</label>
            <select name="tipe" onchange="document.getElementById('filterForm').submit()" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] text-sm">
                <option value="">Semua Tipe</option>
                <option value="Validasi" {{ request('tipe') === 'Validasi' ? 'selected' : '' }}>Validasi</option>
                <option value="Peringatan" {{ request('tipe') === 'Peringatan' ? 'selected' : '' }}>Peringatan</option>
                <option value="Informasi" {{ request('tipe') === 'Informasi' ? 'selected' : '' }}>Informasi</option>
            </select>
        </div>

        {{-- Reset Button --}}
        <button type="button" onclick="clearFilters()" 
                class="w-full px-4 py-2 bg-[#000878] text-white font-medium rounded-lg hover:bg-blue-900 transition flex items-center justify-center">
            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Reset Filter
        </button>
    </form>

    {{-- Quick Stats --}}
    <div class="px-5 py-4 border-t border-gray-200 bg-gray-50">
        <h4 class="text-xs font-bold text-gray-500 uppercase mb-3">Ringkasan</h4>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Total:</span>
                <span class="font-bold text-gray-900">{{ $totalNotifikasi }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-blue-700">Belum Dibaca:</span>
                <span class="font-bold text-blue-700">{{ $belumDibaca }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-orange-700">Peringatan:</span>
                <span class="font-bold text-orange-700">{{ $peringatan }}</span>
            </div>
        </div>
    </div>
</div>