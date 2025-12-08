<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        No
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Data Anak
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        NIK & Lahir
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Umur
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Orang Tua
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Posyandu
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($anakList as $index => $anak)
                <tr class="hover:bg-gray-50 transition">
                    {{-- No --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $anakList->firstItem() + $index }}
                    </td>

                    {{-- Data Anak --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg
                                {{ $anak->jenis_kelamin === 'L' ? 'bg-gradient-to-br from-blue-400 to-blue-600' : 'bg-gradient-to-br from-pink-400 to-pink-600' }}">
                                {{ strtoupper(substr($anak->nama_anak, 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $anak->nama_anak }}
                                </p>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                        {{ $anak->jenis_kelamin === 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                        {{ $anak->jenis_kelamin === 'L' ? '👦 Laki-laki' : '👧 Perempuan' }}
                                    </span>
                                    @if($anak->anak_ke)
                                        <span class="text-xs text-gray-500">Anak ke-{{ $anak->anak_ke }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- NIK & Lahir --}}
                    <td class="px-6 py-4">
                        <div class="text-sm">
                            <p class="font-medium text-gray-900">{{ $anak->nik_anak }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d M Y') }}
                            </p>
                            @if($anak->tempat_lahir)
                                <p class="text-xs text-gray-500">{{ $anak->tempat_lahir }}</p>
                            @endif
                        </div>
                    </td>

                    {{-- Umur --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $umurBulan = \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now());
                            $tahun = floor($umurBulan / 12);
                            $bulan = $umurBulan % 12;
                        @endphp
                        <div class="text-sm">
                            <p class="font-semibold text-gray-900">{{ $tahun }} tahun {{ $bulan }} bulan</p>
                            <p class="text-xs text-gray-500">({{ $umurBulan }} bulan)</p>
                        </div>
                    </td>

                    {{-- Orang Tua --}}
                    <td class="px-6 py-4">
                        <div class="text-sm">
                            @if($anak->orangTua)
                                <p class="font-medium text-gray-900">
                                    {{ $anak->orangTua->nama_ayah ?? $anak->orangTua->nama_ibu }}
                                </p>
                                @if($anak->orangTua->no_telepon)
                                    <p class="text-xs text-gray-500 mt-1">
                                        📱 {{ $anak->orangTua->no_telepon }}
                                    </p>
                                @endif
                            @else
                                <p class="text-xs text-gray-400">Data tidak tersedia</p>
                            @endif
                        </div>
                    </td>

                    {{-- Posyandu --}}
                    <td class="px-6 py-4">
                        @if($anak->posyandu)
                            <div class="text-sm">
                                <p class="font-medium text-gray-900">{{ $anak->posyandu->nama_posyandu }}</p>
                                @if($anak->posyandu->kelurahan)
                                    <p class="text-xs text-gray-500">{{ $anak->posyandu->kelurahan }}</p>
                                @endif
                            </div>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Belum Terdaftar
                            </span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('puskesmas.anak.edit', $anak->id_anak) }}" 
                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-primary rounded-lg hover:bg-blue-700 transition">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <p class="text-gray-500 text-lg font-medium">Tidak ada data anak</p>
                        <p class="text-gray-400 text-sm mt-2">Gunakan filter untuk mencari data atau ubah pencarian</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($anakList->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $anakList->links() }}
    </div>
    @endif
</div>