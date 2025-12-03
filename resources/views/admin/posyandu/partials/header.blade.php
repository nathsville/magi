<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Kelola Posyandu</h1>
        <p class="text-sm text-gray-600 mt-1">Manajemen data Posyandu di Kota Parepare</p>
    </div>
    <a href="{{ route('admin.posyandu.create') }}" 
        class="flex items-center space-x-2 px-4 py-2.5 bg-primary text-white rounded-lg hover:bg-blue-900 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span class="text-sm font-medium">Tambah Posyandu</span>
    </a>
</div>