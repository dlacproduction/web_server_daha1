<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::orderBy('id', 'asc')->get();
        return view('admin.mapel.index', compact('subjects'));
    }

    public function create()
    {
        return view('admin.mapel.create');
    }

    public function store(Request $request)
    {
        // Validasi data terlebih dahulu
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        // Hanya ambil field yang dibutuhkan database
        \App\Models\Subject::create([
            'name' => $request->name
        ]);

        return redirect('/admin/subjects')->with('success', 'Mata Pelajaran berhasil ditambahkan');
    }

    // Menampilkan halaman form edit
    public function edit(string $id)
    {
        $subject = \App\Models\Subject::findOrFail($id); // Sesuaikan nama Model Anda
        
        $teachers = \App\Models\User::where('role', 'guru')->get();

        return view('admin.mapel.edit', compact('subject', 'teachers'));
    }

    // Memproses data yang diubah
    public function update(Request $request, string $id)
    {
        // Sesuaikan validasi dengan nama kolom di database Anda
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'teacher_ids' => 'nullable|array',
            'teacher_ids*' => 'exists:users,id'
        ]);

        $subject = \App\Models\Subject::findOrFail($id);
        $subject->update(['name' => $validatedData['name']]);
        $subject->teachers()->sync($request->teacher_ids ?? []);

        return redirect('/admin/subjects')->with('success', 'Data mata pelajaran berhasil diperbarui!');
    }
}