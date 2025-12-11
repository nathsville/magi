<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" id="generateFormCard">
    {{-- Form Header --}}
    <div class="bg-gradient-to-r from-teal-600 to-teal-700 px-6 py-4">
        <h3 class="text-lg font-bold text-white flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Form Generate Laporan
        </h3>
    </div>

    {{-- Form Body --}}
    <form id="formGenerateLaporan" onsubmit="submitGenerateLaporan(event)" class="p-6">
        {{-- Jenis Laporan --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Jenis Laporan <span class="text-red-500">*</span>
            </label>
            <div class="grid grid-cols-1 gap-3">
                <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-teal-500 transition has-[:checked]:border-teal-600 has-[:checked]:bg-teal-50">
                    <input type="radio" 
                        name="jenis_laporan" 
                        value="Laporan Bulanan" 
                        class="w-5 h-5 text-teal-600 focus:ring-teal-500" 
                        checked
                        onchange="updateFormByType()">
                    <div class="ml-3 flex-1">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-900">Laporan Bulanan</span>
                            <svg class="w-5 h-5 text-teal-600 hidden has-[:checked]:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">Rekapitulasi data per bulan</p>
                    </div>
                </label>
                
                <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-teal-500 transition has-[:checked]:border-teal-600 has-[:checked]:bg-teal-50">
                    <input type="radio" 
                        name="jenis_laporan" 
                        value="Laporan Tahunan" 
                        class="w-5 h-5 text-teal-600 focus:ring-teal-500"
                        onchange="updateFormByType()">
                    <div class="ml-3 flex-1">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-900">Laporan Tahunan</span>
                            <svg class="w-5 h-5 text-teal-600 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">Rekapitulasi data per tahun</p>
                    </div>
                </label>

                <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-teal-500 transition has-[:checked]:border-teal-600 has-[:checked]:bg-teal-50">
                    <input type="radio" 
                        name="jenis_laporan" 
                        value="Laporan Custom" 
                        class="w-5 h-5 text-teal-600 focus:ring-teal-500"
                        onchange="updateFormByType()">
                    <div class="ml-3 flex-1">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-900">Laporan Custom</span>
                            <svg class="w-5 h-5 text-teal-600 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">Tentukan periode khusus</p>
                    </div>
                </label>
            </div>
        </div>

        {{-- Periode Bulanan --}}
        <div id="periodeBulanan" class="space-y-4 mb-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Bulan <span class="text-red-500">*</span>
                    </label>
                    <select name="bulan" 
                        id="inputBulan"
                        required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        @foreach(range(1, 12) as $month)
                            <option value="{{ $month }}" {{ $month == now()->month ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($month)->isoFormat('MMMM') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tahun <span class="text-red-500">*</span>
                    </label>
                    <select name="tahun" 
                        id="inputTahun"
                        required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        @foreach(range(now()->year - 2, now()->year) as $year)
                            <option value="{{ $year }}" {{ $year == now()->year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Periode Tahunan (Hidden by default) --}}
        <div id="periodeTahunan" class="hidden mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Tahun <span class="text-red-500">*</span>
            </label>
            <select name="tahun_tahunan" 
                id="inputTahunTahunan"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                @foreach(range(now()->year - 2, now()->year) as $year)
                    <option value="{{ $year }}" {{ $year == now()->year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Periode Custom (Hidden by default) --}}
        <div id="periodeCustom" class="hidden space-y-4 mb-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Tanggal Mulai <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                    name="tanggal_mulai"
                    id="inputTanggalMulai"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Tanggal Selesai <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                    name="tanggal_selesai"
                    id="inputTanggalSelesai"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            </div>
        </div>

        {{-- Wilayah --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Wilayah
            </label>
            <select name="kecamatan" 
                id="inputKecamatan"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                <option value="">Seluruh Kota Parepare</option>
                <option value="Bacukiki">Kecamatan Bacukiki</option>
                <option value="Bacukiki Barat">Kecamatan Bacukiki Barat</option>
                <option value="Ujung">Kecamatan Ujung</option>
                <option value="Soreang">Kecamatan Soreang</option>
            </select>
        </div>

        {{-- Format Output --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Format Output
            </label>
            <div class="flex items-center space-x-4">
                <label class="flex items-center cursor-pointer">
                    <input type="radio" 
                        name="format" 
                        value="pdf" 
                        class="w-4 h-4 text-teal-600 focus:ring-teal-500" 
                        checked>
                    <span class="ml-2 text-sm text-gray-700 font-medium">PDF</span>
                </label>
                <label class="flex items-center cursor-pointer">
                    <input type="radio" 
                        name="format" 
                        value="excel" 
                        class="w-4 h-4 text-teal-600 focus:ring-teal-500">
                    <span class="ml-2 text-sm text-gray-700 font-medium">Excel</span>
                </label>
            </div>
        </div>

        {{-- Include Options --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Konten Laporan
            </label>
            <div class="space-y-2">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" 
                        name="include_grafik" 
                        value="1" 
                        class="w-4 h-4 text-teal-600 focus:ring-teal-500 rounded" 
                        checked>
                    <span class="ml-2 text-sm text-gray-700">Grafik & Visualisasi</span>
                </label>
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" 
                        name="include_tabel" 
                        value="1" 
                        class="w-4 h-4 text-teal-600 focus:ring-teal-500 rounded" 
                        checked>
                    <span class="ml-2 text-sm text-gray-700">Tabel Detail</span>
                </label>
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" 
                        name="include_rekomendasi" 
                        value="1" 
                        class="w-4 h-4 text-teal-600 focus:ring-teal-500 rounded">
                    <span class="ml-2 text-sm text-gray-700">Rekomendasi & Analisis</span>
                </label>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="flex items-center space-x-3">
            <button type="submit" 
                class="flex-1 px-6 py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white rounded-lg hover:from-teal-700 hover:to-teal-800 transition font-semibold shadow-lg flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <span>Generate Laporan</span>
            </button>
            <button type="button" 
                onclick="previewLaporan()"
                class="px-6 py-3 bg-white border-2 border-teal-600 text-teal-700 rounded-lg hover:bg-teal-50 transition font-semibold flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span>Preview</span>
            </button>
        </div>
    </form>
</div>