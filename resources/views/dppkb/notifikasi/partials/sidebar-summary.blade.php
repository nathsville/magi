<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan</h3>
    
    <div class="space-y-4">
        {{-- By Type --}}
        <div>
            <p class="text-xs font-semibold text-gray-600 uppercase mb-2">Per Tipe</p>
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                        <span class="text-sm text-gray-700">Validasi</span>
                    </div>
                    <span class="text-sm font-bold text-gray-900" id="summaryValidasi">-</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <span class="text-sm text-gray-700">Peringatan</span>
                    </div>
                    <span class="text-sm font-bold text-gray-900" id="summaryPeringatan">-</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        <span class="text-sm text-gray-700">Informasi</span>
                    </div>
                    <span class="text-sm font-bold text-gray-900" id="summaryInformasi">-</span>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-200 pt-4">
            <p class="text-xs font-semibold text-gray-600 uppercase mb-2">Aktivitas</p>
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">Minggu Ini</span>
                    <span class="text-sm font-bold text-gray-900" id="summaryMingguIni">-</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">Bulan Ini</span>
                    <span class="text-sm font-bold text-gray-900" id="summaryBulanIni">-</span>
                </div>
            </div>
        </div>
    </div>
</div>