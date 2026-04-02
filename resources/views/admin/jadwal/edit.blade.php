@extends('layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 font-weight-bold">
                    <i class="bi bi-pencil-square me-2 text-warning"></i> Edit Jadwal Kelas {{ $kelas->name }}
                </h5>
            </div>
            <div class="card-body p-4">
                
                <form action="{{ url('/admin/jadwal/' . $jadwal->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Hari</label>
                            <select name="hari" class="form-select" required>
                                @foreach($days as $day)
                                    <option value="{{ $day }}" {{ $jadwal->hari == $day ? 'selected' : '' }}>{{ $day }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Jam Mulai</label>
                            <select name="jam_mulai" class="form-select" required>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ $jadwal->jam_mulai == $i ? 'selected' : '' }}>Jam ke-{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Jam Selesai</label>
                            <select name="jam_selesai" class="form-select" required>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ $jadwal->jam_selesai == $i ? 'selected' : '' }}>Jam ke-{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mata Pelajaran</label>
                        <select name="subject_id" class="form-select" required>
                            @foreach($subjects as $mapel)
                                <option value="{{ $mapel->id }}" {{ $jadwal->subject_id == $mapel->id ? 'selected' : '' }}>
                                    [{{ $mapel->kode_mapel ?? '-' }}] {{ $mapel->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Guru Pengajar</label>
                        <select name="teacher_id" class="form-select" required>
                            @foreach($teachers as $guru)
                                <option value="{{ $guru->id }}" {{ $jadwal->teacher_id == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="{{ url('/admin/jadwal?class_id=' . $kelas->id) }}" class="btn btn-light border px-4">Batal</a>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning text-white px-4 fw-bold">Update Jadwal</button>
                        </div>
                    </div>
                </form>

                <form action="{{ url('/admin/jadwal/' . $jadwal->id) }}" method="POST" class="d-inline position-absolute" style="bottom: 24px; right: 180px;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-3"><i class="bi bi-trash3"></i> Hapus</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection