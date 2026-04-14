<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Attendance;

class ParentController extends Controller
{
    // 1. API Lihat Daftar Anak
    public function getChildren(Request $request)
    {
        $user = $request->user();

        // Cek apakah user benar-benar role parent
        if ($user->role !== 'wali_murid') {
            return response()->json(['message' => 'Unauthorized. Khusus Wali Murid.'], 403);
        }

        // Ambil data siswa yang parent_id nya adalah user yang login ini
        // with('class') agar nama kelasnya langsung terbawa
        $children = $user->students()->with('schoolClass')->get();

        return response()->json([
            'success' => true,
            'data' => $children
        ]);
    }

    // 2. API Lihat Nilai Anak (Berdasarkan ID Siswa)
    public function getStudentGrades(Request $request, $student_id)
    {
        $user = $request->user();

        // KEAMANAN PENTING:
        // Cek apakah siswa ini benar-benar anak dari user yang login
        $student = Student::where('id', $student_id)
                          ->where('parent_id', $user->id)
                          ->first();

        if (!$student) {
            return response()->json(['message' => 'Siswa tidak ditemukan atau bukan anak anda.'], 404);
        }

        // Ambil nilai, include nama mapel & tahun ajaran
        $grades = Grade::where('student_id', $student_id)
                        ->with(['subject', 'academicYear'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->json([
            'success' => true,
            'student_name' => $student->name,
            'data' => $grades
        ]);
    }

    // 3. API Lihat Absensi Anak
    public function getStudentAttendances(Request $request, $student_id)
    {
        $user = $request->user();

        // KEAMANAN LAGI: Cek kepemilikan data anak
        $student = Student::where('id', $student_id)
                          ->where('parent_id', $user->id)
                          ->first();

        if (!$student) {
            return response()->json(['message' => 'Siswa tidak ditemukan atau bukan anak anda.'], 404);
        }

        // Ambil absensi 30 hari terakhir
        $attendances = Attendance::where('student_id', $student_id)
                                ->orderBy('date', 'desc')
                                ->limit(185)
                                ->get();

        return response()->json([
            'success' => true,
            'student_name' => $student->name,
            'data' => $attendances
        ]);
    }
}