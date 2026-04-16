<!DOCTYPE html>
<html>
<head>
    <title>Laporan Presensi</title>
    <style>
        @page {
            margin: 25px 35px; /* Margin atas-bawah 25px, kiri-kanan 35px */
        }
        body { font-family: sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 3px 4px; text-align: center; word-wrap: break-word;}
        .text-left { text-align: left; }
        .footer-sign {
            margin-top: 30px;
            width: 100%;
        }
        .sign-table {
            width: 100%;
            border: none;
        }
        .sign-table td {
            border: none;
            text-align: center;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin:0;">SMP PAWYATAN DAHA 1 KEDIRI</h2>
        <p style="margin:5px 0; font-weight: bold;">LAPORAN PRESENSI SISWA</p>
        <p style="margin:0;">
            Kelas: <strong>{{ $nama_kelas }}</strong> | 
            Tahun Ajaran: <strong>{{ $tahun_ajaran }}</strong> | 
            Semester: <strong>{{ $semester }}</strong> | 
            Bulan: <strong>{{ $bulan_nama }}</strong>
        </p>
    </div>

    <table>
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th width="30">No</th>
                <th width="90">NIS</th>
                <th>Nama Siswa</th>
                <th width="40">H</th>
                <th width="40">S</th>
                <th width="40">I</th>
                <th width="40">A</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $s)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $s->nis }}</td>
                <td class="text-left">{{ $s->name }}</td>
                
                {{-- Logika hitung: Pastikan 'status' di DB sama dengan teks di bawah (Hadir/Sakit/Izin/Alfa) --}}
                <td>{{ $attendances->where('student_id', $s->id)->where('status', 'H')->count() }}</td>
                <td>{{ $attendances->where('student_id', $s->id)->where('status', 'S')->count() }}</td>
                <td>{{ $attendances->where('student_id', $s->id)->where('status', 'I')->count() }}</td>
                <td>{{ $attendances->where('student_id', $s->id)->where('status', 'A')->count() }}</td>
            </tr>
            
            @endforeach
        </tbody>
    </table>
    <div class="footer-sign">
        <table class="sign-table">
            <tr>
                <td width="60%"></td>
                <td width="40%">
                    <p>Kediri, .......................................</p>
                    <p style="margin-top: 5px;">Guru Mata Pelajaran</p>
                    <br><br><br>
                    <p>(................................................)</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>