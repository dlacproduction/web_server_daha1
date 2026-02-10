@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Tahun Ajaran & Semester</h5>
        <a href="{{ url('/admin/academic-years/create') }}" class="btn btn-primary btn-sm">+ Baru</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Tahun Ajaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($years as $item) <tr class="{{ $item->is_active ? 'table-success' : '' }}">
                    
                    <td>{{ $item->year }} {{ $item->semester }}</td> 
                    
                    <td>
                        @if($item->is_active)
                            <span class="badge bg-success">AKTIF</span>
                        @else
                            <span class="badge bg-secondary">Tidak Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                             @if(!$item->is_active)
                                <form action="{{ url('/admin/academic-years/' . $item->id . '/activate') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Aktifkan</button>
                                </form>
                                @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection