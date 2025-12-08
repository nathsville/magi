<nav class="bg-gradient-to-r from-purple-600 to-pink-600 shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                    <span class="text-2xl">👶</span>
                </div>
                <div class="text-white">
                    <h1 class="text-xl font-bold">MaGi</h1>
                    <p class="text-xs text-purple-200">Portal Orang Tua</p>
                </div>
            </div>

            {{-- Navigation --}}
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('orangtua.dashboard') }}" 
                   class="text-white hover:text-purple-200 transition {{ request()->routeIs('orangtua.dashboard') ? 'font-bold' : '' }}">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>
                <a href="{{ route('orangtua.anak.index') }}" 
                   class="text-white hover:text-purple-200 transition {{ request()->routeIs('orangtua.anak.*') ? 'font-bold' : '' }}">
                    <i class="fas fa-child mr-2"></i>Data Anak
                </a>
                
                {{-- PERBAIKAN DI SINI --}}
                <a href="{{ route('orangtua.notifikasi.index') }}" 
                   class="text-white hover:text-purple-200 transition relative {{ request()->routeIs('orangtua.notifikasi.*') ? 'font-bold' : '' }}">
                    <i class="fas fa-bell mr-2"></i>Notifikasi
                    
                    {{-- Menggunakan ->count() untuk mengecek jumlah data dalam collection --}}
                    @if($unreadNotifications->count() > 0)
                    <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                        {{-- Logika badge: Tampilkan '9+' jika lebih dari 9, jika tidak tampilkan angka aslinya --}}
                        {{ $unreadNotifications->count() > 9 ? '9+' : $unreadNotifications->count() }}
                    </span>
                    @endif
                </a>
                
                <a href="{{ route('orangtua.edukasi.index') }}" 
                   class="text-white hover:text-purple-200 transition {{ request()->routeIs('orangtua.edukasi.*') ? 'font-bold' : '' }}">
                    <i class="fas fa-book mr-2"></i>Edukasi
                </a>
            </div>

            {{-- User Menu --}}
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button onclick="toggleUserMenu()" class="flex items-center space-x-2 text-white hover:text-purple-200 transition">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama) }}&background=ffffff&color=9333ea" 
                             alt="User" 
                             class="w-8 h-8 rounded-full border-2 border-white">
                        <span class="hidden md:block font-medium">{{ auth()->user()->nama }}</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    
                    {{-- Dropdown --}}
                    <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 z-50">
                        <a href="{{ route('orangtua.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-purple-50">
                            <i class="fas fa-user mr-2"></i>Profil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
function toggleUserMenu() {
    const menu = document.getElementById('userMenu');
    menu.classList.toggle('hidden');
}

// Close menu when clicking outside
document.addEventListener('click', function(event) {
    const menu = document.getElementById('userMenu');
    const button = event.target.closest('button');
    
    if (!button && !menu.contains(event.target)) {
        menu.classList.add('hidden');
    }
});
</script>