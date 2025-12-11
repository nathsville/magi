<div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
    <form method="GET" action="{{ route('posyandu.notifikasi') }}" id="filterForm">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Status Filter --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-filter text-teal-600 mr-2"></i>Status Baca
                </label>
                <select name="status" 
                        onchange="document.getElementById('filterForm').submit()"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="Belum Dibaca" {{ request('status') === 'Belum Dibaca' ? 'selected' : '' }}>Belum Dibaca</option>
                    <option value="Sudah Dibaca" {{ request('status') === 'Sudah Dibaca' ? 'selected' : '' }}>Sudah Dibaca</option>
                </select>
            </div>

            {{-- Type Filter --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tag text-teal-600 mr-2"></i>Tipe Notifikasi
                </label>
                <select name="tipe" 
                        onchange="document.getElementById('filterForm').submit()"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Semua Tipe</option>
                    <option value="Validasi" {{ request('tipe') === 'Validasi' ? 'selected' : '' }}>Validasi</option>
                    <option value="Peringatan" {{ request('tipe') === 'Peringatan' ? 'selected' : '' }}>Peringatan</option>
                    <option value="Informasi" {{ request('tipe') === 'Informasi' ? 'selected' : '' }}>Informasi</option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-between mt-4">
            <div class="text-sm text-gray-600">
                <i class="fas fa-bell mr-2"></i>Menampilkan {{ $notifikasiList->count() }} dari {{ $notifikasiList->total() }} notifikasi
            </div>
            <button type="button" onclick="clearFilters()" class="px-6 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-redo mr-2"></i>Reset Filter
            </button>
        </div>
    </form>
</div>