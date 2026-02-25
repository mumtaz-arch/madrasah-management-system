<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Pelajaran</title>
    <style>
        @page {
            margin: 10px;
            size: A4 landscape;
        }
        body {
            font-family: sans-serif;
            font-size: 10px;
        }
        .container {
            width: 100%;
        }
        .main-table {
            width: 85%;
            float: left;
        }
        .legend-sidebar {
            width: 14%;
            float: right;
            padding-left: 5px;
            border-left: 1px solid #999;
            font-size: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid #444; 
            padding: 0; /* Zero padding for internal alignment */
            vertical-align: top;
            text-align: center;
        }
        th {
            background-color: #2c3e50;
            color: white;
            padding: 4px; 
            font-size: 10px;
            font-weight: bold;
        }
        
        /* Internal Rows */
        .inner-row {
            border-bottom: 1px dotted #ccc;
            padding: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            white-space: nowrap;
        }
        .inner-row:last-child {
            border-bottom: none;
        }

        .code-box {
            font-weight: bold;
            font-size: 9px;
            border-radius: 2px;
            padding: 0 2px;
            display: inline-block;
            width: 100%;
        }
        
        /* Legend */
        .legend-title {
            font-weight: bold;
            border-bottom: 1px solid #ccc;
            margin-top: 5px;
            margin-bottom: 2px;
            font-size: 9px;
            color: #333;
        }
        .legend-item {
            margin-bottom: 1px;
            line-height: 1.1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .kelas-col {
            font-weight: bold; 
            background-color: #e9ecef; 
            font-size: 10px;
            width: 5%;
            vertical-align: middle;
        }
        .waktu-col {
            background-color: #f1f3f5;
            font-size: 8px;
            width: 8%;
            white-space: nowrap;
            color: #333;
        }
    </style>
</head>
<body>
    <div style="text-align: center; margin-bottom: 5px;">
        <h3 style="margin:0; padding:0; font-size: 14px; text-transform: uppercase;">JADWAL PELAJARAN PESANTREN TAHUN AJARAN {{ date('Y') }}/{{ date('Y')+1 }}</h3>
    </div>

    <div class="container clearfix">
        <!-- Main Schedule Table -->
        <div class="main-table">
            @php
                // Dynamic Row Height Calculation
                // Total slots across all classes determine the density.
                // Available height ~510px.
                // We calculate specific height per SLOT, not per Class Row.
                $heightPerSlot = floor(510 / max($totalSlots, 1));
            @endphp
            <table style="height: 510px;">
                <thead>
                    <tr>
                        <th style="width: 5%">KLS</th>
                        <th style="width: 10%">WAKTU</th>
                        @foreach($days as $day)
                            <th>{{ strtoupper($day) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($exportData as $kelasName => $data)
                        @php
                            $slots = $data['slots'];
                            $items = $data['items'];
                            // Calculate height for THIS class row based on its number of slots
                            $classRowHeight = $slots->count() * $heightPerSlot;
                        @endphp
                        <tr style="height: {{ $classRowHeight }}px;">
                            <td class="kelas-col">{{ $kelasName }}</td>
                            
                            <!-- Waktu Column -->
                            <td class="waktu-col">
                                @foreach($slots as $slot)
                                    <div class="inner-row" style="height: {{ $heightPerSlot }}px; line-height: {{ $heightPerSlot }}px;">
                                        {{ $slot }}
                                    </div>
                                @endforeach
                            </td>

                            <!-- Day Columns -->
                            @foreach($days as $day)
                                <td>
                                    @foreach($slots as $slot)
                                        @php
                                            [$start, $end] = explode('-', $slot);
                                            // Matching Logic
                                            $jadwal = $items->filter(function($item) use ($day, $start) {
                                                return $item->hari === $day && $item->jam_mulai->format('H:i') === $start;
                                            })->first();
                                        @endphp

                                        <div class="inner-row" style="height: {{ $heightPerSlot }}px; line-height: {{ $heightPerSlot }}px;">
                                            @if($jadwal)
                                                @php
                                                    $color = $mapelColors[$jadwal->mapel_id] ?? '#fff';
                                                    $code = ($mapelCodes[$jadwal->mapel_id] ?? '??') . ($guruCodes[$jadwal->guru_id] ?? '?');
                                                @endphp
                                                <span class="code-box" style="background-color: {{ $color }};">{{ $code }}</span>
                                            @else
                                                <!-- Spacer for alignment -->
                                                &nbsp;
                                            @endif
                                        </div>
                                    @endforeach
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Sidebar Legend -->
        <div class="legend-sidebar">
            <div class="legend-title">KODE MAPEL</div>
            @foreach(\App\Models\Mapel::orderBy('nama')->get() as $mapel)
                <div class="legend-item">
                    <strong style="background-color: {{ $mapelColors[$mapel->id] ?? '#fff' }}; padding: 0 2px; border: 1px solid #ccc; border-radius: 2px;">
                        {{ $mapelCodes[$mapel->id] ?? '??' }}
                    </strong> : {{ substr($mapel->nama, 0, 20) }}
                </div>
            @endforeach

            <div class="legend-title" style="margin-top: 10px;">KODE GURU</div>
            @foreach(\App\Models\Guru::orderBy('nama_lengkap')->where('status', 'aktif')->get() as $guru)
                <div class="legend-item">
                    <strong>{{ $guruCodes[$guru->id] ?? '?' }}</strong> : {{ substr($guru->nama_lengkap, 0, 20) }}
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
