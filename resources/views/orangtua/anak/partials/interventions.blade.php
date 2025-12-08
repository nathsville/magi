<div class="bg-white rounded-2xl shadow-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-800">
            <i class="fas fa-stethoscope text-purple-600 mr-2"></i>Intervensi
        </h3>
    </div>

    @if($intervensiList->isEmpty())
        <div class="text-center py-8">
            <i class="fas fa-clipboard-check text-gray-300 text-4xl mb-3"></i>
            <p class="text-gray-500 text-sm">Belum ada intervensi</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($intervensiList as $intervensi)
            <div class="p-3 border border-gray-200 rounded-lg hover:bg-purple-50 transition">
                <div class="flex items-start justify-between mb-2">
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                        {{ $intervensi->jenis_intervensi }}
                    </span>
                    <span class="text-xs text-gray-500">
                        {{ \Carbon\Carbon::parse($intervensi->tanggal_pelaksanaan)->format('d M Y') }}
                    </span>
                </div>
                <p class="text-sm text-gray-700 mb-2">{{ Str::limit($intervensi->deskripsi, 80) }}</p>
                @if($intervensi->dosis_jumlah)
                <p class="text-xs text-gray-600">
                    <i class="fas fa-pills mr-1"></i>{{ $intervensi->dosis_jumlah }}
                </p>
                @endif
                <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100">
                    <span class="text-xs text-gray-500">
                        <i class="fas fa-user-md mr-1"></i>{{ $intervensi->petugas->nama ?? 'N/A' }}
                    </span>
                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $intervensi->status_tindak_lanjut === 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                        {{ $intervensi->status_tindak_lanjut }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>