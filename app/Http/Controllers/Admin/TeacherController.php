<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    // 1. Tampilkan Daftar Guru
    public function index()
    {
        // Ambil user yang role-nya 'teacher'
        $teachers = User::where('role', 'guru')->orderBy('name', 'asc')->get();
        return view('admin.guru.index', compact('teachers'));
    }

    // 2. Tampilkan Form Tambah Guru
    public function create()
    {
        return view('admin.guru.create');
    }

    // 3. Simpan Guru Baru ke Database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nip' => 'nullable|string'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
            'nip_nis' => $request->nip,
        ]);

        return redirect('/admin/teachers')->with('success', 'Guru berhasil didaftarkan!');
    }

    public function edit($id)
    {
        $teacher = User::findOrFail($id); // Cari user by ID, kalau gak ada error 404
        return view('admin.guru.edit', compact('teacher'));
    }

    // 5. Simpan Perubahan (Update)
    public function update(Request $request, $id)
    {
        $teacher = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            // Validasi email unik KECUALI untuk user ini sendiri (biar gak error kalau email gak diganti)
            'email' => 'required|email|unique:users,email,'.$id,
            'nip' => 'nullable|string'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nip_nis' => $request->nip,
        ];

        // Cek: Apakah admin mengisi password baru?
        // Kalau kosong, berarti password tidak berubah.
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = Hash::make($request->password);
        }

        $teacher->update($data);

        return redirect('/admin/teachers')->with('success', 'Data guru berhasil diperbarui!');
    }

    // 6. Hapus Guru
    public function destroy($id)
    {
        $teacher = User::findOrFail($id);
        $teacher->delete();
        return redirect('/admin/teachers')->with('success', 'Guru berhasil dihapus!');
    }
}