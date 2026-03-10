<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - SMP Pawyatan Daha 1</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* --- GLOBAL STYLE --- */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6; /* Abu-abu sangat muda (Modern Background) */
            color: #333;
        }

        /* --- SIDEBAR STYLE --- */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%); /* Gradasi Gelap Modern */
            color: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transition: all 0.3s;
            position: fixed; /* Agar sidebar tetap diam saat discroll */
            top: 0;
            left: 0;
            width: 260px;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            background: rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar a {
            color: #94a3b8; /* Warna teks abu kebiruan */
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #3b82f6; /* Biru terang saat hover */
            color: white;
            transform: translateX(5px); /* Efek geser sedikit */
        }

        .sidebar i {
            margin-right: 12px;
            font-size: 1.1rem;
        }

        /* --- CONTENT AREA --- */
        .main-wrapper {
            margin-left: 260px; /* Memberi ruang untuk sidebar */
            transition: all 0.3s;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 15px rgba(0,0,0,0.04);
            padding: 15px 30px;
        }

        .content {
            padding: 30px;
        }

        /* --- CARD STYLE (KOTAK KONTEN) --- */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            background: white;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #f0f0f0;
            padding: 20px 25px;
            font-weight: 600;
            font-size: 1.1rem;
            color: #1e293b;
        }

        .card-body {
            padding: 25px;
        }

        /* --- TOMBOL --- */
        .btn {
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-primary { background-color: #3b82f6; border: none; }
        .btn-primary:hover { background-color: #2563eb; transform: translateY(-2px); }
        
        /* --- TABLE --- */
        .table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header d-flex align-items-center gap-2">
            <div class="bg-white text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px;">LG</div>
            <div>
                <h6 class="m-0 fw-bold" style="font-size: 0.8rem;">SMP PAWYATAN</h6>
                <small class="text-muted" style="font-size: 0.65rem;">DAHA 1 KEDIRI</small>
            </div>
        </div>
        
        <div class="mt-3">
            <a href="{{ url('/admin/dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> DASHBOARD
            </a>

            <hr style="border-color: rgba(255,255,255,0.1); margin: 10px 0;">

            <small class="text-muted px-4 fw-bold" style="font-size: 0.65rem;">MASTER DATA</small>
            
            <a href="{{ url('/admin/teachers') }}" class="{{ request()->is('admin/teachers*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i> DATA GURU
            </a>

            <a href="{{ url('/admin/parents') }}" class="{{ request()->is('admin/parents*') ? 'active' : '' }}">
                <i class="bi bi-person-heart"></i> AKUN WALI MURID
            </a>
            
            <a href="{{ url('/admin/students') }}" class="{{ request()->is('admin/students*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> DATA SISWA
            </a>

            <a href="{{ url('/admin/classes') }}" class="{{ request()->is('admin/classes*') ? 'active' : '' }}">
                <i class="bi bi-building"></i> DATA KELAS
            </a>
            
            <a href="{{ url('/admin/promotions') }}" class="{{ request()->is('admin/promotions*') ? 'active' : '' }}">
                <i class="bi bi-building"></i> KENAIKAN KELAS
            </a>


            <hr style="border-color: rgba(255,255,255,0.1); margin: 10px 0;">

            <small class="text-muted px-4 fw-bold" style="font-size: 0.65rem;">AKADEMIK</small>

            <a href="{{ url('/admin/academic-years') }}" class="{{ request()->is('admin/academic-years*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event"></i> TAHUN AJARAN
            </a>

            <a href="{{ url('/admin/subjects') }}" class="{{ request()->is('admin/subjects*') ? 'active' : '' }}">
                <i class="bi bi-book"></i> MATA PELAJARAN
            </a>

            <a href="{{ url('/admin/teaching-assignments') }}" class="{{ request()->is('admin/teaching-assignments*') ? 'active' : '' }}">
                <i class="bi bi-calendar-week"></i> JADWAL PELAJARAN
            </a>

            <hr style="border-color: rgba(255,255,255,0.1); margin: 10px 0;">

            <small class="text-muted px-4 fw-bold" style="font-size: 0.65rem;">LAPORAN</small>

            <a href="#" class="">
                <i class="bi bi-printer"></i> CETAK PRESENSI
            </a>

            <a href="#" class="">
                <i class="bi bi-file-earmark-pdf"></i> CETAK RAPOR
            </a>

            <div class="mt-5 px-3">
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100 btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="main-wrapper">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <span class="navbar-text text-muted">
                    <i class="bi bi-list fs-4 me-2" style="cursor: pointer;"></i>
                    Selamat Datang, <strong>Administrator</strong>
                </span>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-bell text-secondary"></i>
                    </div>
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                        A
                    </div>
                </div>
            </div>
        </nav>

        <div class="content">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-4">
                    <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center mb-4">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
                    {{ session('error') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>