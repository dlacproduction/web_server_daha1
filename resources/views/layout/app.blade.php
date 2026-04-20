<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - SMP Pawyatan Daha 1</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @yield('styles')
    <style>
        /* --- GLOBAL STYLE --- */
        :root {
            --primary-color: #4f46e5; /* Indigo modern */
            --primary-hover: #4338ca;
            --bg-color: #f8fafc; /* Slate muda */
            --sidebar-bg: #0f172a; /* Slate super gelap */
            --sidebar-hover: rgba(255, 255, 255, 0.08);
            --text-main: #334155;
            --text-muted: #94a3b8;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            letter-spacing: 0.2px;
        }

        /* --- CUSTOM SCROLLBAR --- */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1; 
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; 
        }

        /* --- SIDEBAR STYLE --- */
        .sidebar {
            min-height: 100vh;
            background: var(--sidebar-bg);
            color: white;
            box-shadow: 4px 0 24px rgba(0,0,0,0.06);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: fixed;
            top: 0;
            left: 0;
            width: 270px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 24px 20px;
            background: rgba(0,0,0,0.15);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding: 15px 0;
        }

        .sidebar a {
            color: var(--text-muted);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            margin: 4px 16px;
            border-radius: 10px;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .sidebar a:hover {
            background-color: var(--sidebar-hover);
            color: white;
            transform: translateX(4px);
        }

        .sidebar a.active {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .sidebar i {
            margin-right: 14px;
            font-size: 1.15rem;
            transition: transform 0.2s;
        }

        .sidebar a:hover i {
            transform: scale(1.1);
        }

        .menu-label {
            color: #64748b;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 10px 20px 5px 36px;
            margin-top: 10px;
        }

        /* --- CONTENT AREA & NAVBAR --- */
        .main-wrapper {
            margin-left: 270px;
            transition: all 0.3s;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px); /* Efek Kaca / Glassmorphism */
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.03);
            padding: 15px 30px;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .content {
            padding: 30px;
            flex: 1;
        }

        /* --- CARD STYLE --- */
        .card {
            border: none;
            border-radius: 16px; /* Lebih membulat */
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            background: white;
            margin-bottom: 24px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #f1f5f9;
            padding: 20px 25px;
            font-weight: 600;
            font-size: 1.05rem;
            color: #1e293b;
            border-radius: 16px 16px 0 0 !important;
        }

        .card-body {
            padding: 25px;
        }

        /* --- BUTTONS & ALERTS --- */
        .btn {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        
        .btn-primary { 
            background-color: var(--primary-color); 
            border: none; 
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
        }
        .btn-primary:hover { 
            background-color: var(--primary-hover); 
            transform: translateY(-2px); 
            box-shadow: 0 6px 15px rgba(79, 70, 229, 0.3);
        }

        .btn-danger {
            background-color: #ef4444;
            border: none;
        }

        .alert {
            border-radius: 12px;
            border: none;
        }

        /* --- TABLE --- */
        .table {
            vertical-align: middle;
        }
        .table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 15px;
        }
        .table tbody td {
            padding: 15px;
            color: #475569;
            border-bottom: 1px solid #f1f5f9;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header d-flex align-items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SMP Pawyatan Daha 1 Kota Kediri" class="shadow-sm rounded-circle bg-white" style="width: 45px; height: 45px; object-fit: contain; padding: 3px;">
            <div>
                <h6 class="m-0 fw-bold tracking-wide" style="font-size: 0.9rem;">SMP PAWYATAN</h6>
                <small style="color: #64748b; font-size: 0.7rem; font-weight: 500;">DAHA 1 KEDIRI</small>
            </div>
        </div>
        
        <div class="sidebar-menu">
            <a href="{{ url('/admin/dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>

            <div class="menu-label">MASTER DATA</div>
            
            <a href="{{ url('/admin/teachers') }}" class="{{ request()->is('admin/teachers*') ? 'active' : '' }}">
                <i class="bi bi-person-vcard"></i> Data Guru
            </a>

            <a href="{{ url('/admin/parents') }}" class="{{ request()->is('admin/parents*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Akun Wali Murid
            </a>
            
            <a href="{{ url('/admin/students') }}" class="{{ request()->is('admin/students*') ? 'active' : '' }}">
                <i class="bi bi-mortarboard"></i> Data Siswa
            </a>

            <a href="{{ url('/admin/classes') }}" class="{{ request()->is('admin/classes*') ? 'active' : '' }}">
                <i class="bi bi-buildings"></i> Data Kelas
            </a>
            
            <a href="{{ url('/admin/promotions') }}" class="{{ request()->is('admin/promotions*') ? 'active' : '' }}">
                <i class="bi bi-graph-up-arrow"></i> Kenaikan Kelas
            </a>

            <div class="menu-label">AKADEMIK</div>

            <a href="{{ url('/admin/academic-years') }}" class="{{ request()->is('admin/academic-years*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i> Tahun Ajaran
            </a>

            <a href="{{ url('/admin/subjects') }}" class="{{ request()->is('admin/subjects*') ? 'active' : '' }}">
                <i class="bi bi-book-half"></i> Mata Pelajaran
            </a>

            <a href="{{ url('/admin/jadwal') }}" class="{{ request()->is('admin/jadwal*') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Jadwal Pelajaran
            </a>

            <div class="menu-label">LAPORAN</div>

            <a href="{{ url('/admin/laporan/presensi') }}" class="{{ request()->is('admin/laporan/presensi*') ? 'active' : '' }}">
                <i class="bi bi-clipboard-data"></i> Cetak Presensi
            </a>

            <a href="{{ url('/admin/laporan/rapor') }}" class="{{ request()->is('admin/laporan/rapor*') ? 'active' : '' }}">
                <i class="bi bi-journal-bookmark-fill"></i> Cetak Rapor
            </a>
        </div>

        <div class="p-4 mt-auto border-top" style="border-color: rgba(255,255,255,0.05) !important;">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2);">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-wrapper">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <span class="navbar-text text-dark d-flex align-items-center">
                    <i class="bi bi-list fs-4 me-3 text-primary" style="cursor: pointer;"></i>
                    <span class="fw-medium">Selamat Datang, <strong>Administrator</strong></span>
                </span>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center position-relative" style="width: 40px; height: 40px; cursor: pointer;">
                        <i class="bi bi-bell text-secondary"></i>
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 40px; height: 40px; background-color: var(--primary-color); color: white; cursor: pointer;">
                        A
                    </div>
                </div>
            </div>
        </nav>

        <div class="content">
            @if(session('success'))
                <div class="alert alert-success shadow-sm d-flex align-items-center mb-4" style="background-color: #f0fdf4; color: #166534; border-left: 4px solid #22c55e;">
                    <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger shadow-sm d-flex align-items-center mb-4" style="background-color: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444;">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-danger"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>