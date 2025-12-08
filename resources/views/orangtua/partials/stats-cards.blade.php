<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    {{-- Total Anak --}}
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Anak</p>
                <h3 class="text-3xl font-bold mt-2">{{ $totalAnak }}</h3>
                <p class="text-blue-100 text-xs mt-1">Terdaftar</p>
            </div>
            <div class="bg-blue-400 bg-opacity-30 rounded-full p-4">
                <i class="fas fa-child text-3xl"></i>
            </div>
        </div>
    </div>

    {{-- Anak Normal --}}
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Status Normal</p>
                <h3 class="text-3xl font-bold mt-2">{{ $anakNormal }}</h3>
                <p class="text-green-100 text-xs mt-1">
                    {{ $totalAnak > 0 ? number_format(($anakNormal / $totalAnak) * 100, 1) : 0 }}% dari total
                </p>
            </div>
            <div class="bg-green-400 bg-opacity-30 rounded-full p-4">
                <i class="fas fa-check-circle text-3xl"></i>
            </div>
        </div>
    </div>

    {{-- Anak Stunting --}}
    <div class="bg-gradient-to-br from-orange-500 to-red-500 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium">Perlu Perhatian</p>
                <h3 class="text-3xl font-bold mt-2">{{ $anakStunting }}</h3>
                <p class="text-orange-100 text-xs mt-1">
                    {{ $totalAnak > 0 ? number_format(($anakStunting / $totalAnak) * 100, 1) : 0 }}% dari total
                </p>
            </div>
            <div class="bg-orange-400 bg-opacity-30 rounded-full p-4">
                <i class="fas fa-exclamation-triangle text-3xl"></i>
            </div>
        </div>
    </div>

    {{-- Notifikasi --}}
    <div class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium">Notifikasi Baru</p>
                <h3 class="text-3xl font-bold mt-2">{{ $unreadNotifications }}</h3>
                <p class="text-purple-100 text-xs mt-1">Belum dibaca</p>
            </div>
            <div class="bg-purple-400 bg-opacity-30 rounded-full p-4">
                <i class="fas fa-bell text-3xl"></i>
            </div>
        </div>
    </div>
</div>