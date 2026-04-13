<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ParentController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\GradeController;

// URL Login: http://localhost:8000/api/login
Route::post('/login', [AuthController::class, 'login']);

// Group Rute yang butuh Token (Harus Login dulu)
Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Ubah menjadi seperti ini:
Route::get('/kelas', [\App\Http\Controllers\Api\TeacherController::class, 'getClasses']);
Route::get('/students/{class_id}', [\App\Http\Controllers\Api\TeacherController::class, 'getStudents']);

Route::get('/kelas/{class_id}/siswa', [AttendanceController::class, 'getStudentsByClass']);
Route::post('/absensi/simpan', [AttendanceController::class, 'store']);
Route::get('/absensi/ambil', [AttendanceController::class, 'getExistingAttendance']);

Route::get('/subjects', [\App\Http\Controllers\Api\TeacherController::class, 'getSubjects']);
Route::post('/nilai/simpan', [GradeController::class, 'store']);
Route::get('/nilai/ambil', [GradeController::class, 'getExistingGrades']);

Route::prefix('parent')->group(function () {
    Route::get('/children', [ParentController::class, 'getChildren']); // Lihat list anak
    Route::get('/grades/{student_id}', [ParentController::class, 'getStudentGrades']); // Lihat nilai
    Route::get('/attendances/{student_id}', [ParentController::class, 'getStudentAttendances']); // Lihat absen
    });

Route::get('/jadwal-guru', [ScheduleController::class, 'jadwalGuru']);
});