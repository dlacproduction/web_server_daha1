@extends('layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 font-weight-bold">
                    <i class="bi bi-calendar-plus me-2 text-primary"></i> Tambah Jadwal Kelas {{ $kelas->name }}
                </h5>
            </div>
            <div class="card-body p-4">
                
                <form action="{{ url('/admin/jadwal') }}" method="POST">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $kelas->id }}">

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Hari</label>
                            <select name="hari" class="form-select @error('hari') is-invalid @enderror" required>
                                <option value="">-- Pilih Hari --</option>
                                @foreach($days as $day)
                                    <option value="{{ $day }}" {{ old('hari') == $day ? 'selected' : '' }}>{{ $day }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Jam Mulai</label>
                            <select name="jam_mulai" class="form-select @error('jam_mulai') is-invalid @enderror" required>
                                <option value="">-- Mulai --</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('jam_mulai') == $i ? 'selected' : '' }}>Jam ke-{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Jam Selesai</label>
                            <select name="jam_selesai" class="form-select @error('jam_selesai') is-invalid @enderror" required>
                                <option value="">-- Selesai --</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('jam_selesai') == $i ? 'selected' : '' }}>Jam ke-{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mata Pelajaran</label>
                        <select name="subject_id" class="form-select @error('subject_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($subjects as $mapel)
                                <option value="{{ $mapel->id }}" {{ old('subject_id') == $mapel->id ? 'selected' : '' }}>
                                    [{{ $mapel->kode_mapel ?? '-' }}] {{ $mapel->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Guru Pengajar</label>
                        <select name="teacher_id" class="form-select @error('teacher_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Guru --</option>
                            @foreach($teachers as $guru)
                                <option value="{{ $guru->id }}" {{ old('teacher_id') == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ url('/admin/jadwal?class_id=' . $kelas->id) }}" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Jadwal</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection