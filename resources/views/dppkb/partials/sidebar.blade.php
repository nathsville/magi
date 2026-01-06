<div class="flex flex-col h-full">
    {{-- Menu Navigasi --}}
    <nav class="space-y-2 flex-1">
        {{-- Dashboard --}}
        <a href="{{ route('dppkb.dashboard') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dppkb.dashboard') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="text-sm font-medium">Dashboard</span>
        </a>

        {{-- Monitoring Kota --}}
        <a href="{{ route('dppkb.monitoring') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dppkb.monitoring*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
            </svg>
            <span class="text-sm font-medium">Monitoring Kota</span>
        </a>

        {{-- Validasi Final --}}
        <a href="{{ route('dppkb.validasi') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dppkb.validasi*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm font-medium">Validasi Final</span>
            
            {{-- Badge Validasi --}}
            @if(isset($pendingValidasi) && $pendingValidasi > 0)
            <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-sm">
                {{ $pendingValidasi }}
            </span>
            @endif
        </a>

        {{-- Laporan Daerah --}}
        <a href="{{ route('dppkb.laporan') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dppkb.laporan*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span class="text-sm font-medium">Laporan Daerah</span>
        </a>

        {{-- Statistik --}}
        <a href="{{ route('dppkb.statistik') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dppkb.statistik*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span class="text-sm font-medium">Statistik & Analytics</span>
        </a>

        {{-- Notifikasi --}}
        <a href="{{ route('dppkb.notifikasi') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dppkb.notifikasi*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            <span class="text-sm font-medium">Notifikasi</span>
        </a>
    </nav>

    {{-- Footer Sidebar: Profile & Logout --}}
    <div class="mt-auto pt-4 border-t border-white/10">
        
        {{-- Profile Link (Menggunakan '#' jika belum ada route khusus profile dppkb) --}}
        <a href="{{ route('dppkb.profile') }}"
           class="flex items-center gap-3 p-2 mb-3 rounded-lg hover:bg-white/10 transition-colors duration-200 group cursor-pointer">
            
            {{-- Avatar --}}
            <div class="relative shrink-0">
                <div class="w-10 h-10 rounded-full bg-[#4a50c9] border-2 border-[#6d72db] flex items-center justify-center text-white font-bold text-lg shadow-sm group-hover:border-white transition-colors">
                    {{ substr(Auth::user()->nama ?? 'A', 0, 1) }}
                </div>
                {{-- Status Online Indicator --}}
                <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-[#1e1b4b] rounded-full"></div>
            </div>

            {{-- Nama & Role --}}
            <div class="flex-1 min-w-0">
                <h4 class="text-sm font-bold text-white truncate group-hover:text-blue-100 transition-colors">
                    {{ Auth::user()->nama ?? 'Admin DPPKB' }}
                </h4>
                <p class="text-xs text-blue-200 truncate">Administrator</p>
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