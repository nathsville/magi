<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $laporan->jenis_laporan }} - {{ \Carbon\Carbon::create($laporan->periode_tahun, $laporan->periode_bulan)->format('F Y') }}</title>
    <style>
        @page {
            margin: 2cm;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11pt;
            line-height: 1.6;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #000878;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18pt;
            color: #000878;
        }
        
        .header p {
            margin: 5px 0;
            font-size: 10pt;
            color: #666;
        }
        
        .info-box {
            background-color: #f0f0f0;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .info-box table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .info-box td {
            padding: 5px;
        }
        
        .info-box td:first-child {
            font-weight: bold;
            width: 40%;
        }
        
        .stats-container {
            display: table;
            width: 100%;
            margin: 20px 0;
        }
        
        .stat-box {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            padding: 15px;
            border: 2px solid #ddd;
        }
        
        .stat-box.total {
            background-color: #e3f2fd;
            border-color: #2196F3;
        }
        
        .stat-box.normal {
            background-color: #e8f5e9;
            border-color: #4CAF50;
        }
        
        .stat-box.stunting {
            background-color: #ffebee;
            border-color: #f44336;
        }
        
        .stat-box .label {
            font-size: 9pt;
            color: #666;
            margin-bottom: 5px;
        }
        
        .stat-box .value {
            font-size: 24pt;
            font-weight: bold;
        }
        
        .stat-box .subtext {
            font-size: 8pt;
            color: #666;
            margin-top: 3px;
        }
        
        .section-title {
            font-size: 14pt;
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid #000878;
            color: #000878;
        }
        
        .progress-bar {
            width: 100%;
            height: 30px;
            background-color: #e0e0e0;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
        }
        
        .progress-fill {
            height: 100%;
            text-align: center;
            line-height: 30px;
            color: white;
            font-weight: bold;
        }
        
        .progress-fill.low {
            background-color: #4CAF50;
        }
        
        .progress-fill.medium {
            background-color: #FF9800;
        }
        
        .progress-fill.high {
            background-color: #f44336;
        }
        
        .conclusion {
            background-color: #f9f9f9;
            padding: 20px;
            margin: 20px 0;
            border-left: 5px solid #000878;
        }
        
        .recommendation {
            margin: 15px 0;
        }
        
        .recommendation ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        
        .recommendation li {
            margin: 5px 0;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        
        .signature-box {
            text-align: right;
            margin-top: 30px;
        }
        
        .signature-box p {
            margin: 5px 0;
        }
        
        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #333;
            width: 200px;
            margin-left: auto;
        }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        <h1>{{ $laporan->jenis_laporan }}</h1>
        <p>SISTEM DETEKSI DINI DAN MONITORING STUNTING</p>
        <p><strong>Periode: {{ \Carbon\Carbon::create($laporan->periode_tahun, $laporan->periode_bulan)->format('F Y') }}</strong></p>
    </div>

    {{-- Info Laporan --}}
    <div class="info-box">
        <table>
            <tr>
                <td>Jenis Laporan</td>
                <td>: {{ $laporan->jenis_laporan }}</td>
            </tr>
            <tr>
                <td>Periode</td>
                <td>: {{ \Carbon\Carbon::create($laporan->periode_tahun, $laporan->periode_bulan)->format('F Y') }}</td>
            </tr>
            <tr>
                <td>Wilayah</td>
                <td>: {{ $laporan->tipe_wilayah }}</td>
            </tr>
            <tr>
                <td>Tanggal Dibuat</td>
                <td>: {{ \Carbon\Carbon::parse($laporan->tanggal_buat)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Pembuat Laporan</td>
                <td>: {{ $laporan->pembuat->nama ?? 'N/A' }} ({{ $laporan->pembuat->role ?? 'N/A' }})</td>
            </tr>
        </table>
    </div>

    {{-- Statistik --}}
    <div class="section-title">RINGKASAN STATISTIK</div>
    
    <div class="stats-container">
        <div class="stat-box total">
            <div class="label">Total Anak Terdata</div>
            <div class="value">{{ $laporan->total_anak }}</div>
        </div>
        <div class="stat-box normal">
            <div class="label">Status Normal</div>
            <div class="value">{{ $laporan->total_normal }}</div>
            <div class="subtext">
                {{ $laporan->total_anak > 0 ? number_format(($laporan->total_normal / $laporan->total_anak) * 100, 1) : 0 }}% dari total
            </div>
        </div>
        <div class="stat-box stunting">
            <div class="label">Terindikasi Stunting</div>
            <div class="value">{{ $laporan->total_stunting }}</div>
            <div class="subtext">{{ number_format($laporan->persentase_stunting, 1) }}% dari total</div>
        </div>
    </div>

    {{-- Persentase Stunting --}}
    <div class="section-title">PERSENTASE STUNTING</div>
    <div class="progress-bar">
        <div class="progress-fill {{ $laporan->persentase_stunting >= 30 ? 'high' : ($laporan->persentase_stunting >= 20 ? 'medium' : 'low') }}" 
            style="width: {{ min($laporan->persentase_stunting, 100) }}%">
            {{ number_format($laporan->persentase_stunting, 1) }}%
        </div>
    </div>
    <p style="text-align: center; margin-top: 10px; font-size: 9pt; color: #666;">
        <strong style="color: #4CAF50;">■</strong> Baik (&lt;20%) &nbsp;&nbsp;
        <strong style="color: #FF9800;">■</strong> Sedang (20-30%) &nbsp;&nbsp;
        <strong style="color: #f44336;">■</strong> Tinggi (≥30%)
    </p>

    {{-- Kesimpulan --}}
    <div class="section-title">KESIMPULAN & REKOMENDASI</div>
    <div class="conclusion">
        <p>
            Berdasarkan data pengukuran periode <strong>{{ \Carbon\Carbon::create($laporan->periode_tahun, $laporan->periode_bulan)->format('F Y') }}</strong>, 
            dari <strong>{{ $laporan->total_anak }} anak</strong> yang terdata, 
            <strong>{{ $laporan->total_stunting }} anak ({{ number_format($laporan->persentase_stunting, 1) }}%)</strong> 
            terindikasi mengalami stunting.
        </p>

        @if($laporan->persentase_stunting >= 30)
            <p style="background-color: #ffebee; padding: 10px; border-left: 4px solid #f44336; margin: 15px 0;">
                <strong>⚠️ Status: KRITIS</strong><br>
                Persentase stunting sangat tinggi (≥30%). Diperlukan intervensi intensif dan program percepatan penanganan stunting secara menyeluruh.
            </p>
        @elseif($laporan->persentase_stunting >= 20)
            <p style="background-color: #fff3e0; padding: 10px; border-left: 4px solid #FF9800; margin: 15px 0;">
                <strong>⚠️ Status: PERLU PERHATIAN</strong><br>
                Persentase stunting berada di level sedang (20-30%). Perlu peningkatan program edukasi gizi dan monitoring berkala.
            </p>
        @else
            <p style="background-color: #e8f5e9; padding: 10px; border-left: 4px solid #4CAF50; margin: 15px 0;">
                <strong>✓ Status: BAIK</strong><br>
                Persentase stunting masih terkendali (&lt;20%). Pertahankan program pencegahan dan monitoring rutin.
            </p>
        @endif

        <div class="recommendation">
            <p><strong>Rekomendasi Tindak Lanjut:</strong></p>
            <ul>
                <li>Intensifkan program PMT (Pemberian Makanan Tambahan) untuk anak stunting</li>
                <li>Lakukan konseling gizi kepada orang tua secara berkala</li>
                <li>Tingkatkan koordinasi antara Posyandu, Puskesmas, dan DPPKB</li>
                <li>Monitoring dan evaluasi program intervensi setiap bulan</li>
                @if($laporan->persentase_stunting >= 20)
                    <li>Rujuk kasus stunting berat ke fasilitas kesehatan yang lebih lengkap</li>
                @endif
            </ul>
        </div>
    </div>

    {{-- Footer & Signature --}}
    <div class="footer">
        <div class="signature-box">
            <p>Parepare, {{ \Carbon\Carbon::parse($laporan->tanggal_buat)->format('d F Y') }}</p>
            <p>Pembuat Laporan,</p>
            <div class="signature-line"></div>
            <p><strong>{{ $laporan->pembuat->nama ?? 'N/A' }}</strong></p>
            <p>{{ $laporan->pembuat->role ?? 'N/A' }}</p>
        </div>
    </div>
</body>
</html>