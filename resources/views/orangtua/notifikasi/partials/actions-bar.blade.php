<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002 2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <span class="font-medium">Total: {{ $notifikasiList->total() }} Pesan</span>
        </div>

        @if($belumDibaca > 0)
        <form method="POST" action="{{ route('orangtua.notifikasi.mark-all-read') }}">
            @csrf
            <button type="submit" 
                    class="flex items-center px-4 py-2 bg-[#000878] text-white text-sm font-medium rounded-lg hover:bg-blue-900 transition shadow-sm"
                    onclick="return confirm('Tandai semua notifikasi sebagai dibaca?')">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Tandai Semua Dibaca
            </button>
        </form>
        @endif
    </div>
</div>