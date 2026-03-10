@extends('layout.app')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h5 class="mb-0">Registrasi Guru Baru</h5>
    </div>
    <div class="card-body">
        <form action="{{ url('/admin/teachers') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required placeholder="Contoh: Budi Santoso, S.Pd">
            </div>
            
            <div class="mb-3">
                <label class="form-label">NIP (Nomor Induk Pegawai)</label>
                <input type="text" name="nip" class="form-control" placeholder="1980xxxx...">
            </div>

            <div class="mb-3">
                <label class="form-label">Email Login</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="guru@sekolah.com">

                @error('email')
                    <div class="invalid-feedback fw-bold">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="passwordInput" class="form-control" required>
                    
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ url('/admin/teachers') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-success">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#passwordInput');
    const toggleIcon = document.querySelector('#toggleIcon');

    togglePassword.addEventListener('click', function (e) {
        // 1. Cek tipe atribut saat ini (password atau text)
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        
        // 2. Ubah tipe atributnya
        passwordInput.setAttribute('type', type);

        // 3. Ubah Ikon (Mata terbuka / Mata dicoret)
        if (type === 'text') {
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash'); // Mata dicoret
        } else {
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye'); // Mata biasa
        }
    });
</script>
@endsection