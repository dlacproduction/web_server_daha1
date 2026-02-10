@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Siswa</h5>
        <div>
            <form action="{{ url('/admin/students') }}" method="GET" class="d-inline-flex">
                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari Nama / NIS..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-secondary btn-sm">Cari</button>
            </form>
            <a href="{{ url('/admin/students/create') }}" class="btn btn-primary btn-sm ms-2">+ Tambah Siswa</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-light">
                <tr>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Wali Murid</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr>
                    <td>{{ $student->nis }}</td>
                    <td>{{ $student->name }}</td>
                    <td><span class="badge bg-info">{{ $student->schoolClass->name ?? 'Belum ada' }}</span></td>
                    <td>{{ $student->parent->name ?? '-' }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning">Edit</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada data siswa.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="mt-3">
            {{ $students->links() }} 
        </div>
    </div>
</div>
@endsection