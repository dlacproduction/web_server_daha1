@extends('layout.app')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Mata Pelajaran</h6>
        </div>
        <div class="card-body">
            <form action="{{ url('/admin/subjects/' . $subject->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Mata Pelajaran</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $subject->name) }}" placeholder="Contoh: Matematika" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4 mt-3">
                    <label class="form-label fw-bold">Pilih Guru Pengampu (Bisa lebih dari satu)</label>
                    <select name="teacher_ids[]" id="select2-teachers" class="form-select" multiple="multiple">
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" 
                                {{ in_array($teacher->id, old('teacher_ids', $subject->teachers->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text text-muted">Ketik nama guru untuk mencari. Anda bisa memilih beberapa guru sekaligus untuk satu mata pelajaran ini.</div>
                    @error('teacher_ids') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ url('/admin/subjects') }}" class="btn btn-secondary px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Mengubah dropdown select biasa menjadi Select2 Multiple
            $('#select2-teachers').select2({
                theme: "bootstrap-5",
                placeholder: "-- Cari dan Pilih Guru Pengampu --",
                allowClear: true,
                width: '100%',
                closeOnSelect: false // Membiarkan dropdown tetap terbuka setelah mengklik nama guru, agar bisa memilih nama lain dengan cepat
            });
        });
    </script>
@endsection