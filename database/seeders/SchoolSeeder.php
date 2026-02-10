<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Tahun Ajaran Aktif
        $academicYear = AcademicYear::create([
            'name' => '2025/2026',
            'semester' => 'Ganjil',
            'is_active' => true,
        ]);

        // 2. Ambil Data Guru dari UserSeeder sebelumnya
        $guru = User::where('role', 'guru')->first();
        
        // Ambil Data Wali Murid juga (untuk contoh relasi)
        $wali = User::where('role', 'wali_murid')->first();

        // 3. Buat Kelas VII-A
        $kelas7A = SchoolClass::create([
            'name' => 'VII-A',
            'academic_year_id' => $academicYear->id,
            'homeroom_teacher_id' => $guru ? $guru->id : null,
        ]);

        // 4. Buat 5 Siswa di Kelas VII-A
        $siswaNames = ['Fakhrudin Rama Purnomo', 'Ahmad Khilmi', 'Santika Putri Nuraini', 'Tri Kurniawan', 'Ahmad Ridwan', 'Khoirul Ahmad'];

        foreach ($siswaNames as $index => $name) {
            Student::create([
                'nis' => '202500' . ($index + 1), // NIS: 2025001, 2025002, dst
                'name' => $name,
                'class_id' => $kelas7A->id,
                // Siswa pertama kita hubungkan ke akun Wali Murid tadi
                'parent_id' => ($index == 0) ? $wali->id : null, 
            ]);
        }
    }
}