@extends('layout.app')

@section('content')
<div class="card shadow-sm border-0" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold">Data Mata Pelajaran</h5>
        <a href="{{ url('/admin/subjects/create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus"></i>Tambah Mapel
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50" class="text-center ps-3">No</th>
                        <th>Nama Mata Pelajaran</th>
                        <th width="150" class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($subjects as $index => $mapel)
                    <tr>
                        <td class="text-center ps-3">{{ $index + 1 }}</td>
                        <td>{{ $mapel->name }}</td>
                        <td class="pe-3">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ url('/admin/subjects/' . $mapel->id . '/edit') }}" class="btn btn-sm btn-warning text-white">Edit</a>
                                
                                <form action="{{ url('/admin/subjects/' . $mapel->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus mapel ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Belum ada data mata pelajaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection