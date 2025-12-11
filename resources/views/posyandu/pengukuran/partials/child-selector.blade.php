<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-6">
    {{-- Header --}}
    <div class="bg-[#000878] px-6 py-4">
        <h2 class="text-lg font-semibold text-white flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Pilih Anak
        </h2>
    </div>

    <div class="p-6">
        {{-- Search Form --}}
        <form method="GET" action="{{ route('posyandu.pengukuran.form') }}" class="mb-4">
            <div class="relative">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari nama / NIK..."
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#000878] focus:border-[#000878] text-sm transition-colors">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </form>

        {{-- Children List --}}
        <div class="space-y-2 max-h-[500px] overflow-y-auto pr-1 custom-scrollbar">
            @forelse($anakList as $anak)
            <a href="{{ route('posyandu.pengukuran.form', ['id_anak' => $anak->id_anak, 'search' => request('search')]) }}" 
               class="block p-3 rounded-lg border transition group {{ request('id_anak') == $anak->id_anak ? 'border-[#000878] bg-blue-50 ring-1 ring-[#000878]' : 'border-gray-200 hover:border-blue-300 hover:bg-gray-50' }}">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm
                            {{ $anak->jenis_kelamin === 'L' ? 'bg-gradient-to-br from-blue-500 to-blue-600' : 'bg-gradient-to-br from-pink-500 to-pink-600' }}">
                            {{ substr($anak->nama_anak, 0, 1) }}
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-900 truncate text-sm group-hover:text-[#000878] transition-colors">{{ $anak->nama_anak }}</p>
                        <p class="text-xs text-gray-500 font-mono">{{ $anak->nik_anak }}</p>
                        <div class="flex items-center mt-1">
                            <span class="text-[10px] bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded border border-gray-200">
                                {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->age }} th
                            </span>
                        </div>
                    </div>
                    @if(request('id_anak') == $anak->id_anak)
                    <div class="bg-[#000878] text-white rounded-full p-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    @endif
                </div>
            </a>
            @empty
            <div class="text-center py-8 border-2 border-dashed border-gray-200 rounded-lg">
                <p class="text-gray-500 text-sm">Data tidak ditemukan</p>
                @if(request('search'))
                <a href="{{ route('posyandu.pengukuran.form') }}" class="text-[#000878] hover:underline text-xs mt-1 block font-medium">Reset Pencarian</a>
                @endif
            </div>
            @endforelse
        </div>

        {{-- Add Button --}}
        <div class="mt-4 pt-4 border-t border-gray-200">
            <a href="{{ route('posyandu.anak.create') }}" class="flex items-center justify-center w-full px-4 py-2.5 bg-white border border-[#000878] text-[#000878] text-sm font-bold rounded-lg hover:bg-blue-50 transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Daftar Anak Baru
            </a>
        </div>
    </div>
</div>