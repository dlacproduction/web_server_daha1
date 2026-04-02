<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Kelas {{ $kelas->name }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .text-center { text-align: center; }
        .title { margin-bottom: 20px; text-transform: uppercase; font-size: 18px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .mapel { font-weight: bold; display: block; margin-bottom: 4px; font-size: 14px; }
        .guru { font-size: 10px; color: #333; }
        .kosong { background-color: #f9f9f9; color: #ccc; }
    </style>
</head>
<body>

    <h2 class="text-center title">Jadwal Pelajaran Kelas {{ $kelas->name }}<br>SMP Pawyatan Daha 1 Kediri</h2>

    <table>
        @php 
            $max_jam = 10; 
            $waktu_jam = [
                1 => '07:00 - 07:40', 2 => '07:40 - 08:20', 3 => '08:20 - 09:00',
                4 => '09:00 - 09:40', 5 => '10:00 - 10:40', 6 => '10:40 - 11:20',
                7 => '11:20 - 12:00', 8 => '12:30 - 13:10', 9 => '13:10 - 13:50',
                10 => '13:50 - 14:30',
            ];
        @endphp
        <thead>
            <tr>
                <th width="10%">HARI</th>
                @for($i = 1; $i <= $max_jam; $i++)
                    <th>
                        <div style="font-size: 14px;">{{ $i }}</div>
                        <div style="font-size: 8px; font-weight: normal; color: #555;">{{ $waktu_jam[$i] ?? '' }}</div>
                    </th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                <tr>
                    <td style="font-weight: bold; background-color: #f2f2f2;">{{ $day }}</td>
                    
                    @php
                        $today_schedules = isset($schedules[$day]) ? $schedules[$day] : collect();
                        $current_jam = 1;
                    @endphp

                    @while($current_jam <= $max_jam)
                        @php
                            $jadwal = $today_schedules->where('jam_mulai', $current_jam)->first();
                        @endphp

                        @if($jadwal)
                            @php $colspan = ($jadwal->jam_selesai - $jadwal->jam_mulai) + 1; @endphp
                            
                            <td colspan="{{ $colspan }}">
                                <span class="mapel">{{ $jadwal->subject->kode_mapel ?? '???' }}</span>
                                <span class="guru">{{ $jadwal->teacher->name ?? '-' }}</span>
                            </td>

                            @php $current_jam = $jadwal->jam_selesai + 1; @endphp
                        @else
                            <td class="kosong">-</td>
                            @php $current_jam++; @endphp
                        @endif
                    @endwhile
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>