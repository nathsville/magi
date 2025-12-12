<div id="modalCompose" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full transform transition-all" 
            onclick="event.stopPropagation()">
            
            {{-- Header --}}
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Buat Notifikasi Baru</h3>
                            <p class="text-blue-100 text-sm">Kirim notifikasi ke pengguna</p>
                        </div>
                    </div>
                    <button onclick="closeModalCompose()" 
                        class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Content --}}
            <form id="formCompose" onsubmit="submitCompose(event)">
                <div class="p-6 max-h-[calc(100vh-250px)] overflow-y-auto">
                    
                    {{-- Notification Type --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Tipe Notifikasi <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="relative flex flex-col items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-purple-500 transition has-[:checked]:border-purple-600 has-[:checked]:bg-purple-50">
                                <input type="radio" 
                                    name="tipe_notifikasi" 
                                    value="validasi" 
                                    class="sr-only" 
                                    required>
                                <svg class="w-8 h-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-semibold text-gray-900">Validasi</span>
                            </label>
                            
                            <label class="relative flex flex-col items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-red-500 transition has-[:checked]:border-red-600 has-[:checked]:bg-red-50">
                                <input type="radio" 
                                    name="tipe_notifikasi" 
                                    value="peringatan" 
                                    class="sr-only">
                                <svg class="w-8 h-8 text-red-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <span class="text-sm font-semibold text-gray-900">Peringatan</span>
                            </label>
                            
                            <label class="relative flex flex-col items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-500 transition has-[:checked]:border-green-600 has-[:checked]:bg-green-50">
                                <input type="radio" 
                                    name="tipe_notifikasi" 
                                    value="informasi" 
                                    class="sr-only">
                                <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-semibold text-gray-900">Informasi</span>
                            </label>
                        </div>
                    </div>
                    
                    {{-- Recipients --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Penerima <span class="text-red-500">*</span>
                        </label>
                        <select name="penerima" 
                            id="composePenerima"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Pilih Penerima</option>
                            <option value="all_orangtua">Semua Orang Tua</option>
                            <option value="all_posyandu">Semua Petugas Posyandu</option>
                            <option value="all_puskesmas">Semua Petugas Puskesmas</option>
                            <option value="specific">Pengguna Spesifik</option>
                        </select>
                    </div>
                    
                    {{-- Specific User (Hidden by default) --}}
                    <div id="specificUserSection" class="hidden mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Pilih Pengguna
                        </label>
                        <select name="id_user_specific" 
                            id="composeUserSpecific"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Pilih pengguna...</option>
                            {{-- Will be populated dynamically --}}
                        </select>
                    </div>
                    
                    {{-- Title --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Judul Notifikasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            name="judul"
                            id="composeJudul"
                            placeholder="Masukkan judul notifikasi..."
                            required
                            maxlength="200"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Maksimal 200 karakter</p>
                    </div>
                    
                    {{-- Message --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Isi Pesan <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="pesan"
                            id="composePesan"
                            rows="5"
                            placeholder="Tulis pesan notifikasi..."
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"></textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            <span id="charCount">0</span> karakter
                        </p>
                    </div>
                    
                    {{-- Link Stunting Data (Optional) --}}
                    <div class="mb-6">
                        <label class="flex items-center p-4 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 transition">
                            <input type="checkbox" 
                                name="link_stunting" 
                                id="composeLinkStunting"
                                class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <span class="ml-3 text-sm text-gray-700">
                                <span class="font-semibold">Kaitkan dengan data stunting</span>
                                <span class="block text-xs text-gray-500 mt-0.5">
                                    Notifikasi akan terhubung dengan data anak tertentu
                                </span>
                            </span>
                        </label>
                    </div>
                    
                    {{-- Stunting Data Select (Hidden by default) --}}
                    <div id="stuntingDataSection" class="hidden mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Pilih Data Stunting
                        </label>
                        <select name="id_stunting" 
                            id="composeStuntingData"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Pilih data stunting...</option>
                            {{-- Will be populated dynamically --}}
                        </select>
                    </div>
                    
                    {{-- Schedule Send (Optional) --}}
                    <div class="mb-6">
                        <label class="flex items-center p-4 bg-blue-50 border border-blue-200 rounded-lg cursor-pointer hover:bg-blue-100 transition">
                            <input type="checkbox" 
                                name="schedule_send" 
                                id="composeSchedule"
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-3 text-sm text-blue-900">
                                <span class="font-semibold">Jadwalkan pengiriman</span>
                                <span class="block text-xs text-blue-700 mt-0.5">
                                    Kirim notifikasi pada waktu tertentu
                                </span>
                            </span>
                        </label>
                    </div>
                    
                    {{-- Schedule DateTime (Hidden by default) --}}
                    <div id="scheduleSection" class="hidden mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Waktu Pengiriman
                        </label>
                        <input type="datetime-local" 
                            name="scheduled_at"
                            id="composeScheduledAt"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    
                    {{-- Preview Box --}}
                    <div class="bg-gradient-to-br from-purple-50 to-blue-50 border-2 border-purple-200 rounded-lg p-4">
                        <div class="flex items-center space-x-2 mb-3">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <span class="text-sm font-semibold text-purple-900">Preview Notifikasi</span>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <p class="text-sm font-bold text-gray-900 mb-1" id="previewJudul">Judul akan muncul di sini</p>
                            <p class="text-xs text-gray-600" id="previewPesan">Isi pesan akan muncul di sini</p>
                        </div>
                    </div>
                </div>

                {{-- Footer Actions --}}
                <div class="px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-200">
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" 
                            onclick="closeModalCompose()"
                            class="px-6 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium">
                            Batal
                        </button>
                        <button type="submit" 
                            class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition font-medium shadow-lg flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            <span>Kirim Notifikasi</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>