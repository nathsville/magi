<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-white flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            Ubah Password
        </h2>
    </div>

    <form method="POST" action="{{ route('orangtua.profile.change-password') }}" class="p-6">
        @csrf
        
        {{-- Hidden fields to preserve other data (untuk kompatibilitas) --}}
        <input type="hidden" name="nama" value="{{ $user->nama }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        <input type="hidden" name="no_telepon" value="{{ $user->no_telepon }}">

        <div class="space-y-5">
            {{-- Password Lama (Diperlukan di modul Orangtua) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama <span class="text-red-500">*</span></label>
                <input type="password" name="current_password" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors @error('current_password') border-red-500 @enderror">
                @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <input type="password" name="password" minlength="8" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors @error('password') border-red-500 @enderror">
                    <p class="text-[11px] text-gray-500 mt-1">Min. 8 karakter. Kombinasi huruf & angka.</p>
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" minlength="8" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-2 bg-gray-800 text-white text-sm font-bold rounded-lg hover:bg-gray-900 shadow-md hover:shadow-lg transition flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 19l-1 1-1 1-2-2-1 1-1 1-2-2 1-1 1-1 2-2 1-1 1-1 5.743-7.743A6 6 0 0115 7z"></path></svg>
                    Update Password
                </button>
            </div>
        </div>
    </form>
</div>