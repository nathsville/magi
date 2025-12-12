<div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            {{-- Title Section --}}
            <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm relative">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    {{-- Unread Badge --}}
                    <span id="headerUnreadBadge" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">
                        0
                    </span>
                </div>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-white">Notifikasi</h1>
                    <p class="text-purple-100 text-sm mt-1">Kelola dan pantau notifikasi sistem</p>
                </div>
            </div>
            
            {{-- Action Buttons --}}
            <div class="flex items-center space-x-3">
                {{-- Mark All Read --}}
                <button onclick="markAllAsRead()" 
                    class="px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-lg transition flex items-center space-x-2 backdrop-blur-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="hidden sm:inline">Tandai Semua</span>
                </button>
                
                {{-- Compose --}}
                <button onclick="openModalCompose()" 
                    class="px-4 py-2 bg-white text-purple-700 hover:bg-purple-50 rounded-lg transition flex items-center space-x-2 font-medium shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Buat Notifikasi</span>
                </button>
                
                {{-- Back --}}
                <a href="{{ route('dppkb.dashboard') }}" 
                    class="px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-lg transition flex items-center space-x-2 backdrop-blur-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="hidden sm:inline">Dashboard</span>
                </a>
            </div>
        </div>
    </div>
</div>