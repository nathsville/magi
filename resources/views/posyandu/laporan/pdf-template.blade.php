<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Posyandu - {{ $posyandu->nama_posyandu }}</title>
    <style>
        /* Reset & Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.6;
            color: #333;
            background: #fff;
        }

        /* Page Layout */
        @page {
            margin: 2cm 1.5cm;
            size: A4 portrait;
        }

        .page {
            width: 100%;
            max-width: 210mm;
            margin: 0 auto;
            background: white;
        }

        /* Header Section */
        .header {
            border-bottom: 3px solid #0d9488;
            padding-bottom: 15px;
            margin-bottom: 25px;
            text-align: center;
        }

        .header-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 10px;
        }

        .header h1 {
            font-size: 18pt;
            font-weight: bold;
            color: #0d9488;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header h2 {
            font-size: 14pt;
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
        }

        .header .kop-info {
            font-size: 9pt;
            color: #666;
            line-height: 1.4;
        }

        /* Title Section */
        .title-section {
            text-align: center;
            margin: 30px 0 25px 0;
            padding: 15px;
            background: linear-gradient(135deg, #0d9488 0%, #0891b2 100%);
            color: white;
            border-radius: 8px;
        }

        .title-section h3 {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .title-section .period {
            font-size: 12pt;
            font-weight: normal;
        }

        /* Info Box */
        .info-box {
            background: #f0fdfa;
            border: 2px solid #0d9488;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .info-box table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-box td {
            padding: 6px 10px;
            vertical-align: top;
        }

        .info-box td:first-child {
            width: 180px;
            font-weight: bold;
            color: #0d9488;
        }

        .info-box td:nth-child(2) {
            width: 20px;
            text-align: center;
        }

        /* Section Headers */
        .section-header {
            background: #0d9488;
            color: white;
            padding: 12px 15px;
            margin: 25px 0 15px 0;
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 5px;
        }

        .section-header i {
            margin-right: 8px;
        }

        /* Summary Statistics */
        .summary-stats {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }

        .stat-card {
            display: table-cell;
            width: 25%;
            padding: 15px;
            text-align: center;
            border: 2px solid #e5e7eb;
            vertical-align: top;
        }

        .stat-card .stat-icon {
            font-size: 32pt;
            margin-bottom: 10px;
            display: block;
        }

        .stat-card .stat-label {
            font-size: 9pt;
            color: #666;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .stat-value {
            font-size: 20pt;
            font-weight: bold;
            color: #0d9488;
        }

        .stat-card.blue { border-color: #3b82f6; }
        .stat-card.blue .stat-value { color: #3b82f6; }
        
        .stat-card.green { border-color: #10b981; }
        .stat-card.green .stat-value { color: #10b981; }
        
        .stat-card.orange { border-color: #f59e0b; }
        .stat-card.orange .stat-value { color: #f59e0b; }
        
        .stat-card.red { border-color: #ef4444; }
        .stat-card.red .stat-value { color: #ef4444; }

        /* Breakdown Table */
        .breakdown-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .breakdown-table th,
        .breakdown-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #e5e7eb;
        }

        .breakdown-table th {
            background: #0d9488;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10pt;
        }

        .breakdown-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .breakdown-table tbody tr:hover {
            background: #f0fdfa;
        }

        .breakdown-table td {
            font-size: 10pt;
        }

        .breakdown-table td.number {
            text-align: center;
            font-weight: bold;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-normal {
            background: #d1fae5;
            color: #065f46;
        }

        .status-ringan {
            background: #fef3c7;
            color: #92400e;
        }

        .status-sedang {
            background: #fed7aa;
            color: #9a3412;
        }

        .status-berat {
            background: #fecaca;
            color: #991b1b;
        }

        /* Detail Table */
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 9pt;
        }

        .detail-table th,
        .detail-table td {
            padding: 10px 8px;
            text-align: left;
            border: 1px solid #d1d5db;
        }

        .detail-table th {
            background: #0d9488;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9pt;
        }

        .detail-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .detail-table td {
            vertical-align: middle;
        }

        .detail-table td.center {
            text-align: center;
        }

        .detail-table td.number {
            text-align: right;
        }

        /* Footer Section */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
        }

        .footer-info {
            font-size: 9pt;
            color: #666;
            margin-bottom: 15px;
        }

        .signature-section {
            margin-top: 30px;
            text-align: right;
        }

        .signature-box {
            display: inline-block;
            text-align: center;
            min-width: 200px;
        }

        .signature-title {
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 60px;
        }

        .signature-name {
            font-size: 10pt;
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 5px;
        }

        .signature-nip {
            font-size: 9pt;
            color: #666;
        }

        /* Page Break */
        .page-break {
            page-break-after: always;
        }

        /* Notes Section */
        .notes-section {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }

        .notes-section h4 {
            color: #92400e;
            font-size: 11pt;
            margin-bottom: 8px;
        }

        .notes-section p {
            font-size: 10pt;
            color: #78350f;
            line-height: 1.5;
        }

        /* Chart Placeholder */
        .chart-placeholder {
            width: 100%;
            height: 250px;
            background: #f9fafb;
            border: 2px dashed #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin: 20px 0;
            color: #9ca3af;
            font-size: 10pt;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80pt;
            color: rgba(13, 148, 136, 0.05);
            font-weight: bold;
            z-index: -1;
            pointer-events: none;
        }

        /* Print Specific */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .page-break {
                page-break-after: always;
            }
        }
    </style>
</head>
<body>
    {{-- Watermark --}}
    <div class="watermark">MaGi</div>

    <div class="page">
        {{-- Header / Kop Surat --}}
        <div class="header">
            <div class="header-logo">
                {{-- Logo placeholder - you can add actual logo --}}
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #0d9488, #0891b2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 32pt; font-weight: bold;">
                    🏥
                </div>
            </div>
            <h1>MaGi (Macca Gizi)</h1>
            <h2>Sistem Deteksi Dini dan Monitoring Stunting</h2>
            <div class="kop-info">
                Dinas Pengendalian Penduduk dan Keluarga Berencana Kota Parepare<br>
                Jl. Bau Massepe No. 85, Parepare, Sulawesi Selatan 91123<br>
                Telp: (0421) 21234 | Email: dppkb@pareparekota.go.id
            </div>
        </div>

        {{-- Title Section --}}
        <div class="title-section">
            <h3>Laporan Monitoring Stunting</h3>
            <div class="period">
                Periode: {{ \Carbon\Carbon::createFromFormat('!m', $stats['bulan'])->locale('id')->translatedFormat('F') }} {{ $stats['tahun'] }}
            </div>
        </div>

        {{-- Posyandu Info Box --}}
        <div class="info-box">
            <table>
                <tr>
                    <td>Nama Posyandu</td>
                    <td>:</td>
                    <td>{{ $posyandu->nama_posyandu }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{ $posyandu->alamat }}</td>
                </tr>
                <tr>
                    <td>Kelurahan / Kecamatan</td>
                    <td>:</td>
                    <td>{{ $posyandu->kelurahan }}, {{ $posyandu->kecamatan }}</td>
                </tr>
                <tr>
                    <td>Puskesmas Pembina</td>
                    <td>:</td>
                    <td>{{ $posyandu->puskesmas->nama_puskesmas ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Tanggal Laporan</td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</td>
                </tr>
            </table>
        </div>

        {{-- Section: Ringkasan Statistik --}}
        <div class="section-header">
            📊 RINGKASAN STATISTIK
        </div>

        <table class="summary-stats">
            <tr>
                <td class="stat-card blue">
                    <span class="stat-icon">👶</span>
                    <div class="stat-label">Total Anak</div>
                    <div class="stat-value">{{ $stats['total_anak'] }}</div>
                </td>
                <td class="stat-card">
                    <span class="stat-icon">📏</span>
                    <div class="stat-label">Total Pengukuran</div>
                    <div class="stat-value">{{ $stats['total_pengukuran'] }}</div>
                </td>
                <td class="stat-card green">
                    <span class="stat-icon">✅</span>
                    <div class="stat-label">Normal</div>
                    <div class="stat-value">{{ $stats['normal'] }}</div>
                </td>
                <td class="stat-card red">
                    <span class="stat-icon">⚠️</span>
                    <div class="stat-label">Stunting</div>
                    <div class="stat-value">{{ $stats['total_stunting'] }}</div>
                </td>
            </tr>
        </table>

        {{-- Section: Breakdown Status Gizi --}}
        <div class="section-header">
            📈 BREAKDOWN STATUS GIZI
        </div>

        <table class="breakdown-table">
            <thead>
                <tr>
                    <th>Status Gizi</th>
                    <th style="text-align: center; width: 120px;">Jumlah</th>
                    <th style="text-align: center; width: 120px;">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <span class="status-badge status-normal">Normal</span>
                    </td>
                    <td class="number">{{ $stats['normal'] }}</td>
                    <td class="number">{{ number_format($stats['persentase_normal'], 2) }}%</td>
                </tr>
                <tr>
                    <td>
                        <span class="status-badge status-ringan">Stunting Ringan</span>
                    </td>
                    <td class="number">{{ $stats['stunting_ringan'] }}</td>
                    <td class="number">
                        {{ $stats['total_pengukuran'] > 0 ? number_format(($stats['stunting_ringan'] / $stats['total_pengukuran']) * 100, 2) : 0 }}%
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="status-badge status-sedang">Stunting Sedang</span>
                    </td>
                    <td class="number">{{ $stats['stunting_sedang'] }}</td>
                    <td class="number">
                        {{ $stats['total_pengukuran'] > 0 ? number_format(($stats['stunting_sedang'] / $stats['total_pengukuran']) * 100, 2) : 0 }}%
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="status-badge status-berat">Stunting Berat</span>
                    </td>
                    <td class="number">{{ $stats['stunting_berat'] }}</td>
                    <td class="number">
                        {{ $stats['total_pengukuran'] > 0 ? number_format(($stats['stunting_berat'] / $stats['total_pengukuran']) * 100, 2) : 0 }}%
                    </td>
                </tr>
                <tr style="background: #f0fdfa; font-weight: bold;">
                    <td>TOTAL</td>
                    <td class="number">{{ $stats['total_pengukuran'] }}</td>
                    <td class="number">100.00%</td>
                </tr>
            </tbody>
        </table>

        {{-- Notes Section --}}
        @if($stats['total_stunting'] > 0)
        <div class="notes-section">
            <h4>⚠️ Catatan Penting</h4>
            <p>
                Terdapat <strong>{{ $stats['total_stunting'] }} anak ({{ number_format($stats['persentase_stunting'], 2) }}%)</strong> 
                yang terindikasi stunting pada periode ini. Diperlukan tindak lanjut berupa:
            </p>
            <ul style="margin-top: 8px; margin-left: 20px; font-size: 10pt; color: #78350f;">
                <li>Konseling gizi kepada orang tua</li>
                <li>Pemantauan rutin setiap bulan</li>
                <li>Rujukan ke Puskesmas jika diperlukan</li>
                <li>Pemberian makanan tambahan (PMT)</li>
            </ul>
        </div>
        @endif

        {{-- Page Break --}}
        <div class="page-break"></div>

        {{-- Section: Detail Data Pengukuran --}}
        <div class="section-header">
            📋 DETAIL DATA PENGUKURAN
        </div>

        @if($detailData && $detailData->count() > 0)
        <table class="detail-table">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th style="width: 90px;">Tanggal</th>
                    <th style="width: 130px;">NIK Anak</th>
                    <th>Nama Anak</th>
                    <th style="width: 60px;">Umur</th>
                    <th style="width: 60px;">BB (kg)</th>
                    <th style="width: 60px;">TB (cm)</th>
                    <th style="width: 60px;">LK (cm)</th>
                    <th style="width: 100px;">Status Gizi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detailData as $index => $data)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td class="center">{{ \Carbon\Carbon::parse($data->tanggal_ukur)->format('d/m/Y') }}</td>
                    <td>{{ $data->anak->nik_anak }}</td>
                    <td>{{ $data->anak->nama_anak }}</td>
                    <td class="center">{{ $data->umur_bulan }} bln</td>
                    <td class="number">{{ number_format($data->berat_badan, 1) }}</td>
                    <td class="number">{{ number_format($data->tinggi_badan, 1) }}</td>
                    <td class="number">{{ number_format($data->lingkar_kepala, 1) }}</td>
                    <td class="center">
                        @if($data->stunting)
                            @php
                                $statusClass = 'status-normal';
                                if (str_contains(strtolower($data->stunting->status_stunting), 'berat')) {
                                    $statusClass = 'status-berat';
                                } elseif (str_contains(strtolower($data->stunting->status_stunting), 'sedang')) {
                                    $statusClass = 'status-sedang';
                                } elseif (str_contains(strtolower($data->stunting->status_stunting), 'ringan')) {
                                    $statusClass = 'status-ringan';
                                }
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                {{ $data->stunting->status_stunting }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="chart-placeholder">
            Tidak ada data pengukuran untuk periode ini
        </div>
        @endif

        {{-- Footer --}}
        <div class="footer">
            <div class="footer-info">
                <strong>Keterangan:</strong><br>
                BB = Berat Badan | TB = Tinggi Badan | LK = Lingkar Kepala<br>
                Status Gizi ditentukan berdasarkan perhitungan Z-Score sesuai standar WHO
            </div>

            <div class="signature-section">
                <div class="signature-box">
                    <div class="signature-title">
                        Petugas Posyandu,
                    </div>
                    <div class="signature-name">
                        {{ Auth::user()->nama }}
                    </div>
                    <div class="signature-nip">
                        NIP: {{ Auth::user()->no_telepon ?? '-' }}
                    </div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 30px; font-size: 9pt; color: #9ca3af;">
                Dokumen ini dibuat secara otomatis oleh Sistem MaGi<br>
                Dicetak pada: {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y, H:i') }} WITA
            </div>
        </div>
    </div>
</body>
</html>