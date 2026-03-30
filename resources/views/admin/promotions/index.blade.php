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
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <div class="d-flex align-items-center gap-3">
                <span class="fw-bold">Daftar Siswa</span>
                <div class="form-check m-0">
                    <input class="form-check-input" type="checkbox" id="selectAll">
                    <label class="form-check-label" for="selectAll">Pilih Semua</label>
                </div>
            </div>
            <div style="min-width: 250px;">
                <input type="text" id="searchStudent" class="form-control form-control-sm" placeholder="Cari Nama atau NISN...">
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="ps-3">Pilih</th>
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
        const searchInput = document.getElementById('searchStudent');
        
        // Reset kolom pencarian setiap kali ganti kelas
        searchInput.value = '';

        // Kosongkan tabel saat memuat data
        studentList.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4">Memuat data siswa...</td></tr>';

        if (!classId) {
            studentList.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4">Silakan pilih kelas asal terlebih dahulu.</td></tr>';
            return;
        }

        // Ambil data dari server
        // Ambil data dari server
        fetch(`/admin/get-students-by-class/${classId}`)
            .then(response => response.json())
            .then(data => {
                studentList.innerHTML = ''; // Bersihkan loading
                
                if (data.length === 0) {
                    studentList.innerHTML = '<tr><td colspan="4" class="text-center text-danger py-4">Tidak ada siswa di kelas ini.</td></tr>';
                    return;
                }

                // === TAMBAHKAN BARIS INI UNTUK SORTING ASCENDING BERDASARKAN NAMA ===
                data.sort((a, b) => a.name.localeCompare(b.name));

                data.forEach(student => {
                    const row = `
                        <tr class="student-row">
                            <td class="ps-3">
                                <input type="checkbox" name="student_ids[]" value="${student.id}" class="form-check-input student-checkbox">
                            </td>
                            <td class="student-nisn">${student.nis || '-'}</td>
                            <td class="fw-medium student-name">${student.name}</td>
                            <td><span class="badge bg-light text-dark border">${this.options[this.selectedIndex].text}</span></td>
                        </tr>
                    `;
                    studentList.insertAdjacentHTML('beforeend', row);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                studentList.innerHTML = '<tr><td colspan="4" class="text-center text-danger py-4">Gagal mengambil data.</td></tr>';
            });
    });

    // Fitur Pilih Semua
    document.getElementById('selectAll').addEventListener('click', function() {
        // Hanya centang baris yang SEDANG DITAMPILKAN (tidak disembunyikan oleh pencarian)
        const visibleCheckboxes = document.querySelectorAll('.student-row:not([style*="display: none"]) .student-checkbox');
        visibleCheckboxes.forEach(cb => cb.checked = this.checked);
    });

    // Fitur Live Search (Vanilla JS)
    document.getElementById('searchStudent').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#student-list .student-row');

        rows.forEach(row => {
            // Ambil teks NISN dan Nama dari dalam baris tersebut
            const nisn = row.querySelector('.student-nis').textContent.toLowerCase();
            const name = row.querySelector('.student-name').textContent.toLowerCase();

            // Jika kata kunci cocok dengan Nama atau NISN, tampilkan. Jika tidak, sembunyikan.
            if (nisn.includes(searchValue) || name.includes(searchValue)) {
                row.style.display = ''; // Reset display
            } else {
                row.style.display = 'none'; // Sembunyikan
            }
        });
    });
</script>
@endsection