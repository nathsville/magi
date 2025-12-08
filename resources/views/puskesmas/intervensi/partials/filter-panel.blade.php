<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-gradient-to-r from-primary to-blue-600 px-6 py-4">
        <h2 class="text-lg font-bold text-white flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            Filter Data
        </h2>
    </div>

    <form method="GET" action="{{ route('puskesmas.intervensi.index') }}" class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Search --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Cari Nama Anak
                </label>
                <div class="relative">
                    <input type="text" name="search" 
                        value="{{ request('search') }}"
                        placeholder="Ketik nama anak..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            {{-- Jenis Intervensi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jenis Intervensi
                </label>
                <select name="jenis_intervensi" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">Semua Jenis</option>
                    <option value="PMT" {{ request('jenis_intervensi') == 'PMT' ? 'selected' : '' }}>PMT</option>
                    <option value="Suplemen/Vitamin" {{ request('jenis_intervensi') == 'Suplemen/Vitamin' ? 'selected' : '' }}>Suplemen/Vitamin</option>
                    <option value="Edukasi Gizi" {{ request('jenis_intervensi') == 'Edukasi Gizi' ? 'selected' : '' }}>Edukasi Gizi</option>
                    <option value="Rujukan RS" {{ request('jenis_intervensi') == 'Rujukan RS' ? 'selected' : '' }}>Rujukan RS</option>
                    <option value="Konseling" {{ request('jenis_intervensi') == 'Konseling' ? 'selected' : '' }}>Konseling</option>
                    <option value="Lainnya" {{ request('jenis_intervensi') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status Tindak Lanjut
                </label>
                <select name="status" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="Sedang Berjalan" {{ request('status') == 'Sedang Berjalan' ? 'selected' : '' }}>Sedang Berjalan</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Perlu Rujukan Lanjutan" {{ request('status') == 'Perlu Rujukan Lanjutan' ? 'selected' : '' }}>Perlu Rujukan Lanjutan</option>
                </select>
            </div>

            {{-- Periode --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Periode
                </label>
                <input type="month" name="periode" 
                    value="{{ request('periode', date('Y-m')) }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-200">
            <div class="text-sm text-gray-600">
                Menampilkan <span class="font-semibold text-gray-900">{{ $intervensiList->total() }}</span> data
            </div>
            
            <div class="flex items-center space-x-3">
                <a href="{{ route('puskesmas.intervensi.index') }}" 
                    class="px-4 py-2.5 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Reset Filter
                </a>
                
                <button type="submit" 
                    class="flex items-center px-6 py-2.5 text-white bg-primary rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Terapkan Filter
                </button>
            </div>
        </div>
    </form>
</div>