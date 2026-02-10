<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'year', 
        'semester', 
        'is_active'
    ];

    public function getNameAttribute()
    {
        return $this->year . ' ' . $this->semester;
    }

    public static function active()
    {
        return self::where('is_active', true)->first();
    }
}