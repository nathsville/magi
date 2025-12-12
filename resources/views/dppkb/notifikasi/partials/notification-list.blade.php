<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    {{-- List Header --}}
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="text-lg font-bold text-gray-900">Daftar Notifikasi</h3>
        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-600" id="notifCount">0 notifikasi</span>
            <button onclick="refreshNotifikasi()" 
                class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </button>
        </div>
    </div>
    
    {{-- List Body --}}
    <div id="notificationListContainer" class="divide-y divide-gray-200 max-h-[600px] overflow-y-auto">
        {{-- Loading State --}}
        <div class="px-6 py-8 text-center">
            <div class="inline-block animate-spin rounded-full h-10 w-10 border-4 border-purple-600 border-t-transparent mb-3"></div>
            <p class="text-gray-600 text-sm">Memuat notifikasi...</p>
        </div>
    </div>
    
    {{-- Pagination --}}
    <div class="px-6 py-4 border-t border-gray-200" id="notificationPagination">
        {{-- Pagination will be inserted here --}}
    </div>
</div>