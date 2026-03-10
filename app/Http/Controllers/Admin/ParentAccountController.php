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

        $parents = $query->orderBy('name', 'asc')->paginate(10);
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