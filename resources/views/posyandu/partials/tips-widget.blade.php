<div class="bg-[#000878] rounded-xl shadow-lg p-6 text-white relative overflow-hidden">
    {{-- Background Pattern --}}
    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
    <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-20 h-20 bg-blue-500/20 rounded-full blur-xl"></div>

    <div class="relative z-10">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-lg flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                Tips Hari Ini
            </h3>
        </div>

        @php
            $tips = [
                [
                    'title' => 'Pengukuran Akurat',
                    'desc' => 'Pastikan anak tenang. Ukur tinggi badan 2 kali untuk akurasi.'
                ],
                [
                    'title' => 'Kebersihan Alat',
                    'desc' => 'Bersihkan timbangan sebelum dan sesudah digunakan.'
                ],
                [
                    'title' => 'Input Data',
                    'desc' => 'Periksa kembali angka sebelum menyimpan untuk menghindari kesalahan Z-Score.'
                ]
            ];
            $randomTip = $tips[array_rand($tips)];
        @endphp

        <div class="bg-white/10 rounded-lg p-4 backdrop-blur-sm border border-white/10">
            <h4 class="font-bold text-white mb-1">{{ $randomTip['title'] }}</h4>
            <p class="text-sm text-blue-100 leading-relaxed">{{ $randomTip['desc'] }}</p>
        </div>

        <button onclick="location.reload()" class="mt-4 text-xs font-medium text-blue-200 hover:text-white flex items-center transition">
            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Tips Lainnya
        </button>
    </div>
</div>