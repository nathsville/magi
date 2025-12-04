<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-[#000878]">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <input type="checkbox" id="selectAll" 
                    class="w-5 h-5 text-blue-600 bg-white border-gray-300 rounded focus:ring-2 focus:ring-blue-500 cursor-pointer">
                <label for="selectAll" class="text-sm font-medium text-white cursor-pointer select-none">
                    Pilih Semua
                </label>
                <span id="selectedCount" class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-white/20 text-white hidden border border-white/30">
                    <span id="selectedCountNumber">0</span> data dipilih
                </span>
            </div>
            
            <div id="bulkActions" class="flex items-center space-x-2 hidden">
                <button onclick="bulkValidate('Validated')" 
                    class="flex items-center px-3 py-1.5 text-xs font-medium text-green-700 bg-green-50 hover:bg-green-100 rounded-lg transition border border-green-200 shadow-sm">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Validasi Terpilih
                </button>
                <button onclick="bulkValidate('Rejected')" 
                    class="flex items-center px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition border border-red-200 shadow-sm">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Tolak Terpilih
                </button>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-center w-12">
                        <span class="sr-only">Checkbox</span>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Data Anak
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Pengukuran
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Status Gizi
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Posyandu
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Tanggal Ukur
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pendingData as $data)
                <tr class="hover:bg-gray-50 transition group" data-id="{{ $data->id_stunting }}">
                    <td class="px-6 py-4 text-center">
                        <input type="checkbox" class="row-checkbox w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer" 
                            value="{{ $data->id_stunting }}">
                    </td>
                    
                    {{-- Data Anak --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center font-bold text-sm border border-blue-100">
                                {{ substr($data->dataPengukuran->anak->nama_anak, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-gray-900 group-hover:text-blue-700 transition-colors">
                                    {{ $data->dataPengukuran->anak->nama_anak }}
                                </div>
                                <div class="text-xs text-gray-500 mt-0.5 flex items-center space-x-2">
                                    <span class="bg-gray-100 px-1.5 py-0.5 rounded text-gray-600">
                                        {{ $data->dataPengukuran->anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                    <span>•</span>
                                    <span>{{ $data->dataPengukuran->umur_bulan }} bln</span>
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- Pengukuran --}}
                    <td class="px-6 py-4 text-center">
                        <div class="inline-flex flex-col space-y-1 text-xs">
                            <div class="bg-gray-50 px-2 py-1 rounded border border-gray-100">
                                <span class="text-gray-500 mr-1">BB:</span>
                                <span class="font-semibold text-gray-900">{{ number_format($data->dataPengukuran->berat_badan, 1) }} kg</span>
                            </div>
                            <div class="bg-gray-50 px-2 py-1 rounded border border-gray-100">
                                <span class="text-gray-500 mr-1">TB:</span>
                                <span class="font-semibold text-gray-900">{{ number_format($data->dataPengukuran->tinggi_badan, 1) }} cm</span>
                            </div>
                        </div>
                    </td>

                    {{-- Z-Score & Status --}}
                    <td class="px-6 py-4 text-center">
                        <div class="flex flex-col items-center space-y-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold
                                {{ $data->status_stunting === 'Normal' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $data->status_stunting === 'Stunting Ringan' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $data->status_stunting === 'Stunting Sedang' ? 'bg-orange-100 text-orange-800' : '' }}
                                {{ $data->status_stunting === 'Stunting Berat' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $data->status_stunting }}
                            </span>
                            <div class="text-xs text-gray-500">
                                Z-Score: <span class="font-mono font-medium {{ $data->zscore_tb_u < -2 ? 'text-red-600' : 'text-gray-700' }}">
                                    {{ number_format($data->zscore_tb_u, 2) }}
                                </span>
                            </div>
                        </div>
                    </td>

                    {{-- Posyandu --}}
                    <td class="px-6 py-4 text-center">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $data->dataPengukuran->posyandu->nama_posyandu }}
                        </div>
                        <div class="text-xs text-gray-500">
                            Kel. {{ $data->dataPengukuran->posyandu->kelurahan }}
                        </div>
                    </td>

                    {{-- Tanggal --}}
                    <td class="px-6 py-4 text-center">
                        <div class="text-sm text-gray-900 font-medium">
                            {{ \Carbon\Carbon::parse($data->dataPengukuran->tanggal_ukur)->format('d M Y') }}
                        </div>
                        <div class="text-xs text-gray-500 mt-0.5">
                            {{ $data->created_at->diffForHumans() }}
                        </div>
                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <button onclick="quickValidate({{ $data->id_stunting }}, 'Validated')" 
                                class="p-1.5 text-green-600 bg-green-50 hover:bg-green-100 rounded-lg border border-green-200 transition"
                                title="Validasi">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </button>
                            
                            <button onclick="quickValidate({{ $data->id_stunting }}, 'Rejected')" 
                                class="p-1.5 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg border border-red-200 transition"
                                title="Tolak">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>

                            <div class="w-px h-4 bg-gray-300 mx-1"></div>

                            <a href="{{ route('puskesmas.validasi.detail', $data->id_stunting) }}" 
                                class="p-1.5 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-200 transition"
                                title="Detail Lengkap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center bg-gray-50/50">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-gray-900 font-semibold text-lg">Tidak Ada Data Pending</h3>
                            <p class="text-gray-500 text-sm mt-1">Semua data stunting sudah divalidasi dengan baik.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($pendingData->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        {{ $pendingData->links() }}
    </div>
    @endif
</div>