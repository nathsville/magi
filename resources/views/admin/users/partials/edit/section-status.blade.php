<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4">
        <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Status Akun</span>
        </h2>
    </div>

    <div class="p-6">
        <label class="block text-sm font-medium text-gray-700 mb-3">
            Status <span class="text-red-500">*</span>
        </label>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Radio Aktif --}}
            <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-[#000878] transition group">
                <input type="radio" 
                    name="status" 
                    value="Aktif" 
                    {{ old('status', $user->status) == 'Aktif' ? 'checked' : '' }}
                    class="sr-only peer" 
                    required>
                <div class="flex items-center space-x-3 flex-1">
                    <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-200 transition peer-checked:bg-green-500">
                        <svg class="w-6 h-6 text-green-600 group-hover:text-green-700 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900">Aktif</div>
                        <div class="text-xs text-gray-600">Pengguna dapat login</div>
                    </div>
                </div>
                <div class="absolute inset-0 border-2 border-[#000878] rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
            </label>

            {{-- Radio Nonaktif --}}
            <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-[#000878] transition group">
                <input type="radio" 
                    name="status" 
                    value="Nonaktif" 
                    {{ old('status', $user->status) == 'Nonaktif' ? 'checked' : '' }}
                    class="sr-only peer">
                <div class="flex items-center space-x-3 flex-1">
                    <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center group-hover:bg-red-200 transition peer-checked:bg-red-500">
                        <svg class="w-6 h-6 text-red-600 group-hover:text-red-700 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900">Nonaktif</div>
                        <div class="text-xs text-gray-600">Akses diblokir</div>
                    </div>
                </div>
                <div class="absolute inset-0 border-2 border-[#000878] rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
            </label>
        </div>
        @error('status')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>