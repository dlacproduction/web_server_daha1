@extends('layout.app')

@section('content')
<div class="card shadow-sm border-0" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold">Data Mata Pelajaran</h5>
        
        <div>
            <form action="{{ url('/admin/subjects') }}" method="GET" class="d-inline-flex">
                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari Nama / Kode..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-secondary btn-sm">Cari</button>
                @if(request('search'))
                    <a href="{{ url('/admin/subjects') }}" class="btn btn-outline-danger btn-sm ms-1">Reset</a>
                @endif
            </form>
            <a href="{{ url('/admin/subjects/create') }}" class="btn btn-primary btn-sm ms-2">+ Tambah Mapel</a>
        </div>
        </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50" class="text-center ps-3">No</th>
                        <th width="120" class="text-center">Kode Mapel</th>
                        <th>Nama Mata Pelajaran</th>
                        <th width="150" class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($subjects as $index => $mapel)
                    <tr>
                        <td class="text-center ps-3">{{ $index + 1 }}</td>
                        <td class="text-center">
                            @if($mapel->kode_mapel)
                                <span class="badge bg-secondary px-2 py-1">{{ $mapel->kode_mapel }}</span>
                            @else
                                <span class="text-muted fst-italic">-</span>
                            @endif
                        </td>
                        <td>
                            @if(request('search'))
                                {!! str_ireplace(request('search'), '<mark class="p-0 bg-warning">'.request('search').'</mark>', $mapel->name) !!}
                            @else
                                {{ $mapel->name }}
                            @endif
                        </td>
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
                        <td colspan="4" class="text-center text-muted py-4">
                            @if(request('search'))
                                Tidak ada mata pelajaran yang cocok dengan kata kunci "<strong>{{ request('search') }}</strong>".
                            @else
                                Belum ada data mata pelajaran.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection