<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['student_id', 'date', 'status', 'note'];

    // Relasi: Absensi -> Siswa
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
