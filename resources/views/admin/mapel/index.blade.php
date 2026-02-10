@extends('layout.app')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Mata Pelajaran</h5>
        <a href="{{ url('/admin/subjects/create') }}" class="btn btn-primary btn-sm">+ Tambah Mapel</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th width="50">No</th>
                    <th>Nama Mata Pelajaran</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subjects as $index => $mapel)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $mapel->name }}</td>
                    <td><button class="btn btn-sm btn-danger">Hapus</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection