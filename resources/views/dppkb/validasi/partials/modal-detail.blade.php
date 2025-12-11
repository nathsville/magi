<div id="modalDetail" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="bg-white rounded-2xl shadow-2xl max-w-6xl w-full transform transition-all" 
            onclick="event.stopPropagation()">
            
            {{-- Header --}}
            <div class="bg-gradient-to-r from-purple-600 to-purple-800 px-6 py-5 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Detail Data Stunting</h3>
                            <p class="text-purple-100 text-sm">Informasi lengkap dan riwayat pengukuran</p>
                        </div>
                    </div>
                    <button onclick="closeModalDetail()" 
                        class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    {{-- Left Column: Anak Info --}}
                    <div class="lg:col-span-1 space-y-4">
                        {{-- Photo --}}
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 text-center">
                            <div class="w-32 h-32 mx-auto bg-purple-200 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-16 h-16 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900" id="detailNamaAnak">-</h4>
                            <p class="text-sm text-gray-600" id="detailNIKAnak">-</p>
                            <div class="mt-3 pt-3 border-t border-purple-200">
                                <div class="flex items-center justify-center space-x-2 text-sm">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-700" id="detailTanggalLahir">-</span>
                                </div>
                                <div class="flex items-center justify-center space-x-2 text-sm mt-2">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-700"><span id="detailUmur">-</span> bulan</span>
                                </div>
                            </div>
                        </div>

                        {{-- Orang Tua Info --}}
                        <div class="bg-white rounded-xl border border-gray-200 p-4">
                            <h5 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Orang Tua
                            </h5>
                            <div class="space-y-2 text-sm">
                                <div>
                                    <span class="text-gray-500">Ayah:</span>
                                    <p class="text-gray-900 font-medium" id="detailNamaAyah">-</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Ibu:</span>
                                    <p class="text-gray-900 font-medium" id="detailNamaIbu">-</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">No. Telepon:</span>
                                    <p class="text-gray-900" id="detailTelepon">-</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Alamat:</span>
                                    <p class="text-gray-900" id="detailAlamat">-</p>
                                </div>
                            </div>
                        </div>

                        {{-- Lokasi Info --}}
                        <div class="bg-white rounded-xl border border-gray-200 p-4">
                            <h5 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Lokasi Pelayanan
                            </h5>
                            <div class="space-y-2 text-sm">
                                <div>
                                    <span class="text-gray-500">Posyandu:</span>
                                    <p class="text-gray-900 font-medium" id="detailPosyandu">-</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Puskesmas:</span>
                                    <p class="text-gray-900 font-medium" id="detailPuskesmas">-</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Kecamatan:</span>
                                    <p class="text-gray-900" id="detailKecamatan">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Status & History --}}
                    <div class="lg:col-span-2 space-y-4">
                        
                        {{-- Status Gizi Card --}}
                        <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
                            <h5 class="text-lg font-bold text-gray-900 mb-4">Status Gizi & Z-Score</h5>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="text-center p-4 bg-blue-50 rounded-lg">
                                    <p class="text-xs text-blue-600 font-medium mb-1">BB/U</p>
                                    <p class="text-2xl font-bold text-blue-900" id="detailBBU">-</p>
                                </div>
                                <div class="text-center p-4 bg-green-50 rounded-lg">
                                    <p class="text-xs text-green-600 font-medium mb-1">TB/U</p>
                                    <p class="text-2xl font-bold text-green-900" id="detailTBU">-</p>
                                </div>
                                <div class="text-center p-4 bg-orange-50 rounded-lg">
                                    <p class="text-xs text-orange-600 font-medium mb-1">BB/TB</p>
                                    <p class="text-2xl font-bold text-orange-900" id="detailBBTB">-</p>
                                </div>
                                <div class="text-center p-4 rounded-lg" id="detailStatusContainer">
                                    <p class="text-xs font-medium mb-1">Status</p>
                                    <p class="text-sm font-bold" id="detailStatus">-</p>
                                </div>
                            </div>
                            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600">
                                    <span class="font-semibold">Catatan:</span>
                                    <span id="detailCatatan">-</span>
                                </p>
                            </div>
                        </div>

                        {{-- Validation History --}}
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <h5 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                                Riwayat Validasi
                            </h5>
                            <div class="space-y-3" id="detailValidationHistory">
                                {{-- Will be populated via JS --}}
                            </div>
                        </div>

                        {{-- Measurement History --}}
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <h5 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Riwayat Pengukuran (5 Terakhir)
                            </h5>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-700">Tanggal</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-700">Umur</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-700">BB (kg)</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-700">TB (cm)</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-700">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200" id="detailMeasurementHistory">
                                        {{-- Will be populated via JS --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer Actions --}}
            <div class="px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <button onclick="closeModalDetail()" 
                        class="px-6 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium">
                        Tutup
                    </button>
                    <div class="flex space-x-3" id="detailActionButtons">
                        {{-- Will be populated based on status --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>