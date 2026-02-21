<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\AcademicYearController;

Route::get('/', function () {
    return redirect('/admin/dashboard');
});

// Update route dashboard di web.php
Route::get('/admin/dashboard', function () {
    // Hitung data untuk widget
    $totalGuru = \App\Models\User::where('role', 'guru')->count();
    $totalSiswa = \App\Models\Student::count();
    $totalKelas = \App\Models\SchoolClass::count();
    $tahunAktif = \App\Models\AcademicYear::where('is_active', true)->first();

    return view('/admin/dashboard', compact('totalGuru', 'totalSiswa', 'totalKelas', 'tahunAktif'));
});

// Route CRUD Guru
Route::get('/admin/teachers', [TeacherController::class, 'index']);
Route::get('/admin/teachers/create', [TeacherController::class, 'create']);
Route::post('/admin/teachers', [TeacherController::class, 'store']);

Route::get('/admin/teachers/{id}/edit', [TeacherController::class, 'edit']);
Route::put('/admin/teachers/{id}', [TeacherController::class, 'update']);
Route::delete('/admin/teachers/{id}', [TeacherController::class, 'destroy']);

// Route CRUD Kelas
Route::get('/admin/classes', [SchoolClassController::class, 'index']);
Route::get('/admin/classes/create', [SchoolClassController::class, 'create']);
Route::post('/admin/classes', [SchoolClassController::class, 'store']);

Route::get('/admin/classes/{id}/edit', [SchoolClassController::class, 'edit']);
Route::put('/admin/classes/{id}', [SchoolClassController::class, 'update']);
Route::delete('/admin/classes/{id}', [SchoolClassController::class, 'destroy']);

// Route CRUD Siswa
Route::get('/admin/students', [StudentController::class, 'index']);
Route::get('/admin/students/create', [StudentController::class, 'create']);
Route::post('/admin/students', [StudentController::class, 'store']);

// Route CRUD Mapel
Route::get('/admin/subjects', [SubjectController::class, 'index']);
Route::get('/admin/subjects/create', [SubjectController::class, 'create']);
Route::post('/admin/subjects', [SubjectController::class, 'store']);

// CRUD Tahun Ajaran
Route::get('/admin/academic-years', [AcademicYearController::class, 'index']);
Route::get('/admin/academic-years/create', [AcademicYearController::class, 'create']);
Route::post('/admin/academic-years', [AcademicYearController::class, 'store']);
Route::post('/admin/academic-years/{id}/activate', [AcademicYearController::class, 'setActive']); // Route khusus aktivasi
Route::delete('/admin/academic-years/{id}', [AcademicYearController::class, 'destroy']);