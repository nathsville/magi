<div class="bg-white rounded-2xl shadow-lg p-6 sticky top-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">
        <i class="fas fa-filter text-purple-600 mr-2"></i>Filter
    </h3>

    <form method="GET" action="{{ route('orangtua.notifikasi.index') }}" id="filterForm">
        {{-- Status Filter --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status Baca</label>
            <select name="status" onchange="document.getElementById('filterForm').submit()" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="">Semua Status</option>
                <option value="Belum Dibaca" {{ request('status') === 'Belum Dibaca' ? 'selected' : '' }}>Belum Dibaca</option>
                <option value="Sudah Dibaca" {{ request('status') === 'Sudah Dibaca' ? 'selected' : '' }}>Sudah Dibaca</option>
            </select>
        </div>

        {{-- Type Filter --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Notifikasi</label>
            <select name="tipe" onchange="document.getElementById('filterForm').submit()" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="">Semua Tipe</option>
                <option value="Validasi" {{ request('tipe') === 'Validasi' ? 'selected' : '' }}>Validasi</option>
                <option value="Peringatan" {{ request('tipe') === 'Peringatan' ? 'selected' : '' }}>Peringatan</option>
                <option value="Informasi" {{ request('tipe') === 'Informasi' ? 'selected' : '' }}>Informasi</option>
            </select>
        </div>

        {{-- Reset Button --}}
        <button type="button" onclick="clearFilters()" 
                class="w-full px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
            <i class="fas fa-redo mr-2"></i>Reset Filter
        </button>
    </form>

    {{-- Quick Stats --}}
    <div class="mt-6 pt-6 border-t border-gray-200">
        <h4 class="text-sm font-medium text-gray-700 mb-3">Ringkasan</h4>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Total:</span>
                <span class="font-bold text-gray-800">{{ $totalNotifikasi }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-purple-600">Belum Dibaca:</span>
                <span class="font-bold text-purple-600">{{ $belumDibaca }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-orange-600">Peringatan:</span>
                <span class="font-bold text-orange-600">{{ $peringatan }}</span>
            </div>
        </div>
    </div>
</div>