@extends('layout.app')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h5 class="mb-0">Edit Data Kelas</h5>
    </div>
    <div class="card-body">
        <form action="{{ url('/admin/classes/' . $class->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Kelas</label>
                <input type="text" name="name" class="form-control" value="{{ $class->name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Wali Kelas</label>
                <select name="homeroom_teacher_id" class="form-select" required>
                    <option value="">-- Pilih Guru --</option>
                    @foreach($teachers as $guru)
                        <option value="{{ $guru->id }}" {{ $class->teacher_id == $guru->id ? 'selected' : '' }}>
                            {{ $guru->name }} ({{ $guru->nip_nis }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ url('/admin/classes') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection