<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <h3 class="text-lg font-bold text-gray-900">Ganti Password</h3>
        <p class="text-sm text-gray-500">Pastikan akun Anda menggunakan password yang aman.</p>
    </div>

    {{-- Added ID for JS targeting --}}
    <form id="passwordForm" method="post" action="{{ route('dppkb.profile.password') }}" class="p-6 space-y-5">
        @csrf
        @method('PUT')

        {{-- Current Password --}}
        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
            <div class="relative">
                <input type="password" name="current_password" id="current_password" 
                    class="w-full pr-10 rounded-lg border-gray-300 focus:border-[#000878] focus:ring focus:ring-[#000878]/20 transition-shadow text-sm py-2.5"
                    autocomplete="current-password">
                <button type="button" onclick="togglePassword('current_password', this)" 
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-[#000878] transition-colors focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </button>
            </div>
            @error('current_password', 'updatePassword')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- New Password --}}
        <div>
            <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
            <div class="relative">
                <input type="password" name="password" id="newPassword" 
                    class="w-full pr-10 rounded-lg border-gray-300 focus:border-[#000878] focus:ring focus:ring-[#000878]/20 transition-shadow text-sm py-2.5"
                    autocomplete="new-password">
                <button type="button" onclick="togglePassword('newPassword', this)" 
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-[#000878] transition-colors focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </button>
            </div>
            
            {{-- Password Strength Meter --}}
            <div id="passwordStrength" class="hidden mt-3 transition-all duration-300">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-xs text-gray-500">Kekuatan</span>
                    <span id="strengthText" class="text-xs font-bold text-gray-400">Menunggu input...</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5">
                    <div id="strengthBar" class="bg-red-500 h-1.5 rounded-full transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>

            @error('password', 'updatePassword')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <div class="relative">
                <input type="password" name="password_confirmation" id="password_confirmation" 
                    class="w-full pr-10 rounded-lg border-gray-300 focus:border-[#000878] focus:ring focus:ring-[#000878]/20 transition-shadow text-sm py-2.5"
                    autocomplete="new-password">
                <button type="button" onclick="togglePassword('password_confirmation', this)" 
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-[#000878] transition-colors focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </button>
            </div>
        </div>

        <div class="pt-4 mt-2">
            <button type="submit" 
                class="w-full px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 hover:text-[#000878] hover:border-[#000878] focus:ring-4 focus:ring-gray-100 transition-all flex justify-center items-center group">
                <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-[#000878] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Update Password
            </button>
        </div>

        @if (session('status') === 'password-updated')
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
               class="p-3 bg-green-50 border border-green-100 text-green-700 rounded-lg text-sm flex items-center shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Password berhasil diperbarui.
            </div>
        @endif
    </form>
</div>