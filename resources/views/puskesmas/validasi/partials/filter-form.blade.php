<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4">
        <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <span>Filter Data Validasi</span>
        </h2>
    </div>

    <form method="GET" action="{{ route('puskesmas.validasi.index') }}" class="p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- Search --}}
            <div class="col-span-1 md:col-span-2 lg:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Nama Anak</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Nama anak..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]">
                </div>
            </div>

            {{-- Posyandu Filter --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Posyandu</label>
                <select name="posyandu" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]">
                    <option value="">Semua Posyandu</option>
                    @foreach($posyanduList as $posyandu)
                        <option value="{{ $posyandu->id_posyandu }}" {{ request('posyandu') == $posyandu->id_posyandu ? 'selected' : '' }}>
                            {{ $posyandu->nama_posyandu }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Date From --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                <input type="date" 
                    name="tanggal_dari" 
                    value="{{ request('tanggal_dari') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]">
            </div>

            {{-- Date To --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                <input type="date" 
                    name="tanggal_sampai" 
                    value="{{ request('tanggal_sampai') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]">
            </div>
        </div>

        {{-- Footer Actions --}}
        <div class="flex flex-col md:flex-row items-center justify-between pt-4 border-t border-gray-200 gap-4">
            <div class="text-sm text-gray-600 flex items-center">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002 2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <span>Menampilkan <span class="font-bold text-gray-900">{{ $pendingData->count() }}</span> dari total <span class="font-bold text-gray-900">{{ $pendingData->total() }}</span> data pending</span>
            </div>
            
            <div class="flex items-center space-x-3 w-full md:w-auto">
                <a href="{{ route('puskesmas.validasi.index') }}" 
                    class="flex-1 md:flex-none justify-center flex items-center px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Reset
                </a>
                <button type="submit" 
                    class="flex-1 md:flex-none justify-center flex items-center px-6 py-2.5 text-white bg-[#000878] rounded-lg hover:bg-blue-900 transition font-medium shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Terapkan Filter
                </button>
            </div>
        </div>
    </form>
</div>