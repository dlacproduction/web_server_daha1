<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolClass; // Pastikan model ini sesuai dengan nama model Kelas Anda
use App\Models\AcademicYear; // Pastikan model ini sesuai dengan model Tahun Ajaran Anda
use App\Models\Attendance;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // Menampilkan halaman form filter Cetak Presensi
    public function presensiIndex()
    {
        // Ambil data kelas
        $classes = \App\Models\SchoolClass::orderBy('name', 'asc')->get();
        $academicYears = \App\Models\AcademicYear::orderBy('year', 'desc')->get();

        $activeYear = $academicYears->where('is_active', 1)->first();

        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return view('admin.laporan.presensi', compact('classes', 'academicYears', 'bulan', 'activeYear'));
    }

    public function presensiCetak(Request $request)
    {
        $classId = $request->class_id;
        $academicYearId = $request->academic_year_id;
        $bulan = $request->bulan;

        $kelas = SchoolClass::findOrFail($classId);
        
        // AMBIL DATA TAHUN AJARAN (Berdasarkan data Tinker Anda)
        $tapel = \App\Models\AcademicYear::find($academicYearId);
        $tahunText = $tapel ? $tapel->year : '-';
        $semesterText = $tapel ? $tapel->semester : '-';

        $students = Student::where('class_id', $classId)->orderBy('name', 'asc')->get();

        $attendances = Attendance::whereIn('student_id', $students->pluck('id'))
            ->whereMonth('date', $bulan)
            ->get();

        $nama_bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $data = [
            'title' => 'LAPORAN PRESENSI SISWA',
            'nama_kelas' => $kelas->name,
            'tahun_ajaran' => $tahunText,   // Menggunakan kolom 'year'
            'semester' => $semesterText,   // Menggunakan kolom 'semester'
            'bulan_nama' => $nama_bulan[$bulan],
            'students' => $students,
            'attendances' => $attendances
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf_presensi', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan_Presensi_'.$kelas->name.'.pdf');
    }

    public function raporIndex()
    {
        $classes = \App\Models\SchoolClass::orderBy('name', 'asc')->get();
        $academicYears = \App\Models\AcademicYear::orderBy('year', 'desc')->get();
        
        // Cari tahun ajaran yang is_active = 1
        $activeYear = $academicYears->where('is_active', 1)->first();

        // Kirim $activeYear ke view
        return view('admin.laporan.rapor', compact('classes', 'academicYears', 'activeYear'));
    }

    public function raporCetak(Request $request)
    {
        $classId = $request->class_id;
        $academicYearId = $request->academic_year_id;

        $kelas = \App\Models\SchoolClass::findOrFail($classId);
        $tapel = \App\Models\AcademicYear::findOrFail($academicYearId);
        $students = \App\Models\Student::where('class_id', $classId)->orderBy('name', 'asc')->get();

        // Mengambil semua nilai dan merelasikan ke mata pelajaran
        $allGrades = \App\Models\Grade::with('subject')
            ->whereIn('student_id', $students->pluck('id'))
            ->where('academic_year_id', $academicYearId)
            ->get();

        $data = [
            'kelas' => $kelas,
            'tapel' => $tapel,
            'students' => $students,
            'allGrades' => $allGrades,
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.pdf_rapor', $data)
            ->setPaper('a4', 'portrait');
            
        return $pdf->stream('Rapor_Kelas_'.$kelas->name.'.pdf');
    }
}