@extends('layout.app')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold m-0">Fitur Kenaikan Kelas</h4>
    <p class="text-muted small">Pindahkan siswa antar kelas atau atur status kelulusan secara massal.</p>
</div>

<form action="{{ url('/admin/promotions') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">1. Pilih Kelas Asal</label>
                            <select id="source_class" class="form-select">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">2. Pilih Kelas Tujuan</label>
                            <select name="target_class_id" class="form-select" required>
                                <option value="">-- Pilih Kelas Tujuan --</option>
                                <option value="graduated" class="text-danger fw-bold">LULUS / ALUMNI</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100" onclick="return confirm('Apakah Anda yakin ingin memproses kenaikan kelas ini?')">
                                <i class="bi bi-arrow-up-circle me-1"></i> Proses Kenaikan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>Daftar Siswa</span>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectAll">
                <label class="form-check-label" for="selectAll">Pilih Semua</label>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">Pilih</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Kelas Saat Ini</th>
                        </tr>
                    </thead>
                    <tbody id="student-list">
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</form>

<script>
    document.getElementById('source_class').addEventListener('change', function() {
        const classId = this.value;
        const studentList = document.getElementById('student-list');
        
        // Kosongkan tabel saat memuat data
        studentList.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Memuat data siswa...</td></tr>';

        if (!classId) {
            studentList.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Silakan pilih kelas asal terlebih dahulu.</td></tr>';
            return;
        }

        // Ambil data dari server
        fetch(`/admin/get-students-by-class/${classId}`)
            .then(response => response.json())
            .then(data => {
                studentList.innerHTML = ''; // Bersihkan loading
                
                if (data.length === 0) {
                    studentList.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Tidak ada siswa di kelas ini.</td></tr>';
                    return;
                }

                data.forEach(student => {
                    const row = `
                        <tr>
                            <td>
                                <input type="checkbox" name="student_ids[]" value="${student.id}" class="form-check-input student-checkbox">
                            </td>
                            <td>${student.nisn || '-'}</td>
                            <td class="fw-medium">${student.name}</td>
                            <td><span class="badge bg-light text-dark border">${this.options[this.selectedIndex].text}</span></td>
                        </tr>
                    `;
                    studentList.insertAdjacentHTML('beforeend', row);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                studentList.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Gagal mengambil data.</td></tr>';
            });
    });

    // Fitur Pilih Semua
    document.getElementById('selectAll').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
@endsection