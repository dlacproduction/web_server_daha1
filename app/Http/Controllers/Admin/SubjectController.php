<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::orderBy('name', 'asc')->get();
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
}