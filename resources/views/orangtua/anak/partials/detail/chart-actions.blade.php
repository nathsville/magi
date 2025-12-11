<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide mb-4 flex items-center">
        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
        </svg>
        Download Grafik
    </h3>
    
    <div class="grid grid-cols-1 gap-3">
        <button onclick="downloadChart(beratBadanChart, 'Grafik_BB_{{ $anak->nama_anak }}')" 
                class="flex items-center justify-center px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:text-[#000878] hover:border-blue-300 transition text-sm font-medium">
            Grafik Berat Badan
        </button>
        
        <button onclick="downloadChart(tinggiBadanChart, 'Grafik_TB_{{ $anak->nama_anak }}')" 
                class="flex items-center justify-center px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:text-[#000878] hover:border-blue-300 transition text-sm font-medium">
            Grafik Tinggi Badan
        </button>
    </div>
</div>