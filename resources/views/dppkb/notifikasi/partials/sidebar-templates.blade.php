<div class="bg-gradient-to-br from-purple-600 to-indigo-700 rounded-xl shadow-lg p-6 text-white">
    <h3 class="text-lg font-bold mb-4">Template Notifikasi</h3>
    
    <div class="space-y-3">
        <button onclick="useTemplate('validasi_selesai')" 
            class="w-full text-left p-3 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg transition backdrop-blur-sm">
            <p class="font-semibold text-sm mb-1">Validasi Selesai</p>
            <p class="text-xs text-purple-100">Data stunting telah divalidasi</p>
        </button>
        
        <button onclick="useTemplate('peringatan_stunting')" 
            class="w-full text-left p-3 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg transition backdrop-blur-sm">
            <p class="font-semibold text-sm mb-1">Peringatan Stunting</p>
            <p class="text-xs text-purple-100">Anak terindikasi stunting</p>
        </button>
        
        <button onclick="useTemplate('jadwal_posyandu')" 
            class="w-full text-left p-3 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg transition backdrop-blur-sm">
            <p class="font-semibold text-sm mb-1">Jadwal Posyandu</p>
            <p class="text-xs text-purple-100">Pengingat jadwal kegiatan</p>
        </button>
        
        <button onclick="useTemplate('laporan_bulanan')" 
            class="w-full text-left p-3 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg transition backdrop-blur-sm">
            <p class="font-semibold text-sm mb-1">Laporan Bulanan</p>
            <p class="text-xs text-purple-100">Rekap data bulanan tersedia</p>
        </button>
    </div>
    
    <button onclick="openModalCompose()" 
        class="w-full mt-4 px-4 py-2 bg-white text-purple-700 hover:bg-purple-50 rounded-lg transition font-medium flex items-center justify-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Buat Custom</span>
    </button>
</div>