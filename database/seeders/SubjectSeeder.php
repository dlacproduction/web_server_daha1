<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $mapel = [
            'Pendidikan Agama',
            'PPKN',
            'Bahasa Indonesia',
            'Matematika',
            'Ilmu Pengetahuan Alam (IPA)',
            'Ilmu Pengetahuan Sosial (IPS)',
            'Bahasa Inggris',
            'Seni Budaya',
            'PJOK',
            'Prakarya'
        ];

        foreach ($mapel as $nama) {
            Subject::firstOrCreate(['name' => $nama]);
        }
    }
}