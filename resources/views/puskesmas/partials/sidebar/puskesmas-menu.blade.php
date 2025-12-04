<nav class="space-y-2">
    {{-- Dashboard --}}
    <a href="{{ route('puskesmas.dashboard') }}" 
        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('puskesmas.dashboard') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        <span class="text-sm font-medium">Dashboard</span>
    </a>

    {{-- Monitoring Data --}}
    <a href="{{ route('puskesmas.monitoring') }}" 
        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('puskesmas.monitoring*') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
        </svg>
        <span class="text-sm font-medium">Monitoring Data</span>
    </a>

    {{-- Validasi Data --}}
    <a href="{{ route('puskesmas.validasi.index') }}" 
        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('puskesmas.validasi*') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="text-sm font-medium">Validasi Data</span>
        @if(isset($pendingCount) && $pendingCount > 0)
        <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
            {{ $pendingCount }}
        </span>
        @endif
    </a>

    {{-- Input Data Pengukuran --}}
    <a href="{{ route('puskesmas.input.index') }}" 
        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('puskesmas.input*') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>
        <span class="text-sm font-medium">Input Data</span>
    </a>

    {{-- Data Anak --}}
    <a href="{{ route('puskesmas.anak.index') }}" 
        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('puskesmas.anak*') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        <span class="text-sm font-medium">Data Anak</span>
    </a>

    {{-- Intervensi --}}
    <a href="{{ route('puskesmas.intervensi.index') }}" 
        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('puskesmas.intervensi*') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
        <span class="text-sm font-medium">Intervensi</span>
    </a>

    {{-- Laporan --}}
    <a href="{{ route('puskesmas.laporan.index') }}" 
        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('puskesmas.laporan*') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <span class="text-sm font-medium">Laporan</span>
    </a>
</nav>