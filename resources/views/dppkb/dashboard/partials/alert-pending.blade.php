<div class="bg-orange-50 border-l-4 border-orange-500 rounded-lg p-4 shadow-sm animate-pulse-soft">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg class="h-6 w-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <div class="ml-3 flex-1">
            <h3 class="text-sm font-semibold text-orange-800">
                Perhatian: Ada Data Menunggu Validasi Final
            </h3>
            <p class="text-sm text-orange-700 mt-1">
                Terdapat <strong class="font-bold">{{ $pendingValidasi }} data stunting</strong> yang telah divalidasi oleh Puskesmas dan menunggu persetujuan final dari DPPKB.
            </p>
            <div class="mt-3">
                <a href="{{ route('dppkb.validasi') }}" 
                    class="inline-flex items-center px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Proses Validasi Sekarang
                </a>
            </div>
        </div>
    </div>
</div>