@extends('layout.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Akun Wali Murid</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Informasi Akun</h6>
                </div>
                <div class="card-body">
                    <form action="/admin/parents" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label>Nama Lengkap Wali Murid</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Email (Username untuk Login)</label>
                            <input type="email" name="email" class="form-control" placeholder="email@contoh.com" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Nomor WhatsApp/Telepon</label>
                            <input type="text" name="phone_number" class="form-control" placeholder="08123456789">
                        </div>

                        <div class="form-group mb-4">
                            <label>Password Awal</label>
                            <input type="password" name="password" class="form-control" required>
                            <small class="text-muted">Minimal 8 karakter. Wali murid dapat mengubahnya nanti.</small>
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan Akun Wali Murid
                        </button>
                        <a href="/admin/parents" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection