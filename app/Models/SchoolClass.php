<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    // Pastikan nama tabel sesuai dengan di database (biasanya 'classes')
    protected $table = 'classes';

    protected $fillable = [
        'name',
        'homeroom_teacher_id',
        'academic_year_id'
    ];

    /**
     * Relasi: Kelas "Milik" Satu Guru (Wali Kelas)
     */
    public function teacher()
    {
        // belongsTo artinya teacher_id ada di tabel ini
        return $this->belongsTo(User::class, 'homeroom_teacher_id');
    }

    /**
     * Relasi: Kelas "Punya" Banyak Siswa
     */
    public function students()
    {
        // hasMany artinya class_id ada di tabel students
        return $this->hasMany(Student::class, 'class_id');
    }
}