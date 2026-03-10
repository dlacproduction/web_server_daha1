@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Akun Wali Murid</h1>
        
        <div class="d-flex align-items-center">
            <form action="{{ url('/admin/parents') }}" method="GET" class="d-inline-flex me-3">
                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari Nama / Email" value="{{ request('search') }}">
                <button type="submit" class="btn btn-secondary btn-sm">Cari</button>
                @if(request('search'))
                    <a href="{{ url('/admin/parents') }}" class="btn btn-outline-danger btn-sm ms-1">Reset</a>
                @endif
            </form>

            <a href="/admin/parents/create" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Akun Baru
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($parents as $parent)
                        <tr>
                            <td>{{ $parent->name }}</td>
                            <td>{{ $parent->email }}</td>
                            <td>{{ $parent->phone_number ?? '-' }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning">Edit</button>
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-search d-block mb-2" style="font-size: 2rem;"></i>
                                Data wali murid tidak ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="small text-muted">
                    Menampilkan {{ $parents->firstItem() ?? 0 }} sampai {{ $parents->lastItem() ?? 0 }} dari {{ $parents->total() }} data
                </div>
                <div>
                    {{ $parents->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection