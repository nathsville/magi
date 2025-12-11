<div class="bg-white rounded-2xl shadow-lg p-6">
    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="fas fa-key text-purple-600 mr-2"></i>Ubah Password
    </h3>

    <form method="POST" action="{{ route('orangtua.profile.change-password') }}" id="passwordForm">
        @csrf

        <div class="space-y-4">
            {{-- Current Password --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Password Lama <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="password" 
                           name="current_password" 
                           id="currentPassword"
                           required
                           class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('current_password') border-red-500 @enderror">
                    <button type="button" 
                            onclick="togglePassword('currentPassword', this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('current_password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- New Password --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Password Baru <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="password" 
                           name="password" 
                           id="newPassword"
                           minlength="8"
                           required
                           class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('password') border-red-500 @enderror">
                    <button type="button" 
                            onclick="togglePassword('newPassword', this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                
                {{-- Password Strength Indicator --}}
                <div id="passwordStrength" class="mt-2 hidden">
                    <div class="flex items-center space-x-2">
                        <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div id="strengthBar" class="h-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                        <span id="strengthText" class="text-xs font-medium"></span>
                    </div>
                </div>
            </div>

            {{-- Confirm Password --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Konfirmasi Password Baru <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="password" 
                           name="password_confirmation" 
                           id="confirmPassword"
                           minlength="8"
                           required
                           class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <button type="button" 
                            onclick="togglePassword('confirmPassword', this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            {{-- Password Requirements --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm font-semibold text-blue-800 mb-2">
                    <i class="fas fa-info-circle mr-1"></i>Persyaratan Password:
                </p>
                <ul class="text-xs text-blue-700 space-y-1 ml-5 list-disc">
                    <li>Minimal 8 karakter</li>
                    <li>Gunakan kombinasi huruf besar, huruf kecil, dan angka</li>
                    <li>Hindari menggunakan informasi pribadi yang mudah ditebak</li>
                    <li>Jangan gunakan password yang sama dengan akun lain</li>
                </ul>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="flex items-center justify-end space-x-4 mt-6 pt-6 border-t border-gray-200">
            <button type="reset" 
                    class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-times mr-2"></i>Batal
            </button>
            <button type="submit" 
                    class="px-6 py-3 bg-gradient-to-r from-pink-600 to-red-600 text-white font-bold rounded-lg hover:from-pink-700 hover:to-red-700 transition shadow-lg">
                <i class="fas fa-lock mr-2"></i>Ubah Password
            </button>
        </div>
    </form>
</div>