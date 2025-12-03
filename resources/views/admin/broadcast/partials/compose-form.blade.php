<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4">
        <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
            </svg>
            <span>Compose Broadcast</span>
        </h2>
    </div>

    <form action="{{ route('admin.broadcast.send') }}" method="POST" id="broadcastForm" class="p-6 space-y-5">
        @csrf

        {{-- Judul Pesan --}}
        <div>
            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                Judul Pesan <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                </div>
                <input type="text" 
                    name="judul" 
                    id="judul"
                    placeholder="Contoh: Tips Mencegah Stunting pada Balita"
                    maxlength="200"
                    required
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] @error('judul') border-red-500 @enderror">
            </div>
            <div class="flex justify-between items-center mt-1">
                @error('judul')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @else
                    <p class="text-xs text-gray-500">Judul akan muncul sebagai header notifikasi</p>
                @enderror
                <p class="text-xs text-gray-500">
                    <span id="judulCount">0</span>/200
                </p>
            </div>
        </div>

        {{-- Pesan/Konten --}}
        <div>
            <label for="pesan" class="block text-sm font-medium text-gray-700 mb-2">
                Isi Pesan <span class="text-red-500">*</span>
            </label>
            <textarea 
                name="pesan" 
                id="pesan"
                rows="8"
                placeholder="Tulis pesan edukasi atau informasi untuk orang tua di sini...&#10;&#10;Contoh:&#10;Halo Ayah/Ibu yang terhormat,&#10;&#10;Kami ingin berbagi tips penting untuk mencegah stunting pada balita Anda:&#10;1. Berikan ASI eksklusif selama 6 bulan&#10;2. Tambahkan MPASI yang bergizi seimbang&#10;3. Rutin kontrol ke Posyandu&#10;&#10;Mari kita jaga tumbuh kembang anak bersama!&#10;&#10;Salam,&#10;Tim MaGi - DPPKB Kota Parepare"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] resize-none @error('pesan') border-red-500 @enderror"></textarea>
            <div class="flex justify-between items-center mt-1">
                @error('pesan')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @else
                    <p class="text-xs text-gray-500">Tulis pesan yang jelas dan informatif</p>
                @enderror
                <p class="text-xs text-gray-500">
                    <span id="pesanCount">0</span> karakter
                </p>
            </div>
        </div>

        {{-- Target Audience --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">
                Target Penerima <span class="text-red-500">*</span>
            </label>
            <div class="space-y-3">
                {{-- Semua Orang Tua --}}
                <label class="relative flex items-start p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-[#000878] transition group">
                    <input type="radio" 
                        name="target_audience" 
                        value="all" 
                        checked
                        class="sr-only peer" 
                        required>
                    <div class="flex items-start space-x-3 flex-1">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition peer-checked:bg-blue-500 mt-0.5">
                            <svg class="w-5 h-5 text-blue-600 group-hover:text-blue-700 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">Semua Orang Tua</div>
                            <div class="text-sm text-gray-600 mt-1">Kirim ke seluruh orang tua yang terdaftar aktif</div>
                        </div>
                    </div>
                    <div class="absolute inset-0 border-2 border-[#000878] rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                </label>

                {{-- Orang Tua dengan Anak Stunting --}}
                <label class="relative flex items-start p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-[#000878] transition group">
                    <input type="radio" 
                        name="target_audience" 
                        value="with_stunting" 
                        class="sr-only peer">
                    <div class="flex items-start space-x-3 flex-1">
                        <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center group-hover:bg-red-200 transition peer-checked:bg-red-500 mt-0.5">
                            <svg class="w-5 h-5 text-red-600 group-hover:text-red-700 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">Orang Tua dengan Anak Terindikasi Stunting</div>
                            <div class="text-sm text-gray-600 mt-1">Kirim khusus ke orang tua yang anaknya terindikasi stunting (ringan, sedang, berat)</div>
                        </div>
                    </div>
                    <div class="absolute inset-0 border-2 border-[#000878] rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                </label>

                {{-- Orang Tua dengan Anak Normal --}}
                <label class="relative flex items-start p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-[#000878] transition group">
                    <input type="radio" 
                        name="target_audience" 
                        value="without_stunting" 
                        class="sr-only peer">
                    <div class="flex items-start space-x-3 flex-1">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-200 transition peer-checked:bg-green-500 mt-0.5">
                            <svg class="w-5 h-5 text-green-600 group-hover:text-green-700 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">Orang Tua dengan Anak Status Gizi Normal</div>
                            <div class="text-sm text-gray-600 mt-1">Kirim khusus ke orang tua yang anaknya berstatus gizi normal (edukasi preventif)</div>
                        </div>
                    </div>
                    <div class="absolute inset-0 border-2 border-[#000878] rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                </label>
            </div>
            @error('target_audience')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tipe Pengiriman --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">
                Channel Pengiriman <span class="text-red-500">*</span>
            </label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                {{-- WhatsApp --}}
                <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-[#000878] transition group">
                    <input type="radio" 
                        name="tipe_pengiriman" 
                        value="whatsapp" 
                        checked
                        class="sr-only peer" 
                        required>
                    <div class="flex items-center space-x-3 flex-1">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-200 transition peer-checked:bg-green-500">
                            <svg class="w-5 h-5 text-green-600 group-hover:text-green-700 peer-checked:text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-900">WhatsApp</div>
                            <div class="text-xs text-gray-600">Cepat & Real-time</div>
                        </div>
                    </div>
                    <div class="absolute inset-0 border-2 border-[#000878] rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                </label>

                {{-- Email --}}
                <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-[#000878] transition group">
                    <input type="radio" 
                        name="tipe_pengiriman" 
                        value="email" 
                        class="sr-only peer">
                    <div class="flex items-center space-x-3 flex-1">
                        <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center group-hover:bg-purple-200 transition peer-checked:bg-purple-500">
                            <svg class="w-5 h-5 text-purple-600 group-hover:text-purple-700 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-900">Email</div>
                            <div class="text-xs text-gray-600">Formal & Detail</div>
                        </div>
                    </div>
                    <div class="absolute inset-0 border-2 border-[#000878] rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                </label>

                {{-- Both --}}
                <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-[#000878] transition group">
                    <input type="radio" 
                        name="tipe_pengiriman" 
                        value="both" 
                        class="sr-only peer">
                    <div class="flex items-center space-x-3 flex-1">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition peer-checked:bg-blue-500">
                            <svg class="w-5 h-5 text-blue-600 group-hover:text-blue-700 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-900">Keduanya</div>
                            <div class="text-xs text-gray-600">WA + Email</div>
                        </div>
                    </div>
                    <div class="absolute inset-0 border-2 border-[#000878] rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                </label>
            </div>
            @error('tipe_pengiriman')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
            <button type="button" 
                onclick="previewBroadcast()"
                class="flex items-center space-x-2 px-5 py-2.5 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span>Preview</span>
            </button>

            <button type="submit" 
                class="flex items-center space-x-2 px-6 py-2.5 bg-[#000878] text-white rounded-lg hover:bg-blue-900 transition font-medium shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
                <span>Kirim Broadcast</span>
            </button>
        </div>
    </form>
</div>