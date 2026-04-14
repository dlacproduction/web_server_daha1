@extends('layout.app') @section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0 text-dark"><i class="bi bi-printer text-primary me-2"></i> Cetak Laporan Presensi</h4>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                Filter Data Presensi
            </div>
            <div class="card-body">
                <form action="{{ url('/admin/laporan/presensi/cetak') }}" method="GET" target="_blank">
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Tahun Ajaran</label>
                        <select name="academic_year_id" class="form-select" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year->id }}" 
                                    {{-- Logika Otomatis Pilih Tahun Aktif --}}
                                    @if(isset($activeYear) && $year->id == $activeYear->id) selected @endif>
                                    {{ $year->year }} - {{ $year->semester }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Kelas</label>
                        <select name="class_id" class="form-select" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classes as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Bulan</label>
                        <select name="bulan" class="form-select" required>
                            <option value="">-- Pilih Bulan --</option>
                            @foreach($bulan as $angka => $nama_bulan)
                                <option value="{{ $angka }}">{{ $nama_bulan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-file-earmark-pdf-fill me-2"></i> Generate PDF Presensi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection