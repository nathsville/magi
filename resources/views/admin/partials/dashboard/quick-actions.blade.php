<div class="bg-[#000878] rounded-xl p-6 text-white shadow-lg shadow-blue-900/20">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-bold mb-2">Akses Cepat Manajemen</h3>
            <p class="text-blue-200 text-sm">Kelola sistem dengan cepat melalui shortcut di bawah ini</p>
        </div>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        {{-- Tambah Pengguna --}}
        <a href="{{ route('admin.users.create') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/10 p-4 rounded-lg transition text-center group">
            <svg class="w-8 h-8 mx-auto mb-2 text-white group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            <p class="font-medium text-sm text-white">Tambah Pengguna</p>
        </a>
        
        {{-- Tambah Posyandu --}}
        <a href="{{ route('admin.posyandu.create') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/10 p-4 rounded-lg transition text-center group">
            <svg class="w-8 h-8 mx-auto mb-2 text-white group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <p class="font-medium text-sm text-white">Tambah Posyandu</p>
        </a>
        
        {{-- Kirim Broadcast --}}
        <a href="{{ route('admin.broadcast') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/10 p-4 rounded-lg transition text-center group">
            <svg class="w-8 h-8 mx-auto mb-2 text-white group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
            </svg>
            <p class="font-medium text-sm text-white">Kirim Broadcast</p>
        </a>
        
        {{-- Lihat Audit Log --}}
        <a href="{{ route('admin.audit-log') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/10 p-4 rounded-lg transition text-center group">
            <svg class="w-8 h-8 mx-auto mb-2 text-white group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <p class="font-medium text-sm text-white">Lihat Audit Log</p>
        </a>
    </div>
</div>