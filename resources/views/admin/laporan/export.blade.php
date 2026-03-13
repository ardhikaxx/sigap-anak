<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan {{ $data['title'] ?? 'SIGAP Anak' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 24px;
            color: #2E7D32;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 14px;
            color: #666;
        }
        .meta {
            margin-bottom: 20px;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 5px;
        }
        .meta strong {
            color: #2E7D32;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background: #4CAF50;
            color: white;
            font-weight: bold;
        }
        table tr:nth-child(even) {
            background: #f9f9f9;
        }
        .summary {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }
        .summary-card {
            flex: 1;
            min-width: 150px;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 5px;
            text-align: center;
            border-left: 4px solid #4CAF50;
        }
        .summary-card h3 {
            font-size: 28px;
            color: #2E7D32;
            margin-bottom: 5px;
        }
        .summary-card p {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-normal { background: #d4edda; color: #155724; }
        .status-stunting { background: #fff3cd; color: #856404; }
        .status-wasting { background: #f8d7da; color: #721c24; }
        .status-underweight { background: #ffeeba; color: #856404; }
        .status-obesitas { background: #f5c6cb; color: #721c24; }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SIGAP Anak</h1>
        <p>Sistem Informasi Gizi dan Pertumbuhan Anak</p>
    </div>

    <div class="meta">
        <strong>Laporan:</strong> {{ $data['title'] ?? '-' }}<br>
        <strong>Periode:</strong> {{ \Carbon\Carbon::create()->month($bulan)->format('F') }} {{ $tahun }}
    </div>

    @if($tipe == 'pemeriksaan')
    <div class="summary">
        <div class="summary-card">
            <h3>{{ $data['total'] ?? 0 }}</h3>
            <p>Total Pemeriksaan</p>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anak</th>
                <th>Tanggal</th>
                <th>Berat (kg)</th>
                <th>Tinggi (cm)</th>
                <th>Status Gizi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data['data'] ?? [] as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->anak->nama ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_periksa)->format('d/m/Y') }}</td>
                <td>{{ $item->berat_badan }}</td>
                <td>{{ $item->tinggi_badan }}</td>
                <td>
                    <span class="status-badge status-{{ $item->status_gizi_akhir ?? 'normal' }}">
                        {{ $item->status_gizi_akhir ?? 'normal' }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @endif

    @if($tipe == 'pertumbuhan')
    <div class="summary">
        <div class="summary-card">
            <h3>{{ $data['rerata_berat'] ?? 0 }}</h3>
            <p>Rata-rata BB (kg)</p>
        </div>
        <div class="summary-card">
            <h3>{{ $data['rerata_tinggi'] ?? 0 }}</h3>
            <p>Rata-rata TB (cm)</p>
        </div>
    </div>
    @endif

    @if($tipe == 'posyandu')
    <div class="summary">
        <div class="summary-card">
            <h3>{{ $data['total_jadwal'] ?? 0 }}</h3>
            <p>Total Jadwal</p>
        </div>
        <div class="summary-card">
            <h3>{{ $data['total_hadir'] ?? 0 }}</h3>
            <p>Total Kehadiran</p>
        </div>
    </div>
    @endif

    @if($tipe == 'konsultasi')
    <div class="summary">
        <div class="summary-card">
            <h3>{{ $data['total'] ?? 0 }}</h3>
            <p>Total</p>
        </div>
        <div class="summary-card">
            <h3>{{ $data['selesai'] ?? 0 }}</h3>
            <p>Selesai</p>
        </div>
        <div class="summary-card">
            <h3>{{ $data['rating_rata'] ?? 0 }}</h3>
            <p>Rating</p>
        </div>
    </div>
    @endif

    @if($tipe == 'gizi')
    <div class="summary">
        <div class="summary-card">
            <h3>{{ $data['total'] ?? 0 }}</h3>
            <p>Total Pemeriksaan</p>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Status Gizi</th>
                <th>Jumlah</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($data['status']))
            @foreach($data['status'] as $status => $jumlah)
            <tr>
                <td>{{ ucfirst(str_replace('_', ' ', $status)) }}</td>
                <td>{{ $jumlah }}</td>
                <td>{{ round($jumlah / max($data['total'], 1) * 100, 1) }}%</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    @endif

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }} - SIGAP Anak
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Cetak / Simpan PDF</button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #666; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">Tutup</button>
    </div>
</body>
</html>
