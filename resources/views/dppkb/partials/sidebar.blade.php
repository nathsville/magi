<nav class="space-y-1 px-2">
    {{-- Dashboard --}}
    <a href="{{ route('dppkb.dashboard') }}" 
        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition
            {{ request()->routeIs('dppkb.dashboard') ? 'bg-[#000878] text-white' : 'text-gray-700 hover:bg-gray-100' }}">
        <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        <span>Dashboard</span>
    </a>

    {{-- Monitoring Kota --}}
    <a href="{{ route('dppkb.monitoring') }}" 
        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition
            {{ request()->routeIs('dppkb.monitoring*') ? 'bg-[#000878] text-white' : 'text-gray-700 hover:bg-gray-100' }}">
        <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
        </svg>
        <span>Monitoring Kota</span>
    </a>

    {{-- Validasi Final --}}
    <a href="{{ route('dppkb.validasi') }}" 
        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition
            {{ request()->routeIs('dppkb.validasi*') ? 'bg-[#000878] text-white' : 'text-gray-700 hover:bg-gray-100' }}">
        <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>Validasi Final</span>
        @if($pendingValidasi > 0)
            <span class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                {{ $pendingValidasi }}
            </span>
        @endif
    </a>

    {{-- Laporan Daerah --}}
    <a href="{{ route('dppkb.laporan') }}" 
        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition
            {{ request()->routeIs('dppkb.laporan*') ? 'bg-[#000878] text-white' : 'text-gray-700 hover:bg-gray-100' }}">
        <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <span>Laporan Daerah</span>
    </a>

    {{-- Statistik --}}
    <a href="{{ route('dppkb.statistik') }}" 
        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition
            {{ request()->routeIs('dppkb.statistik*') ? 'bg-[#000878] text-white' : 'text-gray-700 hover:bg-gray-100' }}">
        <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <span>Statistik & Analytics</span>
    </a>

    {{-- Divider --}}
    <div class="border-t border-gray-200 my-3"></div>

    {{-- Notifikasi --}}
    <a href="{{ route('dppkb.notifikasi') }}" 
        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition
            {{ request()->routeIs('dppkb.notifikasi*') ? 'bg-[#000878] text-white' : 'text-gray-700 hover:bg-gray-100' }}">
        <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        <span>Notifikasi</span>
    </a>
</nav>