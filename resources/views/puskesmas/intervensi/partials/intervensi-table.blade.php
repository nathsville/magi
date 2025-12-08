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
                        Jenis Intervensi
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Tanggal & Penanggung Jawab
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($intervensiList as $index => $intervensi)
                <tr class="hover:bg-gray-50 transition">
                    {{-- No --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $intervensiList->firstItem() + $index }}
                    </td>

                    {{-- Data Anak --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($intervensi->anak->nama_anak, 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $intervensi->anak->nama_anak }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $intervensi->anak->jenis_kelamin === 'L' ? '👦 Laki-laki' : '👧 Perempuan' }} • 
                                    {{ \Carbon\Carbon::parse($intervensi->anak->tanggal_lahir)->diffInMonths(now()) }} bulan
                                </p>
                            </div>
                        </div>
                    </td>

                    {{-- Jenis Intervensi --}}
                    <td class="px-6 py-4">
                        <div class="space-y-1">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $intervensi->jenis_intervensi === 'PMT' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $intervensi->jenis_intervensi === 'Suplemen/Vitamin' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $intervensi->jenis_intervensi === 'Edukasi Gizi' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $intervensi->jenis_intervensi === 'Rujukan RS' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $intervensi->jenis_intervensi === 'Konseling' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $intervensi->jenis_intervensi === 'Lainnya' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ $intervensi->jenis_intervensi }}
                            </span>
                            @if($intervensi->dosis_jumlah)
                                <p class="text-xs text-gray-600">{{ $intervensi->dosis_jumlah }}</p>
                            @endif
                        </div>
                    </td>

                    {{-- Tanggal & Penanggung Jawab --}}
                    <td class="px-6 py-4">
                        <div class="text-sm">
                            <p class="font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($intervensi->tanggal_pelaksanaan)->format('d M Y') }}
                            </p>
                            @if($intervensi->petugas)
                                <p class="text-xs text-gray-500 mt-1">
                                    PJ: {{ $intervensi->petugas->nama }}
                                </p>
                            @endif
                        </div>
                    </td>

                    {{-- Status --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                            {{ $intervensi->status_tindak_lanjut === 'Sedang Berjalan' ? 'bg-orange-100 text-orange-800' : '' }}
                            {{ $intervensi->status_tindak_lanjut === 'Selesai' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $intervensi->status_tindak_lanjut === 'Perlu Rujukan Lanjutan' ? 'bg-red-100 text-red-800' : '' }}">
                            @if($intervensi->status_tindak_lanjut === 'Sedang Berjalan')
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            @elseif($intervensi->status_tindak_lanjut === 'Selesai')
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            @else
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                            {{ $intervensi->status_tindak_lanjut }}
                        </span>
                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('puskesmas.intervensi.edit', $intervensi->id_intervensi) }}" 
                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-primary rounded-lg hover:bg-blue-700 transition">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                            
                            @if($intervensi->file_pendukung)
                                <a href="{{ asset('storage/' . $intervensi->file_pendukung) }}" target="_blank"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                    </svg>
                                    File
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <p class="text-gray-500 text-lg font-medium">Tidak ada data intervensi</p>
                        <p class="text-gray-400 text-sm mt-2">Gunakan filter untuk mencari data atau tambah intervensi baru</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($intervensiList->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $intervensiList->links() }}
    </div>
    @endif
</div>