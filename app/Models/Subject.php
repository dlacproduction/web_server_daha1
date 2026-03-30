<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    // Daftarkan kolom tabel Anda di sini (JANGAN masukkan _token)
    protected $fillable = ['name']; 

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'subject_user', 'subject_id', 'user_id')
                    ->where('role', 'guru'); // Memastikan hanya mengambil user dengan role guru
    }
}