@if($user->id_user == auth()->id())
<div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
    <div class="flex items-start space-x-3">
        <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <div>
            <h3 class="text-sm font-semibold text-yellow-900">Anda sedang mengedit akun Anda sendiri</h3>
            <p class="text-sm text-yellow-800 mt-1">Berhati-hatilah saat mengubah role atau status akun Anda sendiri.</p>
        </div>
    </div>
</div>
@endif