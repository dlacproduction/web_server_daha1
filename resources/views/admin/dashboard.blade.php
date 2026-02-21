@extends('layout.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="fw-bold text-dark">Dashboard Overview</h4>
        <p class="text-muted">Ringkasan data akademik SMP Pawyatan Daha 1</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm" style="background: linear-gradient(45deg, #4e73df, #224abe); color: white;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="opacity: 0.8;">Total Siswa</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalSiswa }}</h2>
                    </div>
                    <i class="bi bi-people-fill fs-1" style="opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm" style="background: linear-gradient(45deg, #1cc88a, #13855c); color: white;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="opacity: 0.8;">Total Guru</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalGuru }}</h2>
                    </div>
                    <i class="bi bi-person-badge-fill fs-1" style="opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm" style="background: linear-gradient(45deg, #36b9cc, #258391); color: white;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="opacity: 0.8;">Total Kelas</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalKelas }}</h2>
                    </div>
                    <i class="bi bi-building-fill fs-1" style="opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm" style="background: linear-gradient(45deg, #f6c23e, #dda20a); color: white;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="opacity: 0.8;">Tahun Ajaran</h6>
                        <h5 class="mb-0 fw-bold">{{ $tahunAktif ? $tahunAktif->name : '-' }}</h5>
                        <small>{{ $tahunAktif ? $tahunAktif->semester : 'Belum Set' }}</small>
                    </div>
                    <i class="bi bi-calendar-check-fill fs-1" style="opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-primary">Informasi Sekolah</h6>
            </div>
            <div class="card-body">
                <p>Selamat datang di Sistem Informasi Manajemen Sekolah. Gunakan menu di sebelah kiri untuk mengelola data master.</p>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i> Pastikan Tahun Ajaran sudah diaktifkan sebelum menginput data kelas.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection