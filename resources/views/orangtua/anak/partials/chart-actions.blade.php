{{-- Add this to the bottom of detail.blade.php before @endsection --}}

<div class="mt-6 bg-white rounded-2xl shadow-lg p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">
        <i class="fas fa-download text-purple-600 mr-2"></i>Unduh Grafik
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <button onclick="downloadChart(beratBadanChart, 'Grafik_Berat_Badan_{{ $anak->nama_anak }}')" 
                class="px-4 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-download mr-2"></i>Unduh Grafik BB
        </button>
        
        <button onclick="downloadChart(tinggiBadanChart, 'Grafik_Tinggi_Badan_{{ $anak->nama_anak }}')" 
                class="px-4 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition">
            <i class="fas fa-download mr-2"></i>Unduh Grafik TB
        </button>
        
        <button onclick="downloadChart(lingkarChart, 'Grafik_Lingkar_{{ $anak->nama_anak }}')" 
                class="px-4 py-3 bg-orange-600 text-white font-medium rounded-lg hover:bg-orange-700 transition">
            <i class="fas fa-download mr-2"></i>Unduh Grafik Lingkar
        </button>
    </div>
    
    <div class="mt-4 pt-4 border-t border-gray-200">
        <p class="text-sm text-gray-600">
            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
            Grafik akan diunduh dalam format PNG. Anda dapat mencetak atau menyimpannya untuk arsip pribadi.
        </p>
    </div>
</div>