@extends('layout.app')

@section('styles')
<style>
    /* Tambahan animasi khusus untuk kartu statistik di Dashboard */
    .stat-card {
        border-radius: 16px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-icon-wrapper {
        width: 65px;
        height: 65px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    /* Efek pendaran cahaya (glow) di bayangan kartu */
    .shadow-indigo { box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2); }
    .shadow-emerald { box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2); }
    .shadow-cyan { box-shadow: 0 10px 20px rgba(6, 182, 212, 0.2); }
    .shadow-amber { box-shadow: 0 10px 20px rgba(245, 158, 11, 0.2); }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-end mb-4 pb-2">
    <div>
        <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Dashboard Overview</h4>
        <p class="text-muted mb-0" style="font-size: 0.95rem;">Ringkasan data akademik SMP Pawyatan Daha 1</p>
    </div>
    <div class="d-none d-md-block text-muted small bg-white px-3 py-2 rounded-pill shadow-sm border border-light">
        <i class="bi bi-calendar3 text-primary me-2"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="card stat-card border-0 text-white shadow-indigo h-100" style="background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 fw-semibold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px; color: rgba(255,255,255,0.8);">Total Siswa</p>
                        <h2 class="mb-0 fw-bold" style="font-size: 2.2rem;">{{ $totalSiswa }}</h2>
                    </div>
                    <div class="stat-icon-wrapper">
                        <i class="bi bi-people-fill fs-2"></i>
                    </div>
                </div>
            </div>
            <i class="bi bi-people-fill position-absolute" style="font-size: 8rem; right: -20px; bottom: -30px; opacity: 0.1; transform: rotate(-15deg);"></i>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card stat-card border-0 text-white shadow-emerald h-100" style="background: linear-gradient(135deg, #10b981 0%, #047857 100%);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 fw-semibold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px; color: rgba(255,255,255,0.8);">Total Guru</p>
                        <h2 class="mb-0 fw-bold" style="font-size: 2.2rem;">{{ $totalGuru }}</h2>
                    </div>
                    <div class="stat-icon-wrapper">
                        <i class="bi bi-person-badge-fill fs-2"></i>
                    </div>
                </div>
            </div>
            <i class="bi bi-person-badge-fill position-absolute" style="font-size: 8rem; right: -20px; bottom: -30px; opacity: 0.1; transform: rotate(-15deg);"></i>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card stat-card border-0 text-white shadow-cyan h-100" style="background: linear-gradient(135deg, #06b6d4 0%, #0e7490 100%);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 fw-semibold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px; color: rgba(255,255,255,0.8);">Total Kelas</p>
                        <h2 class="mb-0 fw-bold" style="font-size: 2.2rem;">{{ $totalKelas }}</h2>
                    </div>
                    <div class="stat-icon-wrapper">
                        <i class="bi bi-building-fill fs-2"></i>
                    </div>
                </div>
            </div>
            <i class="bi bi-building-fill position-absolute" style="font-size: 8rem; right: -20px; bottom: -30px; opacity: 0.1; transform: rotate(-15deg);"></i>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card stat-card border-0 text-white shadow-amber h-100" style="background: linear-gradient(135deg, #f59e0b 0%, #b45309 100%);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 fw-semibold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px; color: rgba(255,255,255,0.8);">Tahun Ajaran</p>
                        <h4 class="mb-0 fw-bold mt-1">{{ $tahunAktif ? $tahunAktif->name : '-' }}</h4>
                        <p class="mb-0 mt-1" style="font-size: 0.85rem; color: rgba(255,255,255,0.9);">{{ $tahunAktif ? ucfirst($tahunAktif->semester) : 'Belum Set' }}</p>
                    </div>
                    <div class="stat-icon-wrapper">
                        <i class="bi bi-calendar-check-fill fs-2"></i>
                    </div>
                </div>
            </div>
            <i class="bi bi-calendar-check-fill position-absolute" style="font-size: 8rem; right: -20px; bottom: -30px; opacity: 0.1; transform: rotate(-15deg);"></i>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-header bg-white pt-4 pb-3 px-4 border-0">
                <h6 class="m-0 fw-bold" style="color: var(--primary-color);">Informasi Sistem</h6>
            </div>
            <div class="card-body px-4 pb-4">
                <p class="text-muted mb-4">Selamat datang di Sistem Informasi Manajemen Sekolah. Gunakan menu navigasi di sebelah kiri untuk mengelola master data akademik, jadwal, dan laporan sekolah.</p>
                
                <div class="alert d-flex align-items-center border-0 shadow-sm" style="background-color: #eff6ff; color: #1e3a8a; border-left: 4px solid #3b82f6; border-radius: 12px;">
                    <i class="bi bi-info-circle-fill fs-4 me-3 text-primary"></i>
                    <div>
                        <strong class="d-block mb-1">Perhatian Akademik</strong>
                        <span style="font-size: 0.95rem;">Pastikan <b>Tahun Ajaran</b> aktif telah diatur dengan benar di menu Akademik sebelum melakukan input data siswa maupun jadwal kelas.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection