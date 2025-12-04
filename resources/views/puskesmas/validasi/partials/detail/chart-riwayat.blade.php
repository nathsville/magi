<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
            <span>Riwayat Pertumbuhan Anak</span>
        </h2>
    </div>
    <div class="p-6">
        <div class="relative h-[300px]">
            <canvas id="riwayatChart"></canvas>
        </div>
        
        {{-- Hidden data for chart --}}
        <div id="chartData" class="hidden"
            data-labels='@json($riwayatPengukuran->pluck("tanggal_ukur")->map(fn($d) => \Carbon\Carbon::parse($d)->format("d/m/Y")))'
            data-bb='@json($riwayatPengukuran->pluck("berat_badan"))'
            data-tb='@json($riwayatPengukuran->pluck("tinggi_badan"))'>
        </div>
    </div>
</div>