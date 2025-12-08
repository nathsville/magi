<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    {{-- Total --}}
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Notifikasi</p>
                <h3 class="text-4xl font-bold mt-2">{{ $totalNotifikasi }}</h3>
            </div>
            <div class="bg-blue-400 bg-opacity-30 rounded-full p-4">
                <i class="fas fa-inbox text-3xl"></i>
            </div>
        </div>
    </div>

    {{-- Belum Dibaca --}}
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium">Belum Dibaca</p>
                <h3 class="text-4xl font-bold mt-2">{{ $belumDibaca }}</h3>
            </div>
            <div class="bg-purple-400 bg-opacity-30 rounded-full p-4">
                <i class="fas fa-envelope text-3xl"></i>
            </div>
        </div>
    </div>

    {{-- Sudah Dibaca --}}
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Sudah Dibaca</p>
                <h3 class="text-4xl font-bold mt-2">{{ $sudahDibaca }}</h3>
            </div>
            <div class="bg-green-400 bg-opacity-30 rounded-full p-4">
                <i class="fas fa-envelope-open text-3xl"></i>
            </div>
        </div>
    </div>

    {{-- Peringatan --}}
    <div class="bg-gradient-to-br from-orange-500 to-red-500 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium">Peringatan</p>
                <h3 class="text-4xl font-bold mt-2">{{ $peringatan }}</h3>
            </div>
            <div class="bg-orange-400 bg-opacity-30 rounded-full p-4">
                <i class="fas fa-exclamation-triangle text-3xl"></i>
            </div>
        </div>
    </div>
</div>