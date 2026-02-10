@extends('layout.app')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h5 class="mb-0">Tambah Tahun Ajaran Baru</h5>
    </div>
    <div class="card-body">
        <form action="{{ url('/admin/academic-years') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tahun Pelajaran</label>
                    <input type="text" name="year" class="form-control" required placeholder="Contoh: 2025/2026">
                    <div class="form-text">Format: Tahun Awal/Tahun Akhir</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Semester</label>
                    <select name="semester" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="{{ url('/admin/academic-years') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection