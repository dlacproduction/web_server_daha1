<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'name',
        'class_id',
        'parent_id'
    ];

    // Relasi: Siswa milik satu Kelas
    public function schoolClass()
    {
        // Parameter kedua 'class_id' adalah nama kolom di tabel students
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    // Relasi: Siswa punya satu Wali Murid (dari tabel User)
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
}