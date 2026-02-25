<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Jurnal Mengajar Guru</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
        }
        .meta {
            margin-bottom: 20px;
        }
        .badge {
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 10px;
            color: #fff;
        }
        .badge-draft { background-color: #6c757d; }
        .badge-sent { background-color: #ffc107; color: #000; }
        .badge-verified { background-color: #28a745; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Jurnal Mengajar Guru</h1>
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    </div>

    @if(!empty($filters))
    <div class="meta">
        <p><strong>Filter:</strong></p>
        <ul>
            @if(!empty($filters['start_date'])) <li>Dari Tanggal: {{ \Carbon\Carbon::parse($filters['start_date'])->format('d/m/Y') }}</li> @endif
            @if(!empty($filters['end_date'])) <li>Sampai Tanggal: {{ \Carbon\Carbon::parse($filters['end_date'])->format('d/m/Y') }}</li> @endif
            @if(!empty($filters['status'])) <li>Status: {{ ucfirst($filters['status']) }}</li> @endif
        </ul>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Guru</th>
                <th>Kelas</th>
                <th>Mapel</th>
                <th>Materi</th>
                <th>Kehadiran (H/TH)</th>
                <th>Status</th>
                <th>Verifikator</th>
            </tr>
        </thead>
        <tbody>
            @foreach($journals as $journal)
            <tr>
                <td>{{ $journal->date->format('d/m/Y') }}</td>
                <td>{{ $journal->teacher->nama_lengkap ?? '-' }}</td>
                <td>{{ $journal->classroom->nama_kelas ?? '-' }}</td>
                <td>{{ $journal->subject->nama ?? '-' }}</td>
                <td>{{ $journal->topic }}<br><small>{{ $journal->method }}</small></td>
                <td>{{ $journal->present_count }} / {{ $journal->absent_count }}</td>
                <td>
                    <span class="badge badge-{{ $journal->status }}">
                        {{ ucfirst($journal->status) }}
                    </span>
                </td>
                <td>
                    {{ $journal->verifier->name ?? '-' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
