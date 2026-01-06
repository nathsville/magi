<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-[#000878] px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-bold text-white flex items-center">
            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Riwayat Pengukuran
        </h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Umur</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">BB (kg)</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">TB (cm)</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">LK (cm)</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">LL (cm)</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($riwayatPengukuran->reverse() as $pengukuran)
                <tr class="hover:bg-gray-50 transition">
                    {{-- Tanggal --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                        {{ \Carbon\Carbon::parse($pengukuran->tanggal_ukur)->format('d M Y') }}
                    </td>

                    {{-- Umur (Format: X Thn Y Bln) --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                        @php
                            $umurTotal = (int) $pengukuran->umur_bulan;
                            $tahun = floor($umurTotal / 12);
                            $bulan = $umurTotal % 12;
                        @endphp
                        
                        @if($tahun > 0)
                            <span class="font-bold text-gray-800">{{ $tahun }}</span> Thn
                            <span class="font-bold text-gray-800">{{ $bulan }}</span> Bln
                        @else
                            <span class="font-bold text-gray-800">{{ $bulan }}</span> Bln
                        @endif
                    </td>

                    {{-- Berat Badan --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-semibold">
                        {{ number_format($pengukuran->berat_badan, 1) }}
                    </td>

                    {{-- Tinggi Badan --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-semibold">
                        {{ number_format($pengukuran->tinggi_badan, 1) }}
                    </td>

                    {{-- Lingkar Kepala --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                        {{ number_format($pengukuran->lingkar_kepala, 1) }}
                    </td>

                    {{-- Lingkar Lengan --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                        {{ number_format($pengukuran->lingkar_lengan, 1) }}
                    </td>

                    {{-- Status (Disesuaikan dengan Controller: dataStunting) --}}
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @php
                            // MENGGUNAKAN 'dataStunting' SESUAI CONTROLLER
                            $statusObject = $pengukuran->dataStunting; 
                            $statusLabel = $statusObject ? $statusObject->status_stunting : null;
                            $isNormal = $statusLabel === 'Normal';
                        @endphp

                        @if($statusLabel)
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full border
                                {{ $isNormal ? 'bg-green-50 text-green-700 border-green-200' : 'bg-orange-50 text-orange-700 border-orange-200' }}">
                                {{ $statusLabel }}
                            </span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600 border border-gray-200">
                                -
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">
                        Belum ada riwayat pengukuran
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>