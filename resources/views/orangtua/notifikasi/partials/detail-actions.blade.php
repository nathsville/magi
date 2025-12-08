<div class="bg-gray-50 p-6 border-t border-gray-200">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            @if($anak)
            <a href="{{ route('orangtua.anak.detail', $anak->id_anak) }}" 
               class="px-5 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition shadow-lg">
                <i class="fas fa-chart-line mr-2"></i>Lihat Grafik Pertumbuhan
            </a>
            @endif

            <button onclick="printNotification()" 
                    class="px-5 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition shadow-lg">
                <i class="fas fa-print mr-2"></i>Cetak
            </button>
        </div>

        <div>
            <form method="POST" action="{{ route('orangtua.notifikasi.delete', $notifikasi->id_notifikasi) }}" 
                  class="inline" 
                  onsubmit="return confirm('Yakin ingin menghapus notifikasi ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-5 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition shadow-lg">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
            </form>
        </div>
    </div>
</div>