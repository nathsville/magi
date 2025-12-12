<div id="modalDetail" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full transform transition-all" 
            onclick="event.stopPropagation()">
            
            {{-- Header --}}
            <div id="modalDetailHeader" class="bg-gradient-to-r from-purple-600 to-indigo-700 px-6 py-5 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg id="detailIcon" class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Detail Notifikasi</h3>
                            <p class="text-purple-100 text-sm" id="detailType">-</p>
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
            <div class="p-6">
                {{-- Status Badge --}}
                <div class="flex items-center justify-between mb-4">
                    <span id="detailStatusBadge" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold">
                        -
                    </span>
                    <span class="text-sm text-gray-500" id="detailTanggal">-</span>
                </div>
                
                {{-- Title --}}
                <h4 class="text-2xl font-bold text-gray-900 mb-4" id="detailJudul">-</h4>
                
                {{-- Message --}}
                <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-200">
                    <p class="text-gray-700 leading-relaxed" id="detailPesan">-</p>
                </div>
                
                {{-- Meta Info --}}
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <p class="text-xs text-blue-600 font-medium mb-1">Penerima</p>
                        <p class="text-sm font-semibold text-gray-900" id="detailPenerima">-</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                        <p class="text-xs text-green-600 font-medium mb-1">Pengirim</p>
                        <p class="text-sm font-semibold text-gray-900" id="detailPengirim">-</p>
                    </div>
                </div>
                
                {{-- Related Data (if any) --}}
                <div id="detailRelatedData" class="hidden mb-6">
                    <h5 class="text-sm font-semibold text-gray-700 mb-2">Data Terkait</h5>
                    <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-purple-600 text-xs mb-1">Nama Anak</p>
                                <p class="font-semibold text-gray-900" id="detailAnakNama">-</p>
                            </div>
                            <div>
                                <p class="text-purple-600 text-xs mb-1">Status Gizi</p>
                                <p class="font-semibold text-gray-900" id="detailAnakStatus">-</p>
                            </div>
                            <div>
                                <p class="text-purple-600 text-xs mb-1">Posyandu</p>
                                <p class="font-semibold text-gray-900" id="detailPosyandu">-</p>
                            </div>
                            <div>
                                <p class="text-purple-600 text-xs mb-1">Kecamatan</p>
                                <p class="font-semibold text-gray-900" id="detailKecamatan">-</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Actions --}}
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <button onclick="deleteNotifikasi(currentDetailId)" 
                        class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition font-medium flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span>Hapus</span>
                    </button>
                    <div class="flex space-x-3">
                        <button onclick="closeModalDetail()" 
                            class="px-6 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium">
                            Tutup
                        </button>
                        <button id="btnMarkAsRead" onclick="markAsRead(currentDetailId)" 
                            class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition font-medium shadow-lg flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Tandai Dibaca</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>