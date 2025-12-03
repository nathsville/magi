<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
    <form method="GET" action="{{ route('admin.datamaster') }}" id="filterForm" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            
            {{-- Search Input (Mengambil 3 kolom agar lebih lebar) --}}
            <div class="md:col-span-3 relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" 
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                
                <input type="text" 
                    name="search" 
                    id="searchInput"
                    value="{{ $searchValue }}"
                    placeholder="Cari kode, nilai, atau deskripsi..." 
                    autocomplete="off"
                    class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm">
                
                {{-- Clear Button --}}
                <button type="button" id="clearSearch"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 {{ $searchValue ? '' : 'hidden' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                {{-- Loading Spinner --}}
                <div id="loadingSpinner" class="absolute inset-y-0 right-0 flex items-center pr-3 hidden">
                    <svg class="animate-spin h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                {{-- Suggestion Dropdown --}}
                <div id="suggestionDropdown" class="absolute z-50 w-full mt-2 bg-white rounded-lg shadow-lg border border-gray-200 hidden max-h-96 overflow-y-auto">
                    {{-- Suggestions inserted via JS --}}
                </div>
            </div>

            {{-- Filter Tipe Data (Mengambil 1 kolom) --}}
            <div>
                <select name="tipe" id="tipeFilter" onchange="this.form.submit()"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm cursor-pointer hover:bg-gray-50">
                    <option value="">Semua Tipe Data</option>
                    <option value="Kriteria Stunting" {{ $tipeValue == 'Kriteria Stunting' ? 'selected' : '' }}>Kriteria Stunting</option>
                    <option value="Status Gizi" {{ $tipeValue == 'Status Gizi' ? 'selected' : '' }}>Status Gizi</option>
                    <option value="Jenis Laporan" {{ $tipeValue == 'Jenis Laporan' ? 'selected' : '' }}>Jenis Laporan</option>
                    <option value="Tipe Notifikasi" {{ $tipeValue == 'Tipe Notifikasi' ? 'selected' : '' }}>Tipe Notifikasi</option>
                </select>
            </div>
        </div>

        {{-- Action Buttons & Stats --}}
        <div class="flex items-center justify-between pt-2">
            <div class="text-xs text-gray-500 flex flex-col sm:flex-row sm:items-center sm:space-x-4">
                <span>Total: <strong class="text-gray-900">{{ $totalData }}</strong> data</span>
                <span class="hidden sm:inline">•</span>
                <span>Kategori: <strong class="text-gray-900">{{ $totalKategori }}</strong> jenis</span>
            </div>
            
            <div class="flex space-x-2">
                @if($searchValue || $tipeValue)
                    <a href="{{ route('admin.datamaster') }}" 
                        class="px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Reset
                    </a>
                @endif
                
                <button type="submit" 
                    class="px-4 py-2 text-sm text-white bg-primary rounded-lg hover:bg-blue-900 transition flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Terapkan
                </button>
            </div>
        </div>
    </form>
</div>  