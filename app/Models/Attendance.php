<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'class_id',
        'date',
        'teacher_id',
        'status',
        'note'
    ];

    // Relasi: Absensi -> Siswa
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
