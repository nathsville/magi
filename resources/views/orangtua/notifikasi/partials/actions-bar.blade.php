<div class="bg-white rounded-xl shadow-lg p-4 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-600">
                <i class="fas fa-list mr-2"></i>{{ $notifikasiList->total() }} Notifikasi
            </span>
        </div>

        @if($belumDibaca > 0)
        <div class="flex items-center space-x-2">
            <form method="POST" action="{{ route('orangtua.notifikasi.mark-all-read') }}" class="inline">
                @csrf
                <button type="submit" 
                        class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition"
                        onclick="return confirm('Tandai semua notifikasi sebagai dibaca?')">
                    <i class="fas fa-check-double mr-2"></i>Tandai Semua Dibaca
                </button>
            </form>
        </div>
        @endif
    </div>
</div>