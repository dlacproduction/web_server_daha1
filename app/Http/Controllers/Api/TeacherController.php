<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Subject;
use App\Models\Grade;

class TeacherController extends Controller
{
    // 1. API Get Daftar Kelas (Agar guru bisa memilih kelas yg mau dipresensi)
    public function getClasses()
    {
        $classes = SchoolClass::all();
        
        return response()->json([
            'success' => true,
            'data' => $classes
        ]);
    }

    // 2. API Get Siswa per Kelas (Setelah guru pilih kelas, muncul daftar siswanya)
    public function getStudents($class_id)
    {
        // Cari kelasnya dulu
        $schoolClass = SchoolClass::find($class_id);

        if (!$schoolClass) {
            return response()->json(['success' => false, 'message' => 'Kelas tidak ditemukan'], 404);
        }

        // Ambil siswa yang ada di kelas itu
        $students = $schoolClass->students()->orderBy('name', 'asc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Siswa Kelas ' . $schoolClass->name,
            'data' => $students
        ]);
    }

    public function storeAttendance(Request $request)
    {
        // Validasi data yang dikirim dari Android
        $request->validate([
            'date' => 'required|date',
            'students' => 'required|array', // Harus berupa daftar array
            'students.*.student_id' => 'required|exists:students,id',
            'students.*.status' => 'required|in:H,I,S,A', // Hanya boleh H, I, S, atau A
            'students.*.note' => 'nullable|string',
        ]);

        $date = $request->date;
        $studentsData = $request->students;

        foreach ($studentsData as $data) {
            Attendance::updateOrCreate(
                [
                    // Cek apakah data ini sudah ada? (Kunci Unik)
                    'student_id' => $data['student_id'],
                    'date' => $date,
                ],
                [
                    // Jika ada update, jika belum ada buat baru
                    'status' => $data['status'],
                    'note' => $data['note'] ?? null,
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Data presensi berhasil disimpan untuk tanggal ' . $date,
        ]);
    }

    public function getSubjects()
    {
        $subjects = Subjects::orderBy('name', 'asc')->get();
        return response()->json(['success' => true,  'data' => $subjects]);
    }

    public function storeGrades(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'type' => 'required|in:UH1,UH2,UTS,UAS,Tugas', // Validasi tipe nilai
            'grades' => 'required|array',
            'grades.*.student_id' => 'required|exists:students,id',
            'grades.*.score' => 'required|numeric|min:0|max:100',
            'grades.*.description' => 'nullable|string',
        ]);

        foreach ($request->grades as $data) {
            Grade::updateOrCreate(
                [
                    'student_id' => $data['student_id'],
                    'subject_id' => $request->subject_id,
                    'type' => $request->type,
                    'academic_year_id' => $request->academic_year_id,
                ],
                [
                    'score' => $data['score'],
                    'description' => $data['description'] ?? null,
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Nilai berhasil disimpan!',
        ]);
    }
}