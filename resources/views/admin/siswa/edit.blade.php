@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4" style="max-width: 700px; margin: 0 auto;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data Siswa</h6>
        </div>
        <div class="card-body">
            <form action="{{ url('/admin/students/'.$student->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap Siswa</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $student->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">NIS / NISN</label>
                    <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis', $student->nis) }}" required>
                    @error('nis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Jenis Kelamin</label>
                    <select name="gender" class="form-select" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki - laki" {{ old('gender', $student->gender) == 'Laki - laki' ? 'selected' : '' }}>
                            Laki - laki
                        </option>
                        <option value="Perempuan" {{ old('gender', $student->gender) == 'Perempuan' ? 'selected' : '' }}>
                            Perempuan
                        </option>
                    </select>
                    @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Ubah Kelas</label>
                    <select name="class_id" class="form-select @error('class_id') is-invalid @enderror" required>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Ubah Akun Wali Murid</label>
                    <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror" required>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $student->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }} ({{ $parent->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ url('/admin/students') }}" class="btn btn-secondary px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection