<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-white flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Edit Profil Keluarga
        </h2>
    </div>

    <form method="POST" action="{{ route('orangtua.profile.update') }}" class="p-6">
        @csrf
        @method('PUT')

        <div class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Nama Lengkap --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap (Akun) <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors shadow-sm @error('nama') border-red-500 @enderror">
                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Nama Ayah --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $orangTua->nama_ayah) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors shadow-sm @error('nama_ayah') border-red-500 @enderror">
                    @error('nama_ayah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Nama Ibu --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $orangTua->nama_ibu) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors shadow-sm @error('nama_ibu') border-red-500 @enderror">
                    @error('nama_ibu') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- NIK --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIK <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik', $orangTua->nik) }}" required maxlength="16"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors shadow-sm @error('nik') border-red-500 @enderror">
                    <p class="text-[11px] text-gray-500 mt-1">16 digit angka</p>
                    @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Pekerjaan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $orangTua->pekerjaan) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors shadow-sm @error('pekerjaan') border-red-500 @enderror">
                    @error('pekerjaan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors shadow-sm @error('email') border-red-500 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- No Telepon --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon / WhatsApp</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors shadow-sm @error('no_telepon') border-red-500 @enderror">
                    @error('no_telepon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Alamat --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea name="alamat" rows="3" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] transition-colors shadow-sm @error('alamat') border-red-500 @enderror">{{ old('alamat', $orangTua->alamat) }}</textarea>
                    @error('alamat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-2 bg-[#000878] text-white text-sm font-bold rounded-lg hover:bg-blue-900 shadow-md hover:shadow-lg transition flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>