<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    // Tambahkan daftar kolom yang boleh diisi di sini
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

    // Relasi ke Siswa (Opsional, tapi bagus untuk nanti)
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi ke Mapel (Opsional)
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}