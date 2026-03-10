<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ParentAccountController extends Controller
{
    public function index() {
        // Hanya mengambil user dengan role ortu
        $parents = User::where('role', 'wali_murid')->get();
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
}