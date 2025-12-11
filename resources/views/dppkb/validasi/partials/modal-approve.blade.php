<div id="modalApprove" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full transform transition-all" 
            onclick="event.stopPropagation()">
            
            {{-- Header --}}
            <div class="bg-gradient-to-r from-green-600 to-green-800 px-6 py-5 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center animate-pulse">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Setujui Data Stunting</h3>
                            <p class="text-green-100 text-sm">Validasi final dari DPPKB</p>
                        </div>
                    </div>
                    <button onclick="closeModalApprove()" 
                        class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Content --}}
            <form id="formApprove" onsubmit="submitApprove(event)">
                <input type="hidden" id="approveId" name="id">
                
                <div class="p-6">
                    {{-- Info Card --}}
                    <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4 mb-6">
                        <div class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-green-900 mb-1">Konfirmasi Persetujuan</h4>
                                <p class="text-sm text-green-800">
                                    Anda akan menyetujui data stunting untuk:
                                </p>
                                <div class="mt-3 space-y-1 text-sm text-green-900">
                                    <p><span class="font-semibold">Nama Anak:</span> <span id="approveNamaAnak">-</span></p>
                                    <p><span class="font-semibold">Status:</span> <span id="approveStatus">-</span></p>
                                    <p><span class="font-semibold">Posyandu:</span> <span id="approvePosyandu">-</span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Catatan Validasi --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Catatan Validasi <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="catatan_validasi"
                            id="approveCatatan"
                            rows="4"
                            required
                            placeholder="Tuliskan catatan atau rekomendasi Anda..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none"></textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Catatan ini akan dikirim ke Puskesmas sebagai feedback
                        </p>
                    </div>

                    {{-- Warning Box --}}
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-start space-x-2">
                            <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <p class="text-sm text-yellow-800">
                                <span class="font-semibold">Perhatian:</span> 
                                Setelah disetujui, data tidak dapat diubah kembali. Pastikan data sudah benar.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Footer Actions --}}
                <div class="px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-200">
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" 
                            onclick="closeModalApprove()"
                            class="px-6 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium">
                            Batal
                        </button>
                        <button type="submit" 
                            class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition font-medium shadow-lg flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Setujui Data</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>