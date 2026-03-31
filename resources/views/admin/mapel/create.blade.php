@extends('layout.app')

@section('content')
<div class="card" style="max-width: 500px; margin: 0 auto;">
    <div class="card-header">
        <h5 class="mb-0">Tambah Mata Pelajaran</h5>
    </div>
    <div class="card-body">
        <form action="{{ url('/admin/subjects') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Kode Mapel</label>
                <input type="text" name="kode_mapel" class="form-control @error('kode_mapel') is-invalid @enderror" value="{{ old('kode_mapel', $subject->kode_mapel ?? '') }}" placeholder="Contoh: MAT, IPA, BING" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Mata Pelajaran</label>
                <input type="text" name="name" class="form-control" required placeholder="Contoh: Matematika, Bahasa Jawa">
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ url('/admin/subjects') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection