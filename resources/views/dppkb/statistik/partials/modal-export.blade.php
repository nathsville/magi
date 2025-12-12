<div id="modalExport" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full transform transition-all" 
            onclick="event.stopPropagation()">
            
            {{-- Header --}}
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Export Data Statistik</h3>
                            <p class="text-blue-100 text-sm">Pilih format dan konten export</p>
                        </div>
                    </div>
                    <button onclick="closeModalExport()" 
                        class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Content --}}
            <form id="formExport" onsubmit="submitExport(event)">
                <div class="p-6">
                    
                    {{-- Export Format --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Format Export
                        </label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="relative flex flex-col items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50">
                                <input type="radio" 
                                    name="export_format" 
                                    value="pdf" 
                                    class="sr-only" 
                                    checked>
                                <svg class="w-10 h-10 text-red-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm font-semibold text-gray-900">PDF</span>
                            </label>
                            
                            <label class="relative flex flex-col items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50">
                                <input type="radio" 
                                    name="export_format" 
                                    value="excel" 
                                    class="sr-only">
                                <svg class="w-10 h-10 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path>
                                </svg>
                                <span class="text-sm font-semibold text-gray-900">Excel</span>
                            </label>
                            
                            <label class="relative flex flex-col items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50">
                                <input type="radio" 
                                    name="export_format" 
                                    value="csv" 
                                    class="sr-only">
                                <svg class="w-10 h-10 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-sm font-semibold text-gray-900">CSV</span>
                            </label>
                        </div>
                    </div>
                    
                    {{-- Export Content --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Konten yang Akan Di-export
                        </label>
                        <div class="space-y-2">
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" 
                                    name="export_content[]" 
                                    value="statistik_umum" 
                                    checked
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-3 text-sm text-gray-900 font-medium">Statistik Umum</span>
                            </label>
                            
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" 
                                    name="export_content[]" 
                                    value="tren_prevalensi" 
                                    checked
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-3 text-sm text-gray-900 font-medium">Grafik Tren Prevalensi</span>
                            </label>
                            
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" 
                                    name="export_content[]" 
                                    value="distribusi_usia" 
                                    checked
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-3 text-sm text-gray-900 font-medium">Distribusi per Usia</span>
                            </label>
                            
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" 
                                    name="export_content[]" 
                                    value="perbandingan_wilayah"
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-3 text-sm text-gray-900 font-medium">Perbandingan Wilayah</span>
                            </label>
                            
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" 
                                    name="export_content[]" 
                                    value="ranking_posyandu"
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-3 text-sm text-gray-900 font-medium">Ranking Posyandu</span>
                            </label>
                            
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" 
                                    name="export_content[]" 
                                    value="analisis_lanjutan"
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-3 text-sm text-gray-900 font-medium">Analisis Lanjutan & Prediksi</span>
                            </label>
                        </div>
                    </div>
                    
                    {{-- Include Filter Info --}}
                    <div class="mb-6">
                        <label class="flex items-center p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <input type="checkbox" 
                                name="include_filters" 
                                value="1" 
                                checked
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-3 text-sm text-blue-900">
                                <span class="font-semibold">Sertakan informasi filter</span>
                                <span class="block text-xs text-blue-700 mt-0.5">
                                    Periode, wilayah, dan filter lain yang aktif akan dicantumkan
                                </span>
                            </span>
                        </label>
                    </div>
                    
                    {{-- Info Box --}}
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-start space-x-2">
                            <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm text-yellow-800">
                                Export akan menggunakan data sesuai filter yang sedang aktif
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-200">
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" 
                            onclick="closeModalExport()"
                            class="px-6 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium">
                            Batal
                        </button>
                        <button type="submit" 
                            class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition font-medium shadow-lg flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            <span>Export Sekarang</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>