<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ParentAccountController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\User::where('role', 'wali_murid');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $parents = $query->orderBy('id', 'asc')->paginate(10);
        return view('admin.parents.index', compact('parents'));
    }

    public function create() {
        return view('admin.parents.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'wali_murid', // Set role secara otomatis menjadi ortu
        ]);

        return redirect('/admin/parents')->with('success', 'Akun Wali Murid berhasil dibuat');
    }

    public function edit($id)
    {
        $parent = User::where('role', 'wali_murid')->findOrFail($id);
        return view('admin.parents.edit', compact('parent'));
    }

    public function update(Request $request, $id)
    {
        $parent = User::where('role', 'wali_murid')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'nullable|string',
        ], [
            'email.unique' => 'Gagal! Email ini sudah digunakan oleh akun lain.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ];

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $data['password'] = Hash::make($request->password);
        }

        $parent->update($data);

        return redirect('/admin/parents')->with('success', 'Data akun wali murid berhasil diperbarui');
    }

    public function destroy($id)
    {
        $parent = User::where('role', 'wali_murid')->findOrFail($id);
        $parent->delete();

        return redirect('/admin/parents')->with('success', 'Akun wali murid berhasil dihapus');
    }
}