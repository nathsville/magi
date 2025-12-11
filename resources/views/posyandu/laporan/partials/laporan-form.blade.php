<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-6">
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-white flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Buat Laporan Baru
        </h3>
    </div>

    <form method="POST" action="{{ route('posyandu.laporan.generate') }}" id="laporanForm" class="p-6">
        @csrf

        {{-- Bulan --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Pilih Bulan <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <select name="bulan" required
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] appearance-none">
                    @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $m == now()->month ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                    </option>
                    @endfor
                </select>
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Tahun --}}
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Pilih Tahun <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <select name="tahun" required
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] appearance-none">
                    @for($y = now()->year; $y >= 2015; $y--)
                    <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Format --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">Format Laporan</label>
            <div class="space-y-3">
                {{-- View --}}
                <label class="relative flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition group">
                    <input type="radio" name="format" value="view" checked 
                           class="h-4 w-4 text-[#000878] focus:ring-[#000878] border-gray-300">
                    <div class="ml-3 flex items-center">
                        <svg class="w-5 h-5 text-gray-500 mr-2 group-hover:text-[#000878]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <div>
                            <span class="block text-sm font-medium text-gray-900">Lihat di Browser</span>
                        </div>
                    </div>
                </label>

                {{-- PDF --}}
                <label class="relative flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition group">
                    <input type="radio" name="format" value="pdf" 
                           class="h-4 w-4 text-[#000878] focus:ring-[#000878] border-gray-300">
                    <div class="ml-3 flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <span class="block text-sm font-medium text-gray-900">PDF Document</span>
                        </div>
                    </div>
                </label>

                {{-- Excel --}}
                <label class="relative flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition group">
                    <input type="radio" name="format" value="excel" 
                           class="h-4 w-4 text-[#000878] focus:ring-[#000878] border-gray-300">
                    <div class="ml-3 flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <div>
                            <span class="block text-sm font-medium text-gray-900">Excel Spreadsheet</span>
                        </div>
                    </div>
                </label>
            </div>
        </div>

        {{-- Submit Button --}}
        <button type="submit" 
                class="w-full flex justify-center items-center py-2.5 bg-[#000878] text-white font-medium rounded-lg hover:bg-blue-900 transition shadow-md">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Generate Laporan
        </button>
    </form>

    {{-- Info Box --}}
    <div class="px-6 pb-6">
        <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 flex items-start">
            <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-xs text-blue-800 leading-tight">
                Laporan mencakup seluruh data pengukuran, status gizi, dan validasi pada periode yang dipilih.
            </p>
        </div>
    </div>
</div>