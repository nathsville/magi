<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 flex items-center space-x-3">
            <div class="w-10 h-10 bg-[#000878] rounded-xl flex items-center justify-center shadow-sm">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <span>Audit Log</span>
        </h1>
        <p class="text-sm text-gray-600 mt-1">Monitor aktivitas dan perubahan data sistem secara real-time</p>
    </div>

    <div class="flex items-center space-x-3">
        {{-- Filter Button --}}
        <a href="{{ route('admin.audit-log.filter') }}" 
            class="flex items-center space-x-2 px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <span class="text-sm font-medium">Advanced Filter</span>
        </a>

        {{-- Export Button --}}
        <button type="button" 
            onclick="exportAuditLog()"
            class="flex items-center space-x-2 px-4 py-2.5 bg-[#000878] text-white rounded-lg hover:bg-blue-900 transition shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span class="text-sm font-medium">Export CSV</span>
        </button>
    </div>
</div>