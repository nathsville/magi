<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
    {{-- Pengukuran Hari Ini (Blue) --}}
    <div class="bg-blue-600 rounded-xl shadow-sm p-6 text-white transform hover:scale-[1.02] transition-transform duration-300">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-blue-100 text-sm font-medium mb-1">Pengukuran Hari Ini</p>
                <h3 class="text-3xl font-bold" data-stat="today">{{ number_format($todayMeasurements) }}</h3>
                <p class="text-blue-100 text-xs mt-2">Data masuk hari ini</p>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Total Anak (Green) --}}
    <div class="bg-green-600 rounded-xl shadow-sm p-6 text-white transform hover:scale-[1.02] transition-transform duration-300">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-green-100 text-sm font-medium mb-1">Total Anak</p>
                <h3 class="text-3xl font-bold">{{ number_format($totalAnak) }}</h3>
                <p class="text-green-100 text-xs mt-2">Terdaftar di Posyandu</p>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Persentase Stunting (Orange/Red logic like Puskesmas) --}}
    @php
        $stuntingColor = $persentaseStunting >= 20 ? 'bg-red-600' : 'bg-yellow-500';
    @endphp
    <div class="{{ $stuntingColor }} rounded-xl shadow-sm p-6 text-white transform hover:scale-[1.02] transition-transform duration-300">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-white/80 text-sm font-medium mb-1">Persentase Stunting</p>
                <h3 class="text-3xl font-bold" data-stat="percentage">{{ $persentaseStunting }}%</h3>
                <div class="text-white/80 text-xs mt-2 font-medium">
                    @if($persentaseStunting < 20)
                        <span>Target WHO tercapai</span>
                    @else
                        <span>Perlu perhatian khusus</span>
                    @endif
                </div>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Pending Validasi (Purple/Indigo to match brand palette variants) --}}
    <div class="bg-[#000878] rounded-xl shadow-sm p-6 text-white transform hover:scale-[1.02] transition-transform duration-300">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-blue-100 text-sm font-medium mb-1">Menunggu Validasi</p>
                <h3 class="text-3xl font-bold">{{ number_format($pendingValidations) }}</h3>
                <div class="text-blue-100 text-xs mt-2">
                    @if($pendingValidations > 0)
                        <span class="font-medium bg-white/20 px-2 py-0.5 rounded text-xs">Butuh Tindakan</span>
                    @else
                        <span>Semua tervalidasi</span>
                    @endif
                </div>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>