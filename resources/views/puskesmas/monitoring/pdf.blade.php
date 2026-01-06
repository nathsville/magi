<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Stunting</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; font-size: 11px; }
        th { background-color: #f0f0f0; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; color: #555; }
        .badge { padding: 2px 5px; border-radius: 3px; font-size: 10px; font-weight: bold; }
        .stunting { color: red; }
        .normal { color: green; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Data Stunting</h2>
        <p>Puskesmas: {{ $puskesmas->nama_puskesmas }}</p>
        <p>Dicetak Tanggal: {{ date('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 20%">Nama Anak</th>
                <th style="width: 5%">JK</th>
                <th style="width: 15%">Umur</th>
                <th style="width: 10%">BB / TB</th>
                <th style="width: 10%">Z-Score</th>
                <th style="width: 15%">Status Gizi</th>
                <th style="width: 20%">Posyandu / Tgl</th>
            </tr>
        </thead>
        <tbody>
            @foreach($exportData as $index => $data)
            @php
                // Logika Format Umur di Blade
                $umurTotal = $data->dataPengukuran->umur_bulan;
                $thn = floor($umurTotal / 12);
                $bln = round(fmod($umurTotal, 12));
                if ($bln == 12) { $thn += 1; $bln = 0; }
                
                $strUmur = '';
                if ($thn > 0) $strUmur .= $thn . ' Thn ';
                if ($bln > 0 || $thn == 0) $strUmur .= $bln . ' Bln';
            @endphp
            <tr>
                <td style="text-align: center">{{ $index + 1 }}</td>
                <td>
                    <b>{{ $data->dataPengukuran->anak->nama_anak ?? 'Data Terhapus' }}</b>
                </td>
                <td>{{ $data->dataPengukuran->anak->jenis_kelamin ?? '-' }}</td>
                <td>{{ trim($strUmur) }}</td> {{-- Hasil Format Umur --}}
                <td>
                    {{ (float)$data->dataPengukuran->berat_badan }} kg <br>
                    {{ (float)$data->dataPengukuran->tinggi_badan }} cm
                </td>
                <td>{{ number_format($data->zscore_tb_u, 2) }}</td>
                <td>
                    <span class="{{ $data->zscore_tb_u < -2 ? 'stunting' : 'normal' }}">
                        {{ $data->status_stunting }}
                    </span>
                </td>
                <td>
                    {{ $data->dataPengukuran->posyandu->nama_posyandu ?? '-' }} <br>
                    <span style="font-size: 9px; color: #666;">
                        {{ \Carbon\Carbon::parse($data->dataPengukuran->tanggal_ukur)->format('d/m/Y') }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>