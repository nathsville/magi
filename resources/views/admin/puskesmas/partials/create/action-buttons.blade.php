<div class="flex items-center justify-between bg-gray-50 rounded-xl border border-gray-200 p-6">
    <div class="text-sm text-gray-600">
        <span class="text-red-500">*</span> Field wajib diisi
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('admin.puskesmas') }}" 
            class="px-6 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium">
            Batal
        </a>
        <button type="submit" 
            class="px-6 py-2.5 bg-[#000878] text-white rounded-lg hover:bg-blue-900 transition font-medium flex items-center space-x-2 shadow-md hover:shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Simpan Puskesmas</span>
        </button>
    </div>
</div>