<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\User;
use App\Model\AcademicYear;

class SchoolClassController extends Controller
{
    public function index()
    {
        // Ambil semua kelas beserta data wali kelasnya
        $classes = SchoolClass::with('teacher')->orderBy('name', 'asc')->get();
        return view('admin.kelas.index', compact('classes'));
    }

    public function create()
    {
        // Kita butuh daftar guru untuk dipilih jadi Wali Kelas
        $teachers = User::where('role', 'guru')->orderBy('name', 'asc')->get();
        return view('admin.kelas.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'homeroom_teacher_id' => 'required|exists:users,id',
        ]);

        $activeYear = AcademicYear::where('is_active', true)->first();

        if (!$activeYear) {
            return back()->with('error', 'Gagal! Belum ada Tahun Ajaran yang diaktifkan. Silakan setting menu Tahun Ajaran dulu.');
        }

        SchoolClass::create([
            'name' => $request->name,
            'homeroom_teacher_id' => $request->homeroom_teacher_id,
            'academic_year_id' => $activeYear->id,
        ]);

        return redirect('/admin/classes')->with('success', 'Kelas berhasil dibuat!');
    }
    
    public function edit($id)
    {
        $class = SchoolClass::findOrFail($id);
        // Kita butuh daftar guru lagi untuk dropdown ganti wali kelas
        $teachers = User::where('role', 'guru')->orderBy('name', 'asc')->get();
        
        return view('admin.kelas.edit', compact('class', 'teachers'));
    }

    // 5. Update Kelas
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'homeroom_teacher_id' => 'required|exists:users,id',
        ]);

        $class = SchoolClass::findOrFail($id);
        
        $class->update([
            'name' => $request->name,
            'homeroom_teacher_id' => $request->homeroom_teacher_id,
        ]);

        return redirect('/admin/classes')->with('success', 'Data kelas berhasil diperbarui!');
    }

    // 6. Hapus Kelas
    public function destroy($id)
    {
        $class = SchoolClass::findOrFail($id);
        
        // Opsional: Cek apakah kelas masih punya siswa?
        if ($class->students()->count() > 0) {
            return back()->with('error', 'Gagal hapus! Kelas ini masih memiliki siswa.');
        }

        $class->delete();
        return redirect('/admin/classes')->with('success', 'Kelas berhasil dihapus!');
    }
}