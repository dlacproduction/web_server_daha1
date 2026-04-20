<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student; // WAJIB ADA: Untuk mengecek token dan NIS siswa
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // WAJIB ADA: Untuk keamanan transaksi database
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // --- 1. FITUR LOGIN ---
    public function login(Request $request)
    {
        // 1. Validasi Input (Perbaikan: ubah 'username' menjadi 'string')
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // 2. Cari User berdasarkan Username (No HP)
        $user = User::where('email', $request->email)->first();

        // 3. Cek Password
        if (! $user || ! \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau Password salah!',
            ], 401);
        }

        // 4. Buat Token (Tiket Masuk)
        $token = $user->createToken('auth_token')->plainTextToken;

        // 5. Kirim Respon ke HP Android
        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil',
            'data' => [
                'user' => $user,
                'token' => $token, 
                'role' => $user->role, 
            ]
        ]);
    }

    // --- 2. FITUR REGISTRASI ORANG TUA (BARU) ---
    public function registerParent(Request $request)
    {
        $request->validate([
            'nama_ortu'  => 'required|string',
            'username'   => 'required|unique:users,email', // Pastikan No HP belum pernah dipakai
            'password'   => 'required|min:6',
            'nis_anak'   => 'required|exists:students,nis',
            'token_anak' => 'required'
        ]);

        // Cari data anak yang NIS dan Token-nya persis seperti inputan
        $student = Student::where('nis', $request->nis_anak)
                          ->where('token', $request->token_anak)
                          ->first();

        // Tolak jika data tidak cocok
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal! NIS atau Kode Token tidak cocok.'
            ], 404);
        }

        // Tolak jika siswa sudah diklaim wali murid lain
        if ($student->parent_id != null) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa ini sudah terhubung dengan akun orang tua lain.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Buat akun orang tua
            $user = User::create([
                'name'     => $request->nama_ortu,
                'email' => $request->username,
                'password' => Hash::make($request->password),
                'role'     => 'wali_murid',
            ]);

            // Sambungkan akun tersebut ke data anak
            $student->update([
                'parent_id' => $user->id,
                'token'     => null
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil! Silakan login.',
                'data'    => [
                    'user'  => $user,
                    'token' => $token,
                    'role'  => $user->role,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    public function claimChild(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nis'   => 'required|exists:students,nis',
            'token' => 'required'
        ]);

        // 2. Cari data anak
        $student = \App\Models\Student::where('nis', $request->nis)
                                      ->where('token', $request->token)
                                      ->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal! NIS atau Kode Token tidak cocok.'
            ], 404);
        }

        if ($student->parent_id != null) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa ini sudah terhubung dengan akun lain.'
            ], 400);
        }

        // 3. Ambil data orang tua yang sedang login saat ini
        $user = $request->user(); 

        // 4. Update data anak dengan ID orang tua tersebut
        $student->update([
            'parent_id' => $user->id,
            'token'     => null // Hanguskan token
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan data anak!'
        ]);
    }

    // --- 3. FITUR LOGOUT ---
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logout Berhasil'
        ]);
    }
}