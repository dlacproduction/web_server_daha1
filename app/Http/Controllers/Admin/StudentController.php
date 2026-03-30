<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\User;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['schoolClass', 'parent']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            // Dikelompokkan dengan function($q) agar lebih aman jika ada Where lain nantinya
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%');
            });
        }

        $students = $query->orderBy('nis', 'desc')->paginate(10);
        return view('admin.siswa.index', compact('students')); 
    }

    public function create()
    {
        $classes = SchoolClass::orderBy('name', 'asc')->get();
        $parents = User::where('role', 'wali_murid')->orderBy('name', 'asc')->get();

        return view('admin.siswa.create', compact('classes', 'parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|numeric|unique:students,nis',
            'gender' => 'required|in:Laki - laki,Perempuan', // WAJIB DITAMBAHKAN: Validasi Jenis Kelamin
            'class_id' => 'required|exists:classes,id',
            'parent_id' => 'required|exists:users,id',
        ]);

        Student::create($request->all());

        return redirect('/admin/students')->with('success', 'Siswa berhasil ditambahkan!');
    }

    // --- TAMBAHKAN 3 METHOD DI BAWAH INI UNTUK EDIT & HAPUS ---

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        
        $classes = SchoolClass::orderBy('name', 'asc')->get();
        $parents = User::where('role', 'wali_murid')->orderBy('name', 'asc')->get();

        return view('admin.siswa.edit', compact('student', 'classes', 'parents'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|numeric|unique:students,nis,' . $id, // Pengecualian unik untuk ID ini
            'gender' => 'required|in:Laki - laki,Perempuan', // Validasi Jenis Kelamin
            'class_id' => 'required|exists:classes,id',
            'parent_id' => 'required|exists:users,id',
        ]);

        $student->update($request->all());

        return redirect('/admin/students')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect('/admin/students')->with('success', 'Data siswa berhasil dihapus!');
    }
}