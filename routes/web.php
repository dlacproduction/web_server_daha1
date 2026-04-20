<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\ParentAccountController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\AuthController;

// Halaman awal langsung diarahkan ke dashboard admin
Route::get('/', function () {
    return redirect('/admin/login');
});

// =========================================================================
// AREA ADMIN (Semua URL di bawah ini akan otomatis diawali '/admin')
// =========================================================================
Route::prefix('admin')->group(function () {
    
    // --- Rute yang bisa diakses TANPA Login ---
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // --- Rute yang WAJIB LOGIN sebagai Admin (Dilindungi) ---
    Route::middleware(['auth'])->group(function () {
        
        // 1. Dashboard Admin Terintegrasi Data
        Route::get('/dashboard', function () {
            $totalGuru = \App\Models\User::where('role', 'guru')->count();
            $totalSiswa = \App\Models\Student::count();
            $totalKelas = \App\Models\SchoolClass::count();
            $tahunAktif = \App\Models\AcademicYear::where('is_active', true)->first();

            return view('admin.dashboard', compact('totalGuru', 'totalSiswa', 'totalKelas', 'tahunAktif'));
        })->name('admin.dashboard');

        // 2. CRUD Guru
        Route::get('/teachers', [TeacherController::class, 'index']);
        Route::get('/teachers/create', [TeacherController::class, 'create']);
        Route::post('/teachers', [TeacherController::class, 'store']);
        Route::get('/teachers/{id}/edit', [TeacherController::class, 'edit']);
        Route::put('/teachers/{id}', [TeacherController::class, 'update']);
        Route::delete('/teachers/{id}', [TeacherController::class, 'destroy']);

        // 3. CRUD Kelas
        Route::get('/classes', [SchoolClassController::class, 'index']);
        Route::get('/classes/create', [SchoolClassController::class, 'create']);
        Route::post('/classes', [SchoolClassController::class, 'store']);
        Route::get('/classes/{id}/edit', [SchoolClassController::class, 'edit']);
        Route::put('/classes/{id}', [SchoolClassController::class, 'update']);
        Route::delete('/classes/{id}', [SchoolClassController::class, 'destroy']);

        // 4. CRUD Siswa & Print Token
        Route::get('/students', [StudentController::class, 'index']);
        Route::get('/students/create', [StudentController::class, 'create']);
        Route::post('/students', [StudentController::class, 'store']);
        Route::get('/students/{id}/edit', [StudentController::class, 'edit']);
        Route::put('/students/{id}', [StudentController::class, 'update']);
        Route::delete('/students/{id}', [StudentController::class, 'destroy']);
        Route::get('/students/export', [StudentController::class, 'exportExcel']);
        Route::get('/students/print-tokens', [StudentController::class, 'printTokens']);

        // 5. CRUD Mata Pelajaran
        Route::get('/subjects', [SubjectController::class, 'index']);
        Route::get('/subjects/create', [SubjectController::class, 'create']);
        Route::post('/subjects', [SubjectController::class, 'store']);
        Route::get('/subjects/{id}/edit', [SubjectController::class, 'edit']);
        Route::put('/subjects/{id}', [SubjectController::class, 'update']);
        Route::delete('/subjects/{id}', [SubjectController::class, 'destroy']);

        // 6. CRUD Tahun Ajaran
        Route::get('/academic-years', [AcademicYearController::class, 'index']);
        Route::get('/academic-years/create', [AcademicYearController::class, 'create']);
        Route::post('/academic-years', [AcademicYearController::class, 'store']);
        Route::post('/academic-years/{id}/activate', [AcademicYearController::class, 'setActive']); 
        Route::delete('/academic-years/{id}', [AcademicYearController::class, 'destroy']);

        // 7. CRUD Wali Murid
        Route::get('/parents', [ParentAccountController::class, 'index']);
        Route::get('/parents/create', [ParentAccountController::class, 'create']);
        Route::post('/parents', [ParentAccountController::class, 'store']);
        Route::get('/parents/{id}/edit', [ParentAccountController::class, 'edit']);
        Route::put('/parents/{id}', [ParentAccountController::class, 'update']);
        Route::delete('/parents/{id}', [ParentAccountController::class, 'destroy']);

        // 8. Kenaikan Kelas
        Route::get('/promotions', [PromotionController::class, 'index']);
        Route::post('/promotions', [PromotionController::class, 'promote']);
        Route::get('/get-students-by-class/{class_id}', [PromotionController::class, 'getStudentsByClass']);

        // 9. Jadwal
        Route::get('/jadwal', [ScheduleController::class, 'index']);
        Route::get('/jadwal/create', [ScheduleController::class, 'create']);
        Route::post('/jadwal', [ScheduleController::class, 'store']);
        Route::get('/jadwal/{id}/edit', [ScheduleController::class, 'edit']);
        Route::put('/jadwal/{id}', [ScheduleController::class, 'update']);
        Route::delete('/jadwal/{id}', [ScheduleController::class, 'destroy']);
        Route::get('/jadwal/pdf', [ScheduleController::class, 'downloadPdf']);

        // 10. Laporan
        Route::get('/laporan/presensi', [ReportController::class, 'presensiIndex']);
        Route::get('/laporan/presensi/cetak', [ReportController::class, 'presensiCetak']);
        Route::get('/laporan/rapor', [ReportController::class, 'raporIndex']);
        Route::get('/laporan/rapor/cetak', [ReportController::class, 'raporCetak']);
    });
});