<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4">
        <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span>Role & Kontak</span>
        </h2>
    </div>

    <div class="p-6 space-y-5">
        {{-- Role --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">
                Role Pengguna <span class="text-red-500">*</span>
            </label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                {{-- Admin --}}
                <label class="relative flex items-center p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-[#000878] transition group">
                    <input type="radio" 
                        name="role" 
                        value="Admin" 
                        {{ old('role', $user->role) == 'Admin' ? 'checked' : '' }}
                        class="sr-only peer" 
                        required>
                    <div class="flex items-center space-x-3 flex-1">
                        <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center group-hover:bg-purple-200 transition peer-checked:bg-purple-500">
                            <svg class="w-4 h-4 text-purple-600 group-hover:text-purple-700 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-900">Admin</div>
                            <div class="text-xs text-gray-600">Akses penuh sistem</div>
                        </div>
                    </div>
                    <div class="absolute inset-0 border-2 border-[#000878] rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                </label>

                {{-- Petugas Posyandu --}}
                <label class="relative flex items-center p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-[#000878] transition group">
                    <input type="radio" 
                        name="role" 
                        value="Petugas Posyandu" 
                        {{ old('role', $user->role) == 'Petugas Posyandu' ? 'checked' : '' }}
                        class="sr-only peer">
                    <div class="flex items-center space-x-3 flex-1">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition peer-checked:bg-blue-500">
                            <svg class="w-4 h-4 text-blue-600 group-hover:text-blue-700 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-900">Petugas Posyandu</div>
                            <div class="text-xs text-gray-600">Input data pengukuran</div>
                        </div>
                    </div>
                    <div class="absolute inset-0 border-2 border-[#000878] rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                </label>

                {{-- Petugas Puskesmas --}}
                <label class="relative flex items-center p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-[#000878] transition group">
                    <input type="radio" 
                        name="role" 
                        value="Petugas Puskesmas" 
                        {{ old('role', $user->role) == 'Petugas Puskesmas' ? 'checked' : '' }}
                        class="sr-only peer">
                    <div class="flex items-center space-x-3 flex-1">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-200 transition peer-checked:bg-green-500">
                            <svg class="w-4 h-4 text-green-600 group-hover:text-green-700 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-900">Petugas Puskesmas</div>
                            <div class="text-xs text-gray-600">Validasi data wilayah</div>
                        </div>
                    </div>
                    <div class="absolute inset-0 border-2 border-[#000878] rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                </label>

                {{-- Petugas DPPKB --}}
                <label class="relative flex items-center p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-[#000878] transition group">
                    <input type="radio" 
                        name="role" 
                        value="Petugas DPPKB" 
                        {{ old('role', $user->role) == 'Petugas DPPKB' ? 'checked' : '' }}
                        class="sr-only peer">
                    <div class="flex items-center space-x-3 flex-1">
                        <div class="flex-shrink-0 w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center group-hover:bg-yellow-200 transition peer-checked:bg-yellow-500">
                            <svg class="w-4 h-4 text-yellow-600 group-hover:text-yellow-700 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-900">Petugas DPPKB</div>
                            <div class="text-xs text-gray-600">Validasi & laporan kota</div>
                        </div>
                    </div>
                    <div class="absolute inset-0 border-2 border-[#000878] rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                </label>

                {{-- Orang Tua --}}
                <label class="relative flex items-center p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-[#000878] transition group md:col-span-2">
                    <input type="radio" 
                        name="role" 
                        value="Orang Tua" 
                        {{ old('role', $user->role) == 'Orang Tua' ? 'checked' : '' }}
                        class="sr-only peer">
                    <div class="flex items-center space-x-3 flex-1">
                        <div class="flex-shrink-0 w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center group-hover:bg-pink-200 transition peer-checked:bg-pink-500">
                            <svg class="w-4 h-4 text-pink-600 group-hover:text-pink-700 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-900">Orang Tua</div>
                            <div class="text-xs text-gray-600">Monitor perkembangan anak</div>
                        </div>
                    </div>
                    <div class="absolute inset-0 border-2 border-[#000878] rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                </label>
            </div>
            @error('role')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email & No Telepon --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email <span class="text-gray-400 text-xs">(Opsional)</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <input type="email" 
                        name="email" 
                        id="email"
                        value="{{ old('email', $user->email) }}"
                        placeholder="contoh@email.com"
                        maxlength="100"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] @error('email') border-red-500 @enderror">
                </div>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- No Telepon --}}
            <div>
                <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-2">
                    No. Telepon <span class="text-gray-400 text-xs">(Opsional)</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <input type="text" 
                        name="no_telepon" 
                        id="no_telepon"
                        value="{{ old('no_telepon', $user->no_telepon) }}"
                        placeholder="08123456789"
                        maxlength="15"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] @error('no_telepon') border-red-500 @enderror">
                </div>
                @error('no_telepon')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>