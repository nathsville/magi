@if($user->id_user != auth()->id())
<div class="bg-red-50 rounded-xl border-2 border-red-200 overflow-hidden">
    <div class="bg-red-100 px-6 py-3 border-b border-red-200">
        <h3 class="text-base font-semibold text-red-900 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <span>Peringatan</span>
        </h3>
    </div>
    <div class="p-6">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <h4 class="text-sm font-semibold text-gray-900">Hapus Pengguna</h4>
                <p class="text-sm text-gray-600 mt-1">
                    Tindakan ini akan menghapus pengguna secara permanen. Data yang sudah dihapus tidak dapat dikembalikan.
                </p>
                @if($user->orangTua)
                <div class="mt-3 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                    <p class="text-xs text-yellow-800">
                        <strong>⚠️ Tidak dapat dihapus:</strong> Pengguna ini memiliki data profil orang tua yang terdaftar.
                    </p>
                </div>
                @endif
            </div>
            <button type="button" 
                onclick="confirmDeleteUser(this)"
                data-id="{{ $user->id_user }}"
                data-nama="{{ $user->nama }}"
                data-username="{{ $user->username }}"
                data-has-orang-tua="{{ $user->orangTua ? 'true' : 'false' }}"
                data-form-action="{{ route('admin.users.destroy', $user->id_user) }}"
                class="ml-4 px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition flex items-center space-x-2 {{ $user->orangTua ? 'opacity-50 cursor-not-allowed' : '' }}"
                {{ $user->orangTua ? 'disabled' : '' }}>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                <span>Hapus Pengguna</span>
            </button>
        </div>
    </div>
</div>
@endif