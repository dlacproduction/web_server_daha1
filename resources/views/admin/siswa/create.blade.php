@extends('layout.app')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4" style="max-width: 700px; margin: 0 auto;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Siswa</h6>
        </div>
        <div class="card-body">
            <form action="{{ url('/admin/students') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap Siswa</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: Ahmad Maulana" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">NIS / NISN</label>
                    <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis') }}" placeholder="Masukkan NIS siswa" required>
                    @error('nis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Jenis Kelamin</label>
                    <select name="gender" class="form-select" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki - laki" {{ old('gender') == 'Laki - laki' ? 'selected' : '' }}>Laki - laki</option>
                        <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Pilih Kelas</label>
                    <select name="class_id" class="form-select @error('class_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kelas Aktif --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- <div class="mb-4">
                    <label class="form-label fw-bold">Pilih Akun Wali Murid (Orang Tua)</label>
                    <select name="parent_id" id="select2-parent" class="form-select @error('parent_id') is-invalid @enderror" required>
                        <option value="">-- Cari dan Pilih Akun Wali Murid --</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }} ({{ $parent->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div> -->

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ url('/admin/students') }}" class="btn btn-secondary px-4">Batal</a>
                    <button type="submit" class="btn btn-success px-4">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 pada dropdown wali murid
            $('#select2-parent').select2({
                theme: "bootstrap-5", // Menggunakan tema bootstrap agar tampilannya senada dengan form Anda
                placeholder: "-- Cari dan Pilih Akun Wali Murid --",
                allowClear: true,
                width: '100%' // Memastikan lebarnya penuh menyesuaikan kontainer
            });
        });
    </script>
@endsection