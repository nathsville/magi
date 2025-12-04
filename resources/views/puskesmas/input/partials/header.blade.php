<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    {{-- Title & Identity --}}
    <div class="flex items-center space-x-4">
        <div class="w-12 h-12 bg-[#000878] rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
            {{-- Icon: Pencil/Input --}}
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Input Data Pengukuran</h1>
            <p class="text-sm text-gray-600 mt-1">
                Input data pengukuran antropometri dengan validasi otomatis
            </p>
        </div>
    </div>
    
    {{-- Action Buttons --}}
    <div class="flex items-center space-x-3">
        {{-- Info/Guide Button --}}
        <button onclick="showInputGuide()" 
            class="group flex items-center px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition shadow-sm">
            <svg class="w-4 h-4 mr-2 text-gray-500 group-hover:text-[#000878] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium text-sm">Panduan Input</span>
        </button>

        {{-- History Button --}}
        <a href="{{ route('puskesmas.monitoring') }}" 
            class="flex items-center px-5 py-2.5 text-white bg-[#000878] rounded-lg hover:bg-blue-900 transition shadow-md hover:shadow-lg">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium text-sm">Riwayat Data</span>
        </a>
    </div>
</div>