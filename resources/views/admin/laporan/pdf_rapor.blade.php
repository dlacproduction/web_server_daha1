<!DOCTYPE html>
<html>
<head>
    <title>Rapor Kelas {{ $kelas->name }}</title>
    <style>
        body { font-family: "Times New Roman", Times, serif; font-size: 12px; color: black; }
        .page-break { page-break-after: always; padding: 20px; }
        
        /* Layout Header sesuai Gambar */
        .info-container { width: 100%; margin-bottom: 20px; }
        .info-left { width: 50%; float: left; }
        .info-right { width: 50%; float: left; }
        .clear { clear: both; }

        table.info-table { border: none; width: 100%; }
        table.info-table td { padding: 2px 0; vertical-align: top; }

        /* Style Tabel Nilai */
        table.grade-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.grade-table th, table.grade-table td { 
            border: 1px solid black; 
            padding: 5px; 
            text-align: center; 
            text-transform: uppercase;
        }
        .text-left { text-align: left !important; padding-left: 10px !important; }
    </style>
</head>
<body>
    @foreach($students as $student)
    <div class="page-break">
        <div class="info-container">
            <div class="info-left">
                <table class="info-table">
                    <tr>
                        <td width="100">NAMA <span style="text-decoration: underline;">SISWA</span></td>
                        <td>: <strong>{{ $student->name }}</strong></td>
                    </tr>
                    <tr>
                        <td>NIS/NISN</td>
                        <td>: {{ $student->nis }} / {{ $student->nisn ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="info-right">
                <table class="info-table">
                    <tr>
                        <td width="120">KELAS</td>
                        {{-- Hapus style="color: blue;" agar warnanya hitam seragam --}}
                        <td>: <strong>{{ $kelas->name }}</strong></td> 
                    </tr>
                    <tr>
                        <td>TAHUN AJARAN</td>
                        <td>: {{ $tapel->year }}</td>
                    </tr>
                    <tr>
                        <td>SEMESTER</td>
                        <td>: {{ $tapel->semester }}</td>
                    </tr>
                </table>
            </div>
            <div class="clear"></div>
        </div>
        
        <table class="grade-table">
            <thead>
                <tr>
                    <th width="30">NO</th>
                    <th>MATA PELAJARAN</th>
                    <th width="60">TUGAS</th>
                    <th width="50">UH 1</th>
                    <th width="50">UH 2</th>
                    <th width="50">UTS</th>
                    <th width="50">UAS</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // 1. Ambil nilai hanya untuk siswa yang sedang di-looping
                    $studentGrades = $allGrades->where('student_id', $student->id);
                    
                    // 2. Kelompokkan berdasarkan mata pelajaran
                    $groupedGrades = $studentGrades->groupBy('subject_id');
                @endphp

                @forelse($groupedGrades as $subjectId => $grades)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $grades->first()->subject->name ?? '-' }}</td>

                    {{-- Gunakan filter agar pengecekan type tidak sensitif terhadap huruf besar/kecil --}}
                    <td>
                        {{ $grades->filter(function($g) { 
                            return strtoupper($g->type) == 'TUGAS'; 
                        })->first()->score ?? '-' }}
                    </td>
                    <td>
                        {{ $grades->filter(function($g) { 
                            return strtoupper($g->type) == 'UH1'; 
                        })->first()->score ?? '-' }}
                    </td>
                    <td>
                        {{ $grades->filter(function($g) { 
                            return strtoupper($g->type) == 'UH2'; 
                        })->first()->score ?? '-' }}
                    </td>
                    <td>
                        {{ $grades->filter(function($g) { 
                            return strtoupper($g->type) == 'UTS'; 
                        })->first()->score ?? '-' }}
                    </td>
                    <td>
                        {{ $grades->filter(function($g) { 
                            return strtoupper($g->type) == 'UAS'; 
                        })->first()->score ?? '-' }}
                    </td>
                </tr>
                @empty
                {{-- Jika benar-benar tidak ada data nilai --}}
                <tr>
                    <td colspan="7" style="padding: 20px;">Belum ada data nilai yang diinput untuk tahun ajaran ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endforeach
</body>
</html>