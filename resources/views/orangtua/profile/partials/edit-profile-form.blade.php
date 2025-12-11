<div class="bg-white rounded-2xl shadow-lg p-6">
    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="fas fa-edit text-purple-600 mr-2"></i>Edit Profil Keluarga
    </h3>

    <form method="POST" action="{{ route('orangtua.profile.update') }}" id="profileForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Nama Lengkap --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Lengkap (Akun) <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="nama" 
                       value="{{ old('nama', $user->nama) }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('nama') border-red-500 @enderror">
                @error('nama')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Ayah --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Ayah <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="nama_ayah" 
                       value="{{ old('nama_ayah', $orangTua->nama_ayah) }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('nama_ayah') border-red-500 @enderror">
                @error('nama_ayah')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Ibu --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Ibu <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="nama_ibu" 
                       value="{{ old('nama_ibu', $orangTua->nama_ibu) }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('nama_ibu') border-red-500 @enderror">
                @error('nama_ibu')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- NIK --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="nik" 
                       value="{{ old('nik', $orangTua->nik) }}"
                       required
                       maxlength="16"
                       pattern="[0-9]{16}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('nik') border-red-500 @enderror">
                @error('nik')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">16 digit angka</p>
            </div>

            {{-- Pekerjaan --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pekerjaan
                </label>
                <input type="text" 
                       name="pekerjaan" 
                       value="{{ old('pekerjaan', $orangTua->pekerjaan) }}"
                       maxlength="50"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('pekerjaan') border-red-500 @enderror">
                @error('pekerjaan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       name="email" 
                       value="{{ old('email', $user->email) }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror">
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- No Telepon --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    No. Telepon / WhatsApp
                </label>
                <input type="text" 
                       name="no_telepon" 
                       value="{{ old('no_telepon', $user->no_telepon) }}"
                       maxlength="15"
                       placeholder="08xxxx"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('no_telepon') border-red-500 @enderror">
                @error('no_telepon')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Alamat Lengkap <span class="text-red-500">*</span>
                </label>
                <textarea name="alamat" 
                          rows="3"
                          required
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('alamat') border-red-500 @enderror">{{ old('alamat', $orangTua->alamat) }}</textarea>
                @error('alamat')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Username (read-only) --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Username
                </label>
                <input type="text" 
                       value="{{ $user->username }}"
                       readonly
                       class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                <p class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-info-circle mr-1"></i>Username tidak dapat diubah
                </p>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="flex items-center justify-end space-x-4 mt-6 pt-6 border-t border-gray-200">
            <button type="reset" 
                    class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-undo mr-2"></i>Reset
            </button>
            <button type="submit" 
                    class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-lg hover:from-purple-700 hover:to-pink-700 transition shadow-lg">
                <i class="fas fa-save mr-2"></i>Simpan Perubahan
            </button>
        </div>
    </form>
</div>