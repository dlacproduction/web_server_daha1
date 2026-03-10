@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Akun Wali Murid</h6>
        </div>
        <div class="card-body">
            <form action="{{ url('/admin/parents/'.$parent->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Wali</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $parent->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Email / Username</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $parent->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">No. HP / WhatsApp</label>
                    <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $parent->phone_number) }}">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Password Baru (Kosongkan jika tidak ingin ganti)</label>
                    <input type="password" name="password" class="form-control">
                    <small class="text-muted">Minimal 8 karakter.</small>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ url('/admin/parents') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection