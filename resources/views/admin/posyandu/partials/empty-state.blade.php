<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12">
    <div class="text-center">
        <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
        </svg>
        
        @if(request()->hasAny(['search', 'puskesmas', 'kecamatan', 'status']))
            <h3 class="mt-4 text-lg font-semibold text-gray-900">Tidak ada posyandu yang sesuai</h3>
            <p class="mt-2 text-sm text-gray-600">
                Tidak ditemukan posyandu dengan filter yang Anda terapkan.<br>
                Coba ubah filter atau hapus pencarian.
            </p>
            <div class="mt-6">
                <a href="{{ route('admin.posyandu') }}" 
                    class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-blue-900 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Hapus Filter
                </a>
            </div>
        @else
            <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum ada data posyandu</h3>
            <p class="mt-2 text-sm text-gray-600">
                Mulai tambahkan posyandu untuk sistem monitoring stunting.
            </p>
            <div class="mt-6">
                <a href="{{ route('admin.posyandu.create') }}" 
                    class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-blue-900 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Posyandu Pertama
                </a>
            </div>
        @endif
    </div>
</div>