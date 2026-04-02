<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    // Kolom apa saja yang boleh diisi
    protected $fillable = [
        'academic_year_id',
        'class_id',
        'subject_id',
        'teacher_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    // 1. Relasi ke tabel Mata Pelajaran
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    // 2. Relasi ke tabel Users (sebagai Guru)
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // 3. Relasi ke tabel Classes (Kelas)
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}