@extends('layout.app')

@section('styles')
<style>
    /* Styling khusus agar tabel terlihat seperti aplikasi aSc Timetables */
    .table-jadwal th, .table-jadwal td {
        border: 2px solid #e2e8f0;
        text-align: center;
        vertical-align: middle;
        height: 60px;
    }
    .table-jadwal th {
        background-color: #f8fafc;
        font-weight: 600;
        color: #475569;
    }
    .cell-mapel {
        background-color: #dbeafe; /* Biru muda cerah */
        border: 2px solid #bfdbfe !important;
        border-radius: 6px;
        color: #1e40af;
        transition: transform 0.2s;
        cursor: pointer;
        padding: 5px;
    }
    .cell-mapel:hover {
        background-color: #bfdbfe;
        transform: scale(0.98);
    }
    .kode-mapel {
        font-weight: bold;
        font-size: 1.1rem;
        display: block;
        margin-bottom: -2px;
    }
    .nama-guru {
        font-size: 0.75rem;
        color: #3b82f6;
        line-height: 1.2;
        margin-top: 2px;
    }
    .jam-kosong {
        color: #cbd5e1;
        background-color: #ffffff;
    }
</style>
@endsection

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body bg-white py-3 d-flex justify-content-between align-items-center rounded">
        
        <form action="{{ url('/admin/jadwal') }}" method="GET" class="d-flex align-items-center gap-3 m-0">
            <label class="fw-bold mb-0 text-nowrap">Pilih Kelas:</label>
            <select name="class_id" class="form-select form-select-sm border-primary" style="width: 200px;" onchange="this.form.submit()">
                <option value="">-- Pilih Kelas --</option>
                @foreach($classes as $kelas)
                    <option value="{{ $kelas->id }}" {{ $selectedClass == $kelas->id ? 'selected' : '' }}>
                        {{ $kelas->name }}
                    </option>
                @endforeach
            </select>
        </form>
        
        <div>
            @if($selectedClass)
                <a href="{{ url('/admin/jadwal/create?class_id=' . $selectedClass) }}" class="btn btn-primary btn-sm fw-bold shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Jadwal
                </a>
                <a href="{{ url('/admin/jadwal/pdf?class_id=' . $selectedClass) }}" class="btn btn-danger btn-sm fw-bold shadow-sm" target="_blank">
                 <i class="bi bi-filetype-pdf me-1"></i> Cetak PDF
             </a>
            @else
                <button class="btn btn-secondary btn-sm fw-bold" disabled>Pilih kelas dulu</button>
            @endif
        </div>
    </div>
</div>

@if($selectedClass)
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-4 text-center text-uppercase" style="color: #334155;">
            Jadwal Pelajaran Kelas {{ $classes->where('id', $selectedClass)->first()->name ?? '' }}
        </h5>

        <div class="table-responsive">
            <table class="table table-jadwal mb-0" style="min-width: 1000px;">
                @php
                    // Pengaturan Grid Jadwal
                    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $max_jam = 10; 
                    
                    // KAMUS WAKTU (Silakan sesuaikan menitnya dengan bel asli sekolah)
                    $waktu_jam = [
                        1 => '07:00 - 07:40',
                        2 => '07:40 - 08:20',
                        3 => '08:20 - 09:00',
                        4 => '09:00 - 09:40',
                        5 => '10:00 - 10:40', // Asumsi setelah istirahat pertama
                        6 => '10:40 - 11:20',
                        7 => '11:20 - 12:00',
                        8 => '12:30 - 13:10', // Asumsi setelah istirahat kedua/sholat
                        9 => '13:10 - 13:50',
                        10 => '13:50 - 14:30',
                    ];
                @endphp

                <thead>
                    <tr>
                        <th width="100">HARI</th>
                        @for($i = 1; $i <= $max_jam; $i++)
                            <th width="85">
                                <div class="fs-6">{{ $i }}</div>
                                <div style="font-size: 0.65rem; color: #64748b; font-weight: normal; letter-spacing: -0.5px;">
                                    {{ $waktu_jam[$i] ?? '' }}
                                </div>
                            </th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach($days as $day)
                        <tr>
                            <td class="fw-bold" style="background-color: #f1f5f9; color: #475569;">{{ $day }}</td>
                            
                            @php
                                // Ambil koleksi jadwal khusus hari ini
                                $today_schedules = isset($schedules[$day]) ? $schedules[$day] : collect();
                                $current_jam = 1; // Mulai dari jam ke-1
                            @endphp

                            @while($current_jam <= $max_jam)
                                @php
                                    // Cari apakah ada pelajaran yang MULAI di jam ini ($current_jam)
                                    $jadwal = $today_schedules->where('jam_mulai', $current_jam)->first();
                                @endphp

                                @if($jadwal)
                                    @php
                                        // Hitung panjang kotaknya (Contoh: Mulai jam 2, Selesai jam 4 = Kotak memanjang 3 kolom)
                                        $colspan = ($jadwal->jam_selesai - $jadwal->jam_mulai) + 1;
                                    @endphp
                                    
                                    <td colspan="{{ $colspan }}" class="p-1">
                                        <a href="{{ url('/admin/jadwal/' . $jadwal->id . '/edit') }}" class="cell-mapel text-decoration-none h-100 w-100 d-flex flex-column justify-content-center">
                                            <span class="kode-mapel" title="{{ $jadwal->subject->name ?? '' }}">
                                                {{ $jadwal->subject->kode_mapel ?? '???' }}
                                            </span>
                                            <span class="nama-guru" title="{{ $jadwal->teacher->name ?? '' }}">
                                                {{ $jadwal->teacher->name ?? '-' }}
                                            </span>
                                        </a>
                                    </td>

                                    @php
                                        // Lompat maju ke jam setelah pelajaran ini selesai
                                        $current_jam = $jadwal->jam_selesai + 1;
                                    @endphp
                                @else
                                    <td class="jam-kosong">-</td>
                                    
                                    @php
                                        // Maju 1 jam
                                        $current_jam++;
                                    @endphp
                                @endif
                            @endwhile
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
</div>
@else
<div class="text-center py-5 mt-4">
    <i class="bi bi-calendar3 d-block text-muted mb-3" style="font-size: 4rem;"></i>
    <h5 class="text-muted fw-bold">Silakan Pilih Kelas</h5>
    <p class="text-muted">Pilih kelas pada menu di atas untuk menampilkan atau mengelola jadwal pelajaran.</p>
</div>
@endif

@endsection