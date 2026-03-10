<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::all();
        return view('admin.promotions.index', compact('classes'));
    }

    public function promote(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'target_class_id' => 'required', // Bisa ID kelas atau 'graduated'
        ]);

        if ($request->target_class_id == 'graduated') {
            // Logika untuk kelulusan (set class_id jadi null atau status lulus)
            Student::whereIn('id', $request->student_ids)->update(['class_id' => null]);
            $message = "Siswa terpilih berhasil diatur sebagai Lulus/Alumni.";
        } else {
            // Update class_id ke kelas tujuan
            Student::whereIn('id', $request->student_ids)->update(['class_id' => $request->target_class_id]);
            $message = "Siswa berhasil dinaikkan ke kelas baru.";
        }

        return redirect()->back()->with('success', $message);
    }

    public function getStudentsByClass($class_id)
    {
        // Mengambil siswa berdasarkan class_id
        $students = \App\Models\Student::where('class_id', $class_id)->get();
        return response()->json($students);
    }
}
