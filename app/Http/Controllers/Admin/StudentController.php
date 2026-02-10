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
        // Fitur pencarian sederhana
        $query = Student::with(['schoolClass', 'parent']);

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
        }

        $students = $query->orderBy('name', 'asc')->paginate(20); // Pakai pagination biar rapi

        return view('admin.siswa.index', compact('students'));
    }

    public function create()
    {
        // Ambil data Kelas & Wali Murid untuk Dropdown
        $classes = SchoolClass::orderBy('name', 'asc')->get();
        $parents = User::where('role', 'wali_murid')->orderBy('name', 'asc')->get();

        return view('admin.siswa.create', compact('classes', 'parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|numeric|unique:students,nis',
            'class_id' => 'required|exists:classes,id',
            'parent_id' => 'required|exists:users,id',
        ]);

        Student::create($request->all());

        return redirect('/admin/students')->with('success', 'Siswa berhasil ditambahkan!');
    }
}