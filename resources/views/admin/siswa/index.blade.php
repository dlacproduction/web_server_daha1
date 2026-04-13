@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
        <h5 class="mb-0">Data Siswa</h5>
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <form action="{{ url('/admin/students') }}" method="GET" class="d-inline-flex gap-2 mb-0 align-items-center">
                <input type="text" name="search" class="form-control form-control-sm" style="width: 200px;" placeholder="Cari Nama / NIS..." value="{{ request('search') }}">
                <select name="class_id" id="filterKelas" class="form-select form-select-sm" 
                        style="min-width: 120px;" onchange="this.form.submit()">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ $filterKelas == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
                
                @if(request('search') || request('class_id'))
                    <a href="{{ url('/admin/students') }}" class="btn btn-outline-danger btn-sm">Reset</a>
                @endif

                <button type="submit" formaction="{{ url('/admin/students/export') }}" class="btn btn-success btn-sm">
                    Unduh Excel
                </button>
            </form>

            <a href="{{ url('/admin/students/create') }}" class="btn btn-primary btn-sm">+ Tambah Siswa</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-light">
                <tr>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th class="text-center">L/P</th> 
                    <th>Kelas</th>
                    <th>Wali Murid</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr>
                    <td>{{ $student->nis }}</td>
                    <td>{{ $student->name }}</td>
                    <td class="text-center">{{ $student->gender }}</td>
                    <td><span class="badge bg-info">{{ $student->schoolClass->name ?? 'Belum ada' }}</span></td>
                    <td>{{ $student->parent->name ?? '-' }}</td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ url('/admin/students/' . $student->id . '/edit') }}" class="btn btn-sm btn-warning">Edit</a>
                            
                            <form action="{{ url('/admin/students/' . $student->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada data siswa.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="small text-muted">
                Menampilkan {{ $students->firstItem() ?? 0 }} sampai {{ $students->lastItem() ?? 0 }} dari {{ $students->total() }} data
            </div>
            <div>
                {{ $students->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection