@extends('layout.app')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h5 class="mb-0">Registrasi Siswa Baru</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/admin/students') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">NIS (Nomor Induk Siswa)</label>
                    <input type="number" name="nis" class="form-control" required placeholder="Contoh: 2024001">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" required placeholder="Nama Siswa">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <select name="class_id" class="form-select" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classes as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Wali Murid (Orang Tua)</label>
                <select name="parent_id" class="form-select" required>
                    <option value="">-- Pilih Wali Murid --</option>
                    @foreach($parents as $wali)
                        <option value="{{ $wali->id }}">{{ $wali->name }} ({{ $wali->email }})</option>
                    @endforeach
                </select>
                <div class="form-text">
                    *Jika Wali Murid belum ada, daftarkan dulu di menu Data Guru/User (tapi nanti kita buat menu khusus Wali).
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ url('/admin/students') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-success">Simpan Data</button>
            </div>
        </form>
    </div>
</div>
@endsection