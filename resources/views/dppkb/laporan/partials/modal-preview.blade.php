<div id="modalPreview" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="bg-white rounded-2xl shadow-2xl max-w-6xl w-full transform transition-all" 
            onclick="event.stopPropagation()">
            
            {{-- Header --}}
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Preview Laporan</h3>
                            <p class="text-blue-100 text-sm" id="previewTitle">-</p>
                        </div>
                    </div>
                    <button onclick="closeModalPreview()" 
                        class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-6 max-h-[calc(100vh-250px)] overflow-y-auto">
                {{-- Preview Container --}}
                <div id="previewContainer" class="border-2 border-gray-200 rounded-xl bg-white shadow-inner">
                    {{-- Mock Laporan Preview --}}
                    <div class="p-8">
                        {{-- Header Laporan --}}
                        <div class="text-center mb-8 pb-6 border-b-2 border-gray-300">
                            <div class="flex items-center justify-center mb-4">
                                <img src="/images/logo-parepare.png" alt="Logo" class="w-16 h-16 mr-4" onerror="this.style.display='none'">
                                <div class="text-left">
                                    <h1 class="text-2xl font-bold text-gray-900">PEMERINTAH KOTA PAREPARE</h1>
                                    <p class="text-sm text-gray-600">Dinas Pengendalian Penduduk dan Keluarga Berencana</p>
                                    <p class="text-xs text-gray-500">Jl. Jenderal Sudirman No. 34, Parepare</p>
                                </div>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900 mt-4" id="previewJudulLaporan">
                                LAPORAN REKAPITULASI DATA STUNTING
                            </h2>
                            <p class="text-sm text-gray-600 mt-2" id="previewPeriodeLaporan">-</p>
                        </div>

                        {{-- Summary Stats --}}
                        <div class="grid grid-cols-4 gap-4 mb-8">
                            <div class="bg-blue-50 rounded-lg p-4 text-center border border-blue-200">
                                <p class="text-xs text-blue-600 font-medium mb-1">Total Anak</p>
                                <p class="text-2xl font-bold text-blue-900" id="previewTotalAnak">-</p>
                            </div>
                            <div class="bg-red-50 rounded-lg p-4 text-center border border-red-200">
                                <p class="text-xs text-red-600 font-medium mb-1">Stunting</p>
                                <p class="text-2xl font-bold text-red-900" id="previewTotalStunting">-</p>
                            </div>
                            <div class="bg-green-50 rounded-lg p-4 text-center border border-green-200">
                                <p class="text-xs text-green-600 font-medium mb-1">Normal</p>
                                <p class="text-2xl font-bold text-green-900" id="previewTotalNormal">-</p>
                            </div>
                            <div class="bg-orange-50 rounded-lg p-4 text-center border border-orange-200">
                                <p class="text-xs text-orange-600 font-medium mb-1">Prevalensi</p>
                                <p class="text-2xl font-bold text-orange-900" id="previewPrevalensi">-%</p>
                            </div>
                        </div>

                        {{-- Chart Placeholder --}}
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Grafik Tren Stunting</h3>
                            <div class="bg-gray-100 rounded-lg h-64 flex items-center justify-center border-2 border-dashed border-gray-300">
                                <p class="text-gray-500 text-sm">Grafik akan ditampilkan di sini</p>
                            </div>
                        </div>

                        {{-- Table Placeholder --}}
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Distribusi per Kecamatan</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm border border-gray-300">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-2 text-left border-b border-gray-300">Kecamatan</th>
                                            <th class="px-4 py-2 text-center border-b border-gray-300">Total Anak</th>
                                            <th class="px-4 py-2 text-center border-b border-gray-300">Stunting</th>
                                            <th class="px-4 py-2 text-center border-b border-gray-300">Prevalensi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="previewTableBody">
                                        <tr>
                                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                                Data akan ditampilkan di sini
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="mt-8 pt-6 border-t-2 border-gray-300 text-sm text-gray-600">
                            <div class="flex justify-between items-end">
                                <div>
                                    <p>Dicetak pada: <span id="previewTanggalCetak">-</span></p>
                                </div>
                                <div class="text-right">
                                    <p class="mb-16">Parepare, <span id="previewTanggalTTD">-</span></p>
                                    <p class="font-bold">Kepala Dinas DPPKB</p>
                                    <p class="mt-1">__________________</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Loading Overlay --}}
                <div id="previewLoadingOverlay" class="hidden absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center rounded-xl">
                    <div class="text-center">
                        <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-blue-600 border-t-transparent mb-3"></div>
                        <p class="text-gray-700 font-medium">Memuat preview...</p>
                    </div>
                </div>
            </div>

            {{-- Footer Actions --}}
            <div class="px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <button onclick="closeModalPreview()" 
                        class="px-6 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium">
                        Tutup
                    </button>
                    <div class="flex space-x-3">
                        <button onclick="downloadFromPreview()" 
                            class="px-6 py-2.5 bg-white border-2 border-teal-600 text-teal-700 rounded-lg hover:bg-teal-50 transition font-medium flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            <span>Download</span>
                        </button>
                        <button onclick="printPreview()" 
                            class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition font-medium flex items-center space-x-2 shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            <span>Print</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>