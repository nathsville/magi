<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-gradient-to-r from-primary to-blue-600 px-6 py-4">
        <h2 class="text-lg font-bold text-white flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            Filter Laporan
        </h2>
    </div>

    <form method="GET" action="{{ route('puskesmas.laporan.index') }}" class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Jenis Laporan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jenis Laporan
                </label>
                <select name="jenis_laporan" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">Semua Jenis</option>
                    <option value="Laporan Puskesmas" {{ request('jenis_laporan') == 'Laporan Puskesmas' ? 'selected' : '' }}>Laporan Puskesmas</option>
                    <option value="Laporan Daerah" {{ request('jenis_laporan') == 'Laporan Daerah' ? 'selected' : '' }}>Laporan Daerah</option>
                </select>
            </div>

            {{-- Tahun --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tahun
                </label>
                <select name="tahun" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">Semua Tahun</option>
                    @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
            </div>

            {{-- Bulan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Bulan
                </label>
                <select name="bulan" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">Semua Bulan</option>
                    @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $bulan)
                        <option value="{{ $index + 1 }}" {{ request('bulan') == ($index + 1) ? 'selected' : '' }}>{{ $bulan }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Urutan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Urutkan
                </label>
                <select name="order" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Terlama</option>
                </select>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-200">
            <div class="text-sm text-gray-600">
                Menampilkan <span class="font-semibold text-gray-900">{{ $laporanList->total() }}</span> laporan
            </div>
            
            <div class="flex items-center space-x-3">
                <a href="{{ route('puskesmas.laporan.index') }}" 
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