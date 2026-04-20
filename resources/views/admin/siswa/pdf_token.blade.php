<!DOCTYPE html>
<html>
<head>
    <title>Kartu Token Akses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        /* Pembungkus utama menggunakan tabel agar tidak bertabrakan */
        .main-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 20px; /* Jarak antar kartu (gap) */
        }
        .main-table td.card-container {
            width: 50%;
            border: 1px dashed #333;
            padding: 15px;
            vertical-align: top;
            border-radius: 5px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .header h3 { margin: 0; font-size: 14px; }
        .header p { margin: 2px 0 0 0; font-size: 10px; }
        
        /* Tabel kecil di dalam kartu untuk merapikan titik dua (:) */
        .info-table {
            width: 100%;
            font-size: 12px;
            line-height: 1.4;
        }
        .info-table td {
            border: none;
            padding: 2px 0;
            vertical-align: top;
        }
        
        .token-box {
            text-align: center;
            margin-top: 15px;
            padding: 5px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .footer {
            text-align: center;
            font-size: 9px;
            margin-top: 10px;
            font-style: italic;
        }
    </style>
</head>
<body>

    <table class="main-table">
        {{-- chunk(2) akan membagi array siswa menjadi kelompok-kelompok berisi 2 orang --}}
        @foreach($students->chunk(2) as $row)
        <tr>
            @foreach($row as $s)
            <td class="card-container">
                <div class="header">
                    <h3>SMP PAWYATAN DAHA 1</h3>
                    <p>KARTU AKSES APLIKASI ORANG TUA</p>
                </div>
                
                <table class="info-table">
                    <tr>
                        <td width="50">Nama</td>
                        <td width="10">:</td>
                        <td><strong>{{ $s->name }}</strong></td>
                    </tr>
                    <tr>
                        <td>NIS</td>
                        <td>:</td>
                        <td>{{ $s->nis }}</td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td>:</td>
                        <td>{{ $s->schoolClass->name ?? '-' }}</td>
                    </tr>
                </table>

                <div class="token-box">
                    TOKEN: {{ $s->token }}
                </div>

                <div class="footer">
                    *Gunakan NIS dan TOKEN ini untuk mendaftar di Aplikasi Android
                </div>
            </td>
            @endforeach
            
            {{-- Jika jumlah siswa ganjil, tambahkan 1 kolom kosong di akhir agar layout tidak error --}}
            @if($row->count() == 1)
                <td style="border: none;"></td>
            @endif
        </tr>
        @endforeach
    </table>

</body>
</html>