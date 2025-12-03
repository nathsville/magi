<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4">
        <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Informasi Posyandu</span>
        </h2>
    </div>

    <div class="p-6 space-y-5">
        {{-- Nama Posyandu --}}
        <div>
            <label for="nama_posyandu" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Posyandu <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <input type="text" 
                    name="nama_posyandu" 
                    id="nama_posyandu"
                    value="{{ old('nama_posyandu') }}"
                    placeholder="Contoh: Posyandu Melati 1"
                    maxlength="100"
                    required
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] @error('nama_posyandu') border-red-500 @enderror">
            </div>
            @error('nama_posyandu')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Puskesmas --}}
        <div>
            <label for="id_puskesmas" class="block text-sm font-medium text-gray-700 mb-2">
                Puskesmas <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <select name="id_puskesmas" 
                    id="id_puskesmas" 
                    required
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] @error('id_puskesmas') border-red-500 @enderror appearance-none">
                    <option value="">-- Pilih Puskesmas --</option>
                    @foreach($puskesmasList as $pusk)
                        <option value="{{ $pusk->id_puskesmas }}" {{ old('id_puskesmas') == $pusk->id_puskesmas ? 'selected' : '' }}>
                            {{ $pusk->nama_puskesmas }} - {{ $pusk->kecamatan }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
            @error('id_puskesmas')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-gray-500">Pilih puskesmas yang membina posyandu ini</p>
        </div>

        {{-- Alamat Lengkap --}}
        <div>
            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                Alamat Lengkap <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute top-3 left-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <textarea name="alamat" 
                    id="alamat" 
                    rows="3" 
                    required
                    placeholder="Masukkan alamat lengkap posyandu..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] @error('alamat') border-red-500 @enderror">{{ old('alamat') }}</textarea>
            </div>
            @error('alamat')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>