@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Guru</h5>
        <a href="{{ url('/admin/teachers/create') }}" class="btn btn-primary btn-sm">+ Tambah Guru</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>NIP</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $index => $guru)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $guru->name }}</td>
                    <td>{{ $guru->nip_nis }}</td>
                    <td>{{ $guru->email }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ url('/admin/teachers/' . $guru->id . '/edit') }}" class="btn btn-warning btn-sm">Edit</a>
                            
                            <form action="{{ url('/admin/teachers/' . $guru->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus guru ini?')">
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