<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ParentController;

// URL Login: http://localhost:8000/api/login
Route::post('/login', [AuthController::class, 'login']);

// Group Rute yang butuh Token (Harus Login dulu)
Route::middleware('auth:sanctum')->group(function () {
    
    // URL Logout: http://localhost:8000/api/logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Contoh: Cek User yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/classes', [\App\Http\Controllers\Api\TeacherController::class, 'getClasses']);
    
    // Ambil daftar siswa berdasarkan ID Kelas
    Route::get('/students/{class_id}', [\App\Http\Controllers\Api\TeacherController::class, 'getStudents']);

    // ... rute sebelumnya
    
    // Simpan Presensi
    Route::post('/attendance', [\App\Http\Controllers\Api\TeacherController::class, 'storeAttendance']);
    // Nanti kita tambah rute presensi dan nilai di sini...

    Route::get('/subjects', [\App\Http\Controllers\Api\TeacherController::class, 'getSubjects']);
    Route::post('/grades', [\App\Http\Controllers\Api\TeacherController::class, 'storeGrades']);

    Route::prefix('parent')->group(function () {
        Route::get('/children', [ParentController::class, 'getChildren']); // Lihat list anak
        Route::get('/grades/{student_id}', [ParentController::class, 'getStudentGrades']); // Lihat nilai
        Route::get('/attendances/{student_id}', [ParentController::class, 'getStudentAttendances']); // Lihat absen
    });
});