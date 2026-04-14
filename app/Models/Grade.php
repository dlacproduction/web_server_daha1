<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    // INI KUNCI UTAMANYA: Izinkan Laravel mengisi kolom-kolom ini
    protected $fillable = [
        'student_id',
        'subject_id',
        'academic_year_id',
        'type',
        'score',
        'description',
    ];

    // Relasi ke Siswa
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi ke Mapel
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // --- INI YANG BARU & WAJIB DITAMBAHKAN ---
    // Relasi ke Tahun Ajaran
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }
}