<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    {{-- Preview Header --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Preview & Templates
            </h3>
            <div class="flex items-center space-x-2">
                <button onclick="showTemplateTab('preview')" 
                    id="btnTabPreview"
                    class="px-3 py-1.5 bg-white text-blue-700 text-sm rounded-lg transition font-medium">
                    Preview
                </button>
                <button onclick="showTemplateTab('templates')" 
                    id="btnTabTemplates"
                    class="px-3 py-1.5 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm rounded-lg transition">
                    Templates
                </button>
            </div>
        </div>
    </div>

    {{-- Preview Tab --}}
    <div id="previewTab" class="p-6">
        <div id="previewContent" class="border-2 border-dashed border-gray-300 rounded-xl p-12 text-center min-h-[400px] flex items-center justify-center">
            <div>
                <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-600 font-medium mb-2">Belum Ada Preview</p>
                <p class="text-sm text-gray-500 mb-4">Klik tombol "Preview" untuk melihat tampilan laporan</p>
                <button onclick="previewLaporan()" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    Generate Preview
                </button>
            </div>
        </div>
    </div>

    {{-- Templates Tab --}}
    <div id="templatesTab" class="hidden p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Template 1: Standard --}}
            <div class="border-2 border-gray-200 rounded-xl overflow-hidden hover:border-teal-500 transition cursor-pointer group" 
                onclick="applyTemplate('standard')">
                <div class="aspect-[3/4] bg-gradient-to-br from-gray-100 to-gray-200 p-6 flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-sm text-gray-600 font-medium">Standard Report</p>
                    </div>
                </div>
                <div class="p-4 bg-white">
                    <h4 class="font-bold text-gray-900 mb-1">Template Standard</h4>
                    <p class="text-xs text-gray-600">Format laporan standar dengan grafik dan tabel</p>
                </div>
            </div>

            {{-- Template 2: Executive --}}
            <div class="border-2 border-gray-200 rounded-xl overflow-hidden hover:border-teal-500 transition cursor-pointer group" 
                onclick="applyTemplate('executive')">
                <div class="aspect-[3/4] bg-gradient-to-br from-purple-100 to-purple-200 p-6 flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-16 h-16 text-purple-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <p class="text-sm text-purple-600 font-medium">Executive Summary</p>
                    </div>
                </div>
                <div class="p-4 bg-white">
                    <h4 class="font-bold text-gray-900 mb-1">Template Executive</h4>
                    <p class="text-xs text-gray-600">Ringkasan untuk pimpinan dengan visualisasi menarik</p>
                </div>
            </div>

            {{-- Template 3: Detailed --}}
            <div class="border-2 border-gray-200 rounded-xl overflow-hidden hover:border-teal-500 transition cursor-pointer group" 
                onclick="applyTemplate('detailed')">
                <div class="aspect-[3/4] bg-gradient-to-br from-blue-100 to-blue-200 p-6 flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-16 h-16 text-blue-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-sm text-blue-600 font-medium">Detailed Analysis</p>
                    </div>
                </div>
                <div class="p-4 bg-white">
                    <h4 class="font-bold text-gray-900 mb-1">Template Detail</h4>
                    <p class="text-xs text-gray-600">Laporan lengkap dengan analisis mendalam</p>
                </div>
            </div>

            {{-- Template 4: Comparison --}}
            <div class="border-2 border-gray-200 rounded-xl overflow-hidden hover:border-teal-500 transition cursor-pointer group" 
                onclick="applyTemplate('comparison')">
                <div class="aspect-[3/4] bg-gradient-to-br from-orange-100 to-orange-200 p-6 flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-16 h-16 text-orange-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                        </svg>
                        <p class="text-sm text-orange-600 font-medium">Comparative Report</p>
                    </div>
                </div>
                <div class="p-4 bg-white">
                    <h4 class="font-bold text-gray-900 mb-1">Template Komparasi</h4>
                    <p class="text-xs text-gray-600">Perbandingan data antar periode atau wilayah</p>
                </div>
            </div>
        </div>
    </div>
</div>