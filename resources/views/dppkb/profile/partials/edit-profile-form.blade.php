<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <h3 class="text-lg font-bold text-gray-900">Informasi Profil</h3>
        <p class="text-sm text-gray-500">Perbarui informasi profil akun Anda dan alamat email.</p>
    </div>

    {{-- Added ID for JS targeting --}}
    <form id="profileForm" method="post" action="{{ route('dppkb.profile.update') }}" class="p-6 space-y-6">
        @csrf
        @method('PUT')

        {{-- Avatar Section --}}
        <div class="flex items-center space-x-6">
            <div class="shrink-0 relative group">
                <div class="w-20 h-20 rounded-full bg-[#000878] flex items-center justify-center text-white text-3xl font-bold shadow-md transition-transform transform group-hover:scale-105">
                    {{ substr(Auth::user()->nama ?? 'A', 0, 1) }}
                </div>
                <div class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 border-2 border-white rounded-full"></div>
            </div>
            <div>
                <h4 class="font-medium text-gray-900 text-lg">{{ Auth::user()->nama }}</h4>
                <p class="text-sm text-[#000878] font-medium mb-1">{{ Auth::user()->role ?? 'Administrator' }}</p>
                <p class="text-xs text-gray-400">Bergabung sejak {{ Auth::user()->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6">
            {{-- Nama --}}
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <div class="relative">
                    <input type="text" name="nama" id="nama" 
                        value="{{ old('nama', Auth::user()->nama) }}"
                        class="w-full pl-10 rounded-lg border-gray-300 focus:border-[#000878] focus:ring focus:ring-[#000878]/20 transition-shadow text-sm py-2.5"
                        required autocomplete="name">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                </div>
                @error('nama')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <div class="relative">
                    <input type="email" name="email" id="email" 
                        value="{{ old('email', Auth::user()->email) }}"
                        class="w-full pl-10 rounded-lg border-gray-300 focus:border-[#000878] focus:ring focus:ring-[#000878]/20 transition-shadow text-sm py-2.5"
                        required autocomplete="email">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
            <button type="submit" 
                class="px-5 py-2.5 bg-[#000878] text-white text-sm font-medium rounded-lg hover:bg-blue-900 focus:ring-4 focus:ring-blue-900/20 transition-all shadow-sm hover:shadow-md flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Simpan Perubahan
            </button>
            
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                   class="text-sm text-green-600 font-medium flex items-center bg-green-50 px-3 py-1.5 rounded-md">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Tersimpan.
                </p>
            @endif
        </div>
    </form>
</div>