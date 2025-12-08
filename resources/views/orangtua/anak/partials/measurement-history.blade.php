<div class="bg-white rounded-2xl shadow-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold text-gray-800">
            <i class="fas fa-history text-purple-600 mr-2"></i>Riwayat Pengukuran
        </h3>
        <span class="text-sm text-gray-500">{{ $riwayatPengukuran->count() }} Pengukuran</span>
    </div>

    @if($riwayatPengukuran->isEmpty())
        <div class="text-center py-12">
            <i class="fas fa-clipboard-list text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500">Belum ada riwayat pengukuran</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Tanggal</th>
                        <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Umur</th>
                        <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">BB (kg)</th>
                        <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">TB (cm)</th>
                        <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">LK (cm)</th>
                        <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">LL (cm)</th>
                        <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayatPengukuran->reverse() as $pengukuran)
                    <tr class="border-b border-gray-100 hover:bg-purple-50 transition">
                        <td class="py-3 px-4 text-sm text-gray-800">
                            {{ \Carbon\Carbon::parse($pengukuran->tanggal_ukur)->format('d M Y') }}
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-600 text-center">
                            {{ $pengukuran->umur_bulan }} bln
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-800 text-center font-medium">
                            {{ number_format($pengukuran->berat_badan, 1) }}
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-800 text-center font-medium">
                            {{ number_format($pengukuran->tinggi_badan, 1) }}
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-600 text-center">
                            {{ number_format($pengukuran->lingkar_kepala, 1) }}
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-600 text-center">
                            {{ number_format($pengukuran->lingkar_lengan, 1) }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            @if($pengukuran->stunting)
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $pengukuran->stunting->status_stunting === 'Normal' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                    {{ $pengukuran->stunting->status_stunting }}
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                                    Belum dianalisis
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>