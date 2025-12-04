<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4">
        <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span>Form Input Data Pengukuran</span>
        </h2>
    </div>
    
    <form id="inputForm" action="{{ route('puskesmas.input.store') }}" method="POST" class="p-6 space-y-8">
        @csrf

        {{-- Alert Info --}}
        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 flex items-start space-x-3">
            <div class="flex-shrink-0 w-5 h-5 mt-0.5 text-blue-600">
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-blue-900">Validasi Otomatis</h4>
                <p class="text-xs text-blue-700 mt-1">
                    Sistem akan otomatis menghitung Z-Score dan status gizi setelah data disimpan. Notifikasi akan dikirim jika terdeteksi stunting.
                </p>
            </div>
        </div>

        {{-- Section 1: Pilih Anak --}}
        <div class="space-y-5">
            <div class="flex items-center space-x-3 border-b border-gray-100 pb-2">
                <span class="w-8 h-8 bg-[#000878] text-white rounded-full flex items-center justify-center text-sm font-bold shadow-sm">1</span>
                <h3 class="text-base font-bold text-gray-900">Data Anak</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Posyandu --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Posyandu <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="id_posyandu" id="id_posyandu" required
                            class="w-full pl-4 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] appearance-none"
                            onchange="filterAnakByPosyandu()">
                            <option value="">Pilih Posyandu</option>
                            @foreach($posyanduList as $posyandu)
                                <option value="{{ $posyandu->id_posyandu }}">{{ $posyandu->nama_posyandu }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Anak --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Anak <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="id_anak" id="id_anak" required
                            class="w-full pl-4 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] appearance-none disabled:bg-gray-100 disabled:text-gray-400"
                            onchange="loadAnakInfo()" disabled>
                            <option value="">Pilih posyandu terlebih dahulu</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info Anak (Hidden initially) --}}
            <div id="anakInfo" class="hidden bg-gray-50 border border-gray-200 rounded-lg p-4 transition-all duration-300">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wide">Jenis Kelamin</p>
                        <p class="font-semibold text-gray-900 mt-1" id="infoJK">-</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wide">Tanggal Lahir</p>
                        <p class="font-semibold text-gray-900 mt-1" id="infoTglLahir">-</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wide">Umur Saat Ini</p>
                        <p class="font-semibold text-gray-900 mt-1" id="infoUmur">-</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wide">Orang Tua</p>
                        <p class="font-semibold text-gray-900 mt-1" id="infoOrangTua">-</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2: Data Pengukuran --}}
        <div class="space-y-5 pt-2">
            <div class="flex items-center space-x-3 border-b border-gray-100 pb-2">
                <span class="w-8 h-8 bg-[#000878] text-white rounded-full flex items-center justify-center text-sm font-bold shadow-sm">2</span>
                <h3 class="text-base font-bold text-gray-900">Pengukuran Antropometri</h3>
            </div>

            {{-- Tanggal Pengukuran --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Pengukuran <span class="text-red-500">*</span>
                </label>
                <input type="date" name="tanggal_ukur" id="tanggal_ukur" required
                    max="{{ date('Y-m-d') }}"
                    value="{{ date('Y-m-d') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Berat Badan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Berat Badan (BB) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative rounded-lg shadow-sm">
                        <input type="number" name="berat_badan" id="berat_badan" required
                            step="0.1" min="1" max="50"
                            placeholder="0.0"
                            class="w-full pl-4 pr-12 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]"
                            oninput="checkOutlier('bb')">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm font-medium">kg</span>
                        </div>
                    </div>
                    <div id="warningBB" class="hidden mt-2 p-2 bg-yellow-50 border border-yellow-200 text-xs text-yellow-800 rounded flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Nilai diluar kewajaran, mohon periksa kembali
                    </div>
                </div>

                {{-- Tinggi Badan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tinggi Badan (TB) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative rounded-lg shadow-sm">
                        <input type="number" name="tinggi_badan" id="tinggi_badan" required
                            step="0.1" min="30" max="150"
                            placeholder="0.0"
                            class="w-full pl-4 pr-12 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]"
                            oninput="checkOutlier('tb')">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm font-medium">cm</span>
                        </div>
                    </div>
                    <div id="warningTB" class="hidden mt-2 p-2 bg-yellow-50 border border-yellow-200 text-xs text-yellow-800 rounded flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Nilai diluar kewajaran, mohon periksa kembali
                    </div>
                </div>

                {{-- Lingkar Kepala --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Lingkar Kepala (LK) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative rounded-lg shadow-sm">
                        <input type="number" name="lingkar_kepala" id="lingkar_kepala" required
                            step="0.1" min="20" max="60"
                            placeholder="0.0"
                            class="w-full pl-4 pr-12 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]"
                            oninput="checkOutlier('lk')">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm font-medium">cm</span>
                        </div>
                    </div>
                    <div id="warningLK" class="hidden mt-2 p-2 bg-yellow-50 border border-yellow-200 text-xs text-yellow-800 rounded flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Nilai diluar kewajaran, mohon periksa kembali
                    </div>
                </div>

                {{-- Lingkar Lengan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Lingkar Lengan (LILA) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative rounded-lg shadow-sm">
                        <input type="number" name="lingkar_lengan" id="lingkar_lengan" required
                            step="0.1" min="5" max="40"
                            placeholder="0.0"
                            class="w-full pl-4 pr-12 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]"
                            oninput="checkOutlier('ll')">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm font-medium">cm</span>
                        </div>
                    </div>
                    <div id="warningLL" class="hidden mt-2 p-2 bg-yellow-50 border border-yellow-200 text-xs text-yellow-800 rounded flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Nilai diluar kewajaran, mohon periksa kembali
                    </div>
                </div>
            </div>

            {{-- Cara Ukur (Hidden) --}}
            <input type="hidden" name="cara_ukur" id="cara_ukur" value="Berdiri">
        </div>

        {{-- Section 3: Catatan --}}
        <div class="space-y-5 pt-2">
            <div class="flex items-center space-x-3 border-b border-gray-100 pb-2">
                <span class="w-8 h-8 bg-[#000878] text-white rounded-full flex items-center justify-center text-sm font-bold shadow-sm">3</span>
                <h3 class="text-base font-bold text-gray-900">Catatan Tambahan</h3>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Keterangan (Opsional)
                </label>
                <textarea name="catatan" id="catatan" rows="3"
                    placeholder="Tuliskan kondisi anak atau catatan khusus lainnya..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] resize-none"></textarea>
            </div>
        </div>

        {{-- Footer Buttons --}}
        <div class="flex flex-col md:flex-row items-center justify-between pt-6 border-t border-gray-200 gap-4">
            <button type="button" onclick="resetForm()" 
                class="w-full md:w-auto px-6 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium">
                Reset Form
            </button>
            
            <button type="submit" id="submitBtn"
                class="w-full md:w-auto flex items-center justify-center px-8 py-2.5 bg-[#000878] text-white rounded-lg hover:bg-blue-900 transition font-medium shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                </svg>
                Simpan Data
            </button>
        </div>
    </form>
</div>

{{-- Hidden Data --}}
<div id="anakData" class="hidden" data-anak='@json($anakList)'></div>