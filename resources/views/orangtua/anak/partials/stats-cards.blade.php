<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    {{-- Total Anak --}}
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Anak</p>
                <h3 class="text-4xl font-bold mt-2">{{ $totalAnak }}</h3>
            </div>
            <div class="bg-blue-400 bg-opacity-30 rounded-full p-4">
                <i class="fas fa-users text-3xl"></i>
            </div>
        </div>
    </div>

    {{-- Normal --}}
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Status Normal</p>
                <h3 class="text-4xl font-bold mt-2">{{ $anakNormal }}</h3>
                <p class="text-green-100 text-xs mt-1">
                    {{ $totalAnak > 0 ? number_format(($anakNormal / $totalAnak) * 100, 1) : 0 }}%
                </p>
            </div>
            <div class="bg-green-400 bg-opacity-30 rounded-full p-4">
                <i class="fas fa-check-circle text-3xl"></i>
            </div>
        </div>
    </div>

    {{-- Stunting --}}
    <div class="bg-gradient-to-br from-orange-500 to-red-500 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium">Perlu Perhatian</p>
                <h3 class="text-4xl font-bold mt-2">{{ $anakStunting }}</h3>
                <p class="text-orange-100 text-xs mt-1">
                    {{ $totalAnak > 0 ? number_format(($anakStunting / $totalAnak) * 100, 1) : 0 }}%
                </p>
            </div>
            <div class="bg-orange-400 bg-opacity-30 rounded-full p-4">
                <i class="fas fa-exclamation-triangle text-3xl"></i>
            </div>
        </div>
    </div>
</div>