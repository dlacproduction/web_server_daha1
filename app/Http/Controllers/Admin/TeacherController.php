<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    // 1. Tampilkan Daftar Guru
    public function index(Request $request)
    {
        // Mulai query untuk mengambil user dengan role 'guru'
        $query = User::where('role', 'guru');

        // Jika ada input pencarian ('search')
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            
            // Filter berdasarkan Nama atau NIP
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('nip_nis', 'like', '%' . $search . '%');
            });
        }

        // Eksekusi query dan urutkan berdasarkan nama
        $teachers = $query->orderBy('name', 'asc')->get();
        
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
        ], [
            'email.unique' => 'Gagal! Email sudah terdaftar untuk data guru lain.'
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
        ], [
            'email.unique' => 'Gagal! Email sudah terdaftar untuk data guru lain.'
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