<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <span>Data Pengukuran Antropometri</span>
        </h2>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            {{-- Berat Badan --}}
            <div class="text-center p-4 rounded-xl border border-blue-100 bg-blue-50/50">
                <div class="w-12 h-12 mx-auto bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                    </svg>
                </div>
                <p class="text-xs text-gray-500 font-medium uppercase">Berat Badan</p>
                <div class="flex items-baseline justify-center mt-1">
                    <span class="text-2xl font-bold text-gray-900">{{ number_format($dataStunting->dataPengukuran->berat_badan, 1) }}</span>
                    <span class="text-xs text-gray-500 ml-1">kg</span>
                </div>
            </div>
            
            {{-- Tinggi Badan --}}
            <div class="text-center p-4 rounded-xl border border-green-100 bg-green-50/50">
                <div class="w-12 h-12 mx-auto bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                </div>
                <p class="text-xs text-gray-500 font-medium uppercase">Tinggi Badan</p>
                <div class="flex items-baseline justify-center mt-1">
                    <span class="text-2xl font-bold text-gray-900">{{ number_format($dataStunting->dataPengukuran->tinggi_badan, 1) }}</span>
                    <span class="text-xs text-gray-500 ml-1">cm</span>
                </div>
            </div>
            
            {{-- Lingkar Kepala --}}
            <div class="text-center p-4 rounded-xl border border-yellow-100 bg-yellow-50/50">
                <div class="w-12 h-12 mx-auto bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <p class="text-xs text-gray-500 font-medium uppercase">Lingkar Kepala</p>
                <div class="flex items-baseline justify-center mt-1">
                    <span class="text-2xl font-bold text-gray-900">{{ number_format($dataStunting->dataPengukuran->lingkar_kepala, 1) }}</span>
                    <span class="text-xs text-gray-500 ml-1">cm</span>
                </div>
            </div>
            
            {{-- Lingkar Lengan --}}
            <div class="text-center p-4 rounded-xl border border-red-100 bg-red-50/50">
                <div class="w-12 h-12 mx-auto bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <p class="text-xs text-gray-500 font-medium uppercase">Lingkar Lengan</p>
                <div class="flex items-baseline justify-center mt-1">
                    <span class="text-2xl font-bold text-gray-900">{{ number_format($dataStunting->dataPengukuran->lingkar_lengan, 1) }}</span>
                    <span class="text-xs text-gray-500 ml-1">cm</span>
                </div>
            </div>
        </div>
        
        <div class="mt-6 pt-6 border-t border-gray-100 grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-500 uppercase">Tanggal Pengukuran</p>
                <p class="text-sm font-semibold text-gray-900 mt-1">
                    {{ \Carbon\Carbon::parse($dataStunting->dataPengukuran->tanggal_ukur)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Petugas Input</p>
                <p class="text-sm font-semibold text-gray-900 mt-1">{{ $dataStunting->dataPengukuran->petugas->nama ?? '-' }}</p>
            </div>
        </div>
        
        @if($dataStunting->dataPengukuran->catatan)
        <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
            <p class="text-xs font-bold text-gray-600 mb-1">Catatan Petugas:</p>
            <p class="text-sm text-gray-700 italic">"{{ $dataStunting->dataPengukuran->catatan }}"</p>
        </div>
        @endif
    </div>
</div>