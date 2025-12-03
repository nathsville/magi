<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12">
    <div class="text-center">
        <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        
        @if(request()->hasAny(['search', 'role', 'status']))
            <h3 class="mt-4 text-lg font-semibold text-gray-900">Tidak ada pengguna yang sesuai</h3>
            <p class="mt-2 text-sm text-gray-600">
                Tidak ditemukan pengguna dengan filter yang Anda terapkan.<br>
                Coba ubah filter atau hapus pencarian.
            </p>
            <div class="mt-6">
                <a href="{{ route('admin.users') }}" 
                    class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-blue-900 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Hapus Filter
                </a>
            </div>
        @else
            <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum ada data pengguna</h3>
            <p class="mt-2 text-sm text-gray-600">
                Mulai tambahkan pengguna untuk mengakses sistem.
            </p>
            <div class="mt-6">
                <a href="{{ route('admin.users.create') }}" 
                    class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-blue-900 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Pengguna Pertama
                </a>
            </div>
        @endif
    </div>
</div>