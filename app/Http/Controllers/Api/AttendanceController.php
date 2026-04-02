<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    // 1. Fungsi untuk menarik daftar siswa berdasarkan ID Kelas
    public function getStudentsByClass($class_id)
    {
        $students = Student::where('class_id', $class_id)->orderBy('name', 'asc')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil diambil',
            'data' => $students
        ]);
    }

    // 2. Fungsi untuk menyimpan data absensi massal dari HP
    public function store(Request $request)
    {
        // 1. Validasi data masuk dari Flutter
        $request->validate([
            'class_id' => 'required',
            'date' => 'required|date',
            'absensi' => 'required|array', 
        ]);

        $teacher_id = $request->user()->id;

        // 2. Kamus Penerjemah Status (Dari Flutter ke Database)
        $statusMap = [
            'hadir' => 'H',
            'izin'  => 'I',
            'sakit' => 'S',
            'alpha' => 'A'
        ];

        // 3. Simpan ke database
        foreach ($request->absensi as $absen) {
            // Ambil inisialnya (H/I/S/A). Jika tidak valid, default-kan jadi 'A'
            $statusTeks = strtolower($absen['status']);
            $statusInisial = $statusMap[$statusTeks] ?? 'A'; 

            // updateOrCreate agar tidak ada data ganda di hari dan kelas yang sama
            Attendance::updateOrCreate(
                [
                    'student_id' => $absen['student_id'],
                    'class_id'   => $request->class_id,
                    'date'       => $request->date,
                ],
                [
                    'teacher_id' => $teacher_id,
                    'status'     => $statusInisial
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Data absensi berhasil disimpan!'
        ]);
    }
}