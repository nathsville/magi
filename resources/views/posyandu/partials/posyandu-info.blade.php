<div class="bg-[#000878] rounded-xl shadow-lg p-6 text-white relative overflow-hidden">
    {{-- Background Elements --}}
    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-10 -mt-10 blur-xl"></div>
    <div class="absolute bottom-0 left-0 w-24 h-24 bg-blue-500/20 rounded-full -ml-8 -mb-8 blur-lg"></div>

    <div class="relative z-10">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-bold text-lg flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Profil Posyandu
            </h3>
        </div>

        <div class="space-y-4">
            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-blue-200 uppercase tracking-wide">Nama Posyandu</p>
                    <p class="font-bold text-white">{{ $posyandu->nama_posyandu }}</p>
                </div>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-blue-200 uppercase tracking-wide">Wilayah</p>
                    <p class="font-medium text-white text-sm">{{ $posyandu->kelurahan }}, {{ $posyandu->kecamatan }}</p>
                </div>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-blue-200 uppercase tracking-wide">Status</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-500/20 text-green-200 border border-green-500/30 mt-1">
                        {{ $posyandu->status ?? 'Aktif' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-white/10">
            <a href="{{ route('posyandu.profile') }}" class="flex items-center justify-center w-full py-2 bg-white/10 hover:bg-white/20 rounded-lg text-sm font-medium transition text-white">
                Edit Profil
            </a>
        </div>
    </div>
</div>