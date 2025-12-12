<div id="modalShare" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full transform transition-all" 
            onclick="event.stopPropagation()">
            
            {{-- Header --}}
            <div class="bg-gradient-to-r from-green-600 to-green-800 px-6 py-5 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Bagikan Laporan</h3>
                            <p class="text-green-100 text-sm">Kirim ke email atau WhatsApp</p>
                        </div>
                    </div>
                    <button onclick="closeModalShare()" 
                        class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Content --}}
            <form id="formShare" onsubmit="submitShare(event)">
                <input type="hidden" id="shareReportId" name="report_id">
                
                <div class="p-6">
                    {{-- Share Method --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Metode Pengiriman
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-500 transition has-[:checked]:border-green-600 has-[:checked]:bg-green-50">
                                <input type="radio" 
                                    name="share_method" 
                                    value="email" 
                                    class="w-4 h-4 text-green-600 focus:ring-green-500" 
                                    checked>
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-sm font-semibold text-gray-900">Email</span>
                                    </div>
                                </div>
                            </label>

                            <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-500 transition has-[:checked]:border-green-600 has-[:checked]:bg-green-50">
                                <input type="radio" 
                                    name="share_method" 
                                    value="whatsapp" 
                                    class="w-4 h-4 text-green-600 focus:ring-green-500">
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                        </svg>
                                        <span class="text-sm font-semibold text-gray-900">WhatsApp</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Email Input --}}
                    <div id="emailInputSection" class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Alamat Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                            name="email"
                            id="shareEmail"
                            placeholder="contoh@email.com"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">
                            Pisahkan dengan koma untuk mengirim ke beberapa email
                        </p>
                    </div>

                    {{-- WhatsApp Input --}}
                    <div id="whatsappInputSection" class="hidden mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                            name="whatsapp"
                            id="shareWhatsapp"
                            placeholder="08xxxxxxxxxx"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">
                            Format: 08xxxxxxxxxx (tanpa +62 atau spasi)
                        </p>
                    </div>

                    {{-- Message --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Pesan Tambahan (Opsional)
                        </label>
                        <textarea 
                            name="message"
                            id="shareMessage"
                            rows="3"
                            placeholder="Tambahkan pesan singkat..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none"></textarea>
                    </div>

                    {{-- Info Box --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start space-x-2">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm text-blue-800">
                                Laporan akan dikirim sebagai file PDF attachment
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Footer Actions --}}
                <div class="px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-200">
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" 
                            onclick="closeModalShare()"
                            class="px-6 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium">
                            Batal
                        </button>
                        <button type="submit" 
                            class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition font-medium shadow-lg flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            <span>Kirim Sekarang</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>