<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman form login
    public function showLoginForm()
    {
        // Jika sudah login sebagai admin, langsung lempar ke dashboard
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard'); // Nanti kita buat route ini
        }
        
        return view('admin.auth.login');
    }

    // Memproses data login
    public function login(Request $request)
    {
        // Ingat, kita menggunakan kolom 'email' di database untuk menyimpan username/email
        $credentials = $request->validate([
            'email'    => 'required', 
            'password' => 'required',
        ]);

        // Coba login menggunakan session Laravel
        if (Auth::attempt($credentials)) {
            
            // Cek apakah yang login BENAR-BENAR seorang Admin
            if (Auth::user()->role === 'admin') {
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard'); 
            }

            // Jika bukan admin (misal guru/wali mencoba login di web), tendang keluar!
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return back()->withErrors([
                'email' => 'Akses ditolak! Anda bukan Administrator.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Username atau Password salah.',
        ])->onlyInput('email');
    }

    // Proses Logout Admin
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}