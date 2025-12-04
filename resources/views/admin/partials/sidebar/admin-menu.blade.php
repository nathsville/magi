{{-- Menu Items --}}
    <nav class="space-y-2">
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="text-sm font-medium">Dashboard</span>
        </a>

        {{-- Data Master --}}
        <a href="{{ route('admin.datamaster') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.datamaster*') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
            </svg>
            <span class="text-sm font-medium">Data Master</span>
        </a>

        {{-- Puskesmas --}}
        <a href="{{ route('admin.puskesmas') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.puskesmas*') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-700' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <span class="font-medium">Puskesmas</span>
        </a>

        {{-- Posyandu --}}
        <a href="{{ route('admin.posyandu') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.posyandu*') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="text-sm font-medium">Posyandu</span>
        </a>

        {{-- Pengguna --}}
        <a href="{{ route('admin.users') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.users*') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <span class="text-sm font-medium">Pengguna</span>
        </a>

        {{-- Broadcast --}}
        <a href="{{ route('admin.broadcast') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.broadcast*') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
            </svg>
            <span class="text-sm font-medium">Broadcast Edukasi</span>
        </a>

        {{-- Audit Log --}}
        <a href="{{ route('admin.audit-log') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.audit-log*') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span class="text-sm font-medium">Audit Log</span>
        </a>
    </nav>
