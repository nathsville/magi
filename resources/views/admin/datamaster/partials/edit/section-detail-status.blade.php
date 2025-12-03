<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4">
        <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span>Detail & Status</span>
        </h2>
    </div>

    <div class="p-6 space-y-5">
        {{-- Deskripsi --}}
        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                Deskripsi <span class="text-gray-400 text-xs">(Opsional)</span>
            </label>
            <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Tambahkan keterangan detail mengenai data ini..."
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] resize-none">{{ old('deskripsi', $data->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Status Radio Cards --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">
                Status Data <span class="text-red-500">*</span>
            </label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Radio Aktif --}}
                <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-[#000878] transition group">
                    <input type="radio" name="status" value="Aktif" {{ old('status', $data->status) == 'Aktif' ? 'checked' : '' }} class="sr-only peer">
                    <div class="flex items-center space-x-3 flex-1">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-200 transition peer-checked:bg-green-500">
                            <svg class="w-6 h-6 text-green-600 group-hover:text-green-700 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Aktif</div>
                            <div class="text-xs text-gray-600">Data dapat digunakan</div>
                        </div>
                    </div>
                    <div class="absolute inset-0 border-2 border-[#000878] rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                </label>

                {{-- Radio Nonaktif --}}
                <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-[#000878] transition group">
                    <input type="radio" name="status" value="Nonaktif" {{ old('status', $data->status) == 'Nonaktif' ? 'checked' : '' }} class="sr-only peer">
                    <div class="flex items-center space-x-3 flex-1">
                        <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center group-hover:bg-red-200 transition peer-checked:bg-red-500">
                            <svg class="w-6 h-6 text-red-600 group-hover:text-red-700 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Nonaktif</div>
                            <div class="text-xs text-gray-600">Data disembunyikan</div>
                        </div>
                    </div>
                    <div class="absolute inset-0 border-2 border-[#000878] rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                </label>
            </div>
            @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>