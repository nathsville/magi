<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    {{-- Header --}}
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002 2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <span>Form Input Pengukuran</span>
        </h2>
    </div>

    <form method="POST" action="{{ route('posyandu.pengukuran.store') }}" id="measurementForm" class="p-6">
        @csrf
        <input type="hidden" name="id_anak" value="{{ $anak->id_anak }}">

        @if(session('warning') && session('outlier_data'))
        <input type="hidden" name="confirm_outlier" value="1">
        <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        {{ session('warning') }}
                        Klik tombol <strong>"Konfirmasi Simpan"</strong> jika data sudah benar.
                    </p>
                </div>
            </div>
        </div>
        @endif

        <div class="space-y-6">
            {{-- Tanggal Ukur --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Pengukuran <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       name="tanggal_ukur" 
                       value="{{ old('tanggal_ukur', session('outlier_data.tanggal_ukur', now()->format('Y-m-d'))) }}"
                       max="{{ now()->format('Y-m-d') }}"
                       required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors shadow-sm">
            </div>

            {{-- Grid: BB & TB --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Berat Badan (kg) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative rounded-lg shadow-sm">
                        <input type="number" 
                               name="berat_badan" 
                               value="{{ old('berat_badan', session('outlier_data.berat_badan')) }}"
                               step="0.1" min="1" max="50" required
                               placeholder="0.0"
                               class="w-full pl-4 pr-12 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">kg</span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tinggi Badan (cm) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative rounded-lg shadow-sm">
                        <input type="number" 
                               name="tinggi_badan" 
                               value="{{ old('tinggi_badan', session('outlier_data.tinggi_badan')) }}"
                               step="0.1" min="30" max="150" required
                               placeholder="0.0"
                               class="w-full pl-4 pr-12 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">cm</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grid: LK & LL --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Lingkar Kepala (cm) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative rounded-lg shadow-sm">
                        <input type="number" 
                               name="lingkar_kepala" 
                               value="{{ old('lingkar_kepala', session('outlier_data.lingkar_kepala')) }}"
                               step="0.1" min="20" max="70" required
                               placeholder="0.0"
                               class="w-full pl-4 pr-12 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">cm</span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Lingkar Lengan (cm) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative rounded-lg shadow-sm">
                        <input type="number" 
                               name="lingkar_lengan" 
                               value="{{ old('lingkar_lengan', session('outlier_data.lingkar_lengan')) }}"
                               step="0.1" min="5" max="40" required
                               placeholder="0.0"
                               class="w-full pl-4 pr-12 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878]">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">cm</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cara Ukur --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Cara Ukur <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="relative flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition-all
                        {{ old('cara_ukur', session('outlier_data.cara_ukur')) === 'Terlentang' ? 'border-[#000878] bg-blue-50 ring-1 ring-[#000878]' : 'border-gray-300' }}">
                        <input type="radio" name="cara_ukur" value="Terlentang" 
                               {{ old('cara_ukur', session('outlier_data.cara_ukur')) === 'Terlentang' ? 'checked' : '' }}
                               class="h-4 w-4 text-[#000878] focus:ring-[#000878] border-gray-300" required>
                        <div class="ml-3">
                            <span class="block text-sm font-medium text-gray-900">Terlentang</span>
                            <span class="block text-xs text-gray-500">Posisi Berbaring (Anak < 2 th)</span>
                        </div>
                    </label>
                    
                    <label class="relative flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition-all
                        {{ old('cara_ukur', session('outlier_data.cara_ukur')) === 'Berdiri' ? 'border-[#000878] bg-blue-50 ring-1 ring-[#000878]' : 'border-gray-300' }}">
                        <input type="radio" name="cara_ukur" value="Berdiri" 
                               {{ old('cara_ukur', session('outlier_data.cara_ukur')) === 'Berdiri' ? 'checked' : '' }}
                               class="h-4 w-4 text-[#000878] focus:ring-[#000878] border-gray-300" required>
                        <div class="ml-3">
                            <span class="block text-sm font-medium text-gray-900">Berdiri</span>
                            <span class="block text-xs text-gray-500">Posisi Tegak (Anak ≥ 2 th)</span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Catatan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Tambahan</label>
                <textarea name="catatan" rows="3" maxlength="500"
                          placeholder="Kondisi anak saat diukur, atau keterangan lainnya..."
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] resize-none">{{ old('catatan', session('outlier_data.catatan')) }}</textarea>
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-end space-x-3 mt-8 pt-6 border-t border-gray-100">
            <a href="{{ route('posyandu.dashboard') }}" class="px-6 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 font-medium transition shadow-sm">
                Batal
            </a>
            <button type="submit" class="px-8 py-2.5 bg-[#000878] text-white rounded-lg hover:bg-blue-900 font-medium shadow-md hover:shadow-lg transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                </svg>
                {{ session('warning') ? 'Konfirmasi Simpan' : 'Simpan Data' }}
            </button>
        </div>
    </form>
</div>