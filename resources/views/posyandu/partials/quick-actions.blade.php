<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-[#000878]">
        <h3 class="font-bold text-white flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            Aksi Cepat
        </h3>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Input Pengukuran --}}
            <a href="{{ route('posyandu.pengukuran.form') }}" 
               class="group relative p-5 bg-blue-50 rounded-xl border border-blue-100 hover:border-blue-300 hover:shadow-md transition-all duration-300">
                <div class="absolute top-4 right-4 text-blue-300 group-hover:text-blue-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </div>
                <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center text-blue-600 mb-3 shadow-sm group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900">Input Pengukuran</h4>
                <p class="text-xs text-gray-500 mt-1">Catat hasil penimbangan baru</p>
            </a>

            {{-- Registrasi Anak --}}
            <a href="{{ route('posyandu.anak.create') }}" 
               class="group relative p-5 bg-purple-50 rounded-xl border border-purple-100 hover:border-purple-300 hover:shadow-md transition-all duration-300">
                <div class="absolute top-4 right-4 text-purple-300 group-hover:text-purple-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </div>
                <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center text-purple-600 mb-3 shadow-sm group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900">Daftar Anak Baru</h4>
                <p class="text-xs text-gray-500 mt-1">Registrasi data anak</p>
            </a>

            {{-- Lihat Data --}}
            <a href="{{ route('posyandu.anak.index') }}" 
               class="group relative p-5 bg-green-50 rounded-xl border border-green-100 hover:border-green-300 hover:shadow-md transition-all duration-300">
                <div class="absolute top-4 right-4 text-green-300 group-hover:text-green-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </div>
                <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center text-green-600 mb-3 shadow-sm group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002 2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900">Data Anak</h4>
                <p class="text-xs text-gray-500 mt-1">Lihat database anak</p>
            </a>
        </div>
    </div>
</div>