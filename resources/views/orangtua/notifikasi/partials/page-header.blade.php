<div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                <i class="fas fa-bell text-purple-600 mr-3"></i>Notifikasi
            </h1>
            <p class="text-gray-600">Pantau semua pemberitahuan dan peringatan kesehatan anak Anda</p>
        </div>
        <div class="hidden md:block">
            <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full flex items-center justify-center text-white text-4xl shadow-lg relative">
                🔔
                @if($belumDibaca > 0)
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center font-bold">
                    {{ $belumDibaca > 9 ? '9+' : $belumDibaca }}
                </span>
                @endif
            </div>
        </div>
    </div>
</div>