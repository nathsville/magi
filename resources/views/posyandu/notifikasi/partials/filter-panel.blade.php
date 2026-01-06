<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="bg-[#000878] px-6 py-4">
        <h2 class="text-lg font-bold text-white flex items-center">
            <i class="fas fa-filter mr-2"></i>
            Filter Notifikasi
        </h2>
    </div>

    <form method="GET" action="{{ route('posyandu.notifikasi.index') }}" id="filterForm" class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Status Filter --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status Baca
                </label>
                <select name="status" 
                        onchange="document.getElementById('filterForm').submit()"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors">
                    <option value="">Semua Status</option>
                    <option value="Belum Dibaca" {{ request('status') === 'Belum Dibaca' ? 'selected' : '' }}>Belum Dibaca</option>
                    <option value="Sudah Dibaca" {{ request('status') === 'Sudah Dibaca' ? 'selected' : '' }}>Sudah Dibaca</option>
                </select>
            </div>

            {{-- Type Filter --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tipe Notifikasi
                </label>
                <select name="tipe" 
                        onchange="document.getElementById('filterForm').submit()"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors">
                    <option value="">Semua Tipe</option>
                    <option value="Validasi" {{ request('tipe') === 'Validasi' ? 'selected' : '' }}>Validasi</option>
                    <option value="Peringatan" {{ request('tipe') === 'Peringatan' ? 'selected' : '' }}>Peringatan</option>
                    <option value="Informasi" {{ request('tipe') === 'Informasi' ? 'selected' : '' }}>Informasi</option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-200">
            <div class="text-sm text-gray-600">
                Menampilkan <span class="font-bold text-gray-900">{{ $notifikasiList->count() }}</span> dari {{ $notifikasiList->total() }} notifikasi
            </div>
            <button type="button" onclick="clearFilters()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                <i class="fas fa-redo-alt mr-1.5"></i>Reset Filter
            </button>
        </div>
    </form>
</div>