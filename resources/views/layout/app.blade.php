<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SMP Pawyatan Daha 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #343a40; color: white; }
        .sidebar a { color: #cfd2d6; text-decoration: none; display: block; padding: 10px 15px; }
        .sidebar a:hover { background-color: #495057; color: white; }
        .content { padding: 20px; }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar p-3" style="width: 250px;">
            <h4>SMP Daha 1</h4>
            <hr>
            <a href="{{ url('/admin/dashboard') }}">🏠 Dashboard</a>
            <a href="{{ url('/admin/teachers') }}">👨‍🏫 Data Guru</a>
            <a href="{{ url('/admin/classes') }}">🎓 Data Kelas</a>
            <a href="{{ url('/admin/students') }}">🎓 Data Siswa</a>
            <a href="{{ url('/admin/subjects') }}">📚 Mata Pelajaran</a>
            <a href="{{ url('/admin/academic-years') }}">📅 Tahun Ajaran</a>
            <hr>
            <a href="#" class="text-danger">🚪 Logout</a>
        </div>

        <div class="flex-grow-1">
            <nav class="navbar navbar-light bg-white shadow-sm px-4">
                <span class="navbar-brand mb-0 h1">Panel Administrasi</span>
            </nav>
            <div class="content">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>