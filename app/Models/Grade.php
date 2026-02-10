<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    // Tambahkan daftar kolom yang boleh diisi di sini
    protected $fillable = [
        'student_id',
        'subject_id',
        'academic_year_id',
        'teacher_id',
        'semester',
        'assignment_score',
        'mid_exam_score',
        'final_exam_score',
        'final_score',
        'description'
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