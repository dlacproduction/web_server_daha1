@extends('layout.app')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h5 class="mb-0">Edit Data Guru</h5>
    </div>
    <div class="card-body">
        <form action="{{ url('/admin/teachers/' . $teacher->id) }}" method="POST">
            @csrf
            @method('PUT') <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ $teacher->name }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">NIP</label>
                <input type="text" name="nip" class="form-control" value="{{ $teacher->nip_nis }}" placeholder="Opsional">
            </div>

            <div class="mb-3">
                <label class="form-label">Email Login</label>
                <input type="email" name="email" class="form-control" value="{{ $teacher->email }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti password">
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ url('/admin/teachers') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection