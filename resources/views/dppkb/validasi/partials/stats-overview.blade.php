<div class="grid grid-cols-1 md:grid-cols-4 gap-4" id="statsOverview">
    {{-- Pending Approval --}}
    <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-6 border-2 border-orange-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-orange-800 mb-1">Menunggu Approval</p>
                <p class="text-3xl font-bold text-orange-900" id="statPending">0</p>
            </div>
            <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Approved Today --}}
    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border-2 border-green-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-green-800 mb-1">Disetujui Hari Ini</p>
                <p class="text-3xl font-bold text-green-900" id="statApproved">0</p>
            </div>
            <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Need Clarification --}}
    <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 border-2 border-red-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-red-800 mb-1">Perlu Klarifikasi</p>
                <p class="text-3xl font-bold text-red-900" id="statClarification">0</p>
            </div>
            <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Total This Month --}}
    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border-2 border-purple-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-purple-800 mb-1">Total Bulan Ini</p>
                <p class="text-3xl font-bold text-purple-900" id="statTotal">0</p>
            </div>
            <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>