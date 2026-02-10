@extends('layout.app')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h5 class="mb-0">Buat Kelas Baru</h5>
    </div>
    <div class="card-body">
        <form action="{{ url('/admin/classes') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Kelas</label>
                <input type="text" name="name" class="form-control" required placeholder="Contoh: 7A, 9B">
            </div>

            <div class="mb-3">
                <label class="form-label">Pilih Wali Kelas</label>
                <select name="homeroom_teacher_id" class="form-select" required>
                    <option value="">-- Pilih Guru --</option>
                    @foreach($teachers as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->name }} ({{ $guru->nip_nis }})</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ url('/admin/classes') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-success">Simpan Kelas</button>
            </div>
        </form>
    </div>
</div>
@endsection