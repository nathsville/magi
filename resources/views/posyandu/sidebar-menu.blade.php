<div class="flex flex-col h-full">
    {{-- Menu Navigasi --}}
    <nav class="space-y-2 flex-1">
        {{-- Dashboard --}}
        <a href="{{ route('posyandu.dashboard') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('posyandu.dashboard') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="text-sm font-medium">Dashboard</span>
        </a>

        {{-- Input Pengukuran --}}
        <a href="{{ route('posyandu.pengukuran.form') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('posyandu.pengukuran.*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span class="text-sm font-medium">Input Pengukuran</span>
        </a>

        {{-- Data Anak --}}
        <a href="{{ route('posyandu.anak.index') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('posyandu.anak.*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span class="text-sm font-medium">Data Anak</span>
        </a>

        {{-- Laporan --}}
        <a href="{{ route('posyandu.laporan.index') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('posyandu.laporan*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span class="text-sm font-medium">Laporan</span>
        </a>
    </nav>

    {{-- Footer Sidebar: Profile & Logout --}}
    <div class="mt-auto pt-4 border-t border-white/10">
        
        {{-- Profile Link --}}
        <a href="{{ route('posyandu.profile') }}" 
           class="flex items-center gap-3 p-2 mb-3 rounded-lg hover:bg-white/10 transition-colors duration-200 group cursor-pointer">
            
            {{-- Avatar --}}
            <div class="relative shrink-0">
                <div class="w-10 h-10 rounded-full bg-[#4a50c9] border-2 border-[#6d72db] flex items-center justify-center text-white font-bold text-lg shadow-sm group-hover:border-white transition-colors">
                    {{ substr(Auth::user()->nama ?? 'U', 0, 1) }}
                </div>
                <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-[#1e1b4b] rounded-full"></div>
            </div>

            {{-- Nama & Role --}}
            <div class="flex-1 min-w-0">
                <h4 class="text-sm font-bold text-white truncate group-hover:text-blue-100 transition-colors">
                    {{ Auth::user()->nama ?? 'User' }}
                </h4>
                <p class="text-xs text-blue-200 truncate">Petugas Posyandu</p>
            </div>
            
            {{-- Icon Panah Kecil --}}
            <svg class="w-4 h-4 text-white/50 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>

        {{-- Tombol Keluar --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center justify-center gap-2 p-2.5 rounded-lg bg-black/20 text-gray-300 hover:bg-red-600/90 hover:text-white transition-all text-sm font-medium border border-white/5 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</div>