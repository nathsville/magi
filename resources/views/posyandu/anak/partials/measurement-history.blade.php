<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
        <h3 class="font-bold text-gray-800">Riwayat Pengukuran</h3>
        <span class="px-2.5 py-0.5 bg-white border border-gray-300 rounded text-xs font-medium text-gray-600">
            {{ $riwayatPengukuran->count() }} Data
        </span>
    </div>

    @if($riwayatPengukuran->isEmpty())
        <div class="p-8 text-center">
            <p class="text-gray-500 text-sm">Belum ada riwayat pengukuran.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-white text-gray-500 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 font-medium">Tanggal</th>
                        <th class="px-6 py-3 font-medium text-center">Umur</th>
                        <th class="px-6 py-3 font-medium text-center">BB (kg)</th>
                        <th class="px-6 py-3 font-medium text-center">TB (cm)</th>
                        <th class="px-6 py-3 font-medium text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($riwayatPengukuran as $m)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-3 text-gray-900">
                            {{ \Carbon\Carbon::parse($m->tanggal_ukur)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-3 text-center text-gray-600">
                            @php
                                $tahun = floor($m->umur_bulan / 12);
                                $bulanSisa = floor($m->umur_bulan % 12);
                            @endphp
                            @if($tahun > 0)
                                {{ $tahun }} Thn {{ $bulanSisa }} Bln
                            @else
                                {{ $bulanSisa }} Bln
                            @endif
                        </td>
                        <td class="px-6 py-3 text-center font-medium">{{ number_format($m->berat_badan, 1) }}</td>
                        <td class="px-6 py-3 text-center font-medium">{{ number_format($m->tinggi_badan, 1) }}</td>
                        <td class="px-6 py-3 text-center">
                            @if($m->dataStunting)
                                <span class="px-2 py-1 rounded text-xs font-medium
                                    {{ $m->dataStunting->status_stunting == 'Normal' ? 'bg-green-100 text-green-700' : 
                                    ($m->dataStunting->status_stunting == 'Stunting Berat' ? 'bg-red-100 text-red-700' : 
                                    ($m->dataStunting->status_stunting == 'Stunting Sedang' ? 'bg-orange-100 text-orange-700' : 
                                    'bg-yellow-100 text-yellow-700')) }}">
                                    {{ $m->dataStunting->status_stunting }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>