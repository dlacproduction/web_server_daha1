<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Subject::query();

        // Menggunakan logika pencarian yang sama persis dengan StudentController
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('kode_mapel', 'like', '%' . $search . '%');
            });
        }

        // Menggunakan paginate(10) agar seragam dengan halaman siswa (bukan get())
        $subjects = $query->orderBy('id', 'asc')->get();
        
        return view('admin.mapel.index', compact('subjects'));
    }

    public function create()
    {
        return view('admin.mapel.create');
    }

    public function store(Request $request)
    {
        // Validasi data terlebih dahulu
        $validator = Validator::make($request->all(), [
            'kode_mapel' => 'required|string|max:5|unique:subjects,kode_mapel',
            'name' => 'required|string|max:100|unique:subjects,name',
        ], [
            'kode_mapel.unique' => 'Kode Mapel sudah digunakan, gunakan kode lain.',
            'name.unique' => 'Mata Pelajaran sudah terdaftar, silahkan coba lagi.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
            ->withInput()
            ->with('error', $validator->errors()->first());
        }

        \App\Models\Subject::create([
            'kode_mapel' => $request->kode_mapel,
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
        $validator = Validator::make($request->all(), [
            'kode_mapel' => 'required|string|max:20|unique:subjects,kode_mapel,' . $id,
            'name' => 'required|string|max:255|unique:subjects,name,' . $id,
            'teacher_ids' => 'nullable|array',
            'teacher_ids.*' => 'exists:users,id'
        ], [
            'kode_mapel.unique' => 'Kode Mapel sudah digunakan, gunakan kode lain.',
            'name.unique' => 'Mata Pelajaran sudah terdaftar, silahkan coba lagi'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
            ->withInput()
            ->with('error', $validator->errors()->first());
        }

        $subject = \App\Models\Subject::findOrFail($id);
        $subject->update([
            'kode_mapel' => $request->kode_mapel,
            'name' => $request->name
            ]);
        $subject->teachers()->sync($request->teacher_ids ?? []);

        return redirect('/admin/subjects')->with('success', 'Data mata pelajaran berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $subject = \App\Models\Subject::findOrFail($id);
        
        // Hapus mapel dari database
        $subject->delete();

        return redirect('/admin/subjects')->with('success', 'Mata Pelajaran berhasil dihapus!');
    }
}