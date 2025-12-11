<nav class="space-y-2">
    {{-- Dashboard --}}
    <a href="{{ route('orangtua.dashboard') }}" 
        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('orangtua.dashboard') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        <span class="text-sm font-medium">Dashboard</span>
    </a>

    {{-- Data Anak --}}
    <a href="{{ route('orangtua.anak.index') }}" 
        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('orangtua.anak.*') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        <span class="text-sm font-medium">Data Anak</span>
    </a>

    {{-- Notifikasi --}}
    <a href="{{ route('orangtua.notifikasi.index') }}" 
        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('orangtua.notifikasi.*') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        <span class="text-sm font-medium">Notifikasi</span>
        
        @if(isset($unreadNotifications) && $unreadNotifications > 0)
        <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
            {{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}
        </span>
        @endif
    </a>

    {{-- Edukasi --}}
    <a href="{{ route('orangtua.edukasi.index') }}" 
        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('orangtua.edukasi.*') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
        </svg>
        <span class="text-sm font-medium">Edukasi</span>
    </a>
</nav>