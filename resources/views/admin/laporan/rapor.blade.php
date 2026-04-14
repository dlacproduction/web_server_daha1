@extends('layout.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0 text-dark"><i class="bi bi-file-earmark-pdf text-danger me-2"></i> Cetak Rapor Siswa</h4>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">Pilih Kriteria Rapor</div>
            <div class="card-body">
                <form action="{{ url('/admin/laporan/rapor/cetak') }}" method="GET" target="_blank">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tahun Ajaran</label>
                        <select name="academic_year_id" class="form-select" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year->id }}" 
                                    {{-- Logika Auto-Select: Jika ID cocok dengan yang aktif, pasang atribut selected --}}
                                    @if(isset($activeYear) && $year->id == $activeYear->id) selected @endif>
                                    {{ $year->year }} - {{ $year->semester }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Kelas</label>
                        <select name="class_id" class="form-select" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-danger btn-lg">
                            <i class="bi bi-file-pdf-fill me-2"></i> Cetak Rapor Satu Kelas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection