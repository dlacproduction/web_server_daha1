@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Kelas</h5>
        <a href="{{ url('/admin/classes/create') }}" class="btn btn-primary btn-sm">+ Tambah Kelas</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th width="50">No</th>
                    <th>Nama Kelas</th>
                    <th>Wali Kelas</th>
                    <th>Jumlah Siswa</th> <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $index => $kelas)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kelas->name }}</td>
                    <td>{{ $kelas->teacher->name ?? '-' }}</td>
                    <td>{{ $kelas->students()->count() }} Siswa</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ url('/admin/classes/' . $kelas->id . '/edit') }}" class="btn btn-warning btn-sm">Edit</a>
                            
                            <form action="{{ url('/admin/classes/' . $kelas->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kelas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection