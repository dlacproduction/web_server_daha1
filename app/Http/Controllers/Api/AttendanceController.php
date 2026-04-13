<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    // 1. Fungsi untuk menarik daftar siswa berdasarkan ID Kelas
    public function getStudentsByClass($class_id)
    {
        $students = Student::where('class_id', $class_id)->orderBy('name', 'asc')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil diambil',
            'data' => $students
        ]);
    }

    // 2. Fungsi untuk menyimpan data absensi massal dari HP
    public function store(Request $request)
    {
        // KODE "Sinyal Masuk" SUDAH SAYA HAPUS DI SINI.
        try {
            $request->validate([
                'class_id' => 'required',
                'date' => 'required|date',
                'absensi_data' => 'required|array', 
            ]);

            $statusMap = ['hadir' => 'H', 'izin' => 'I', 'sakit' => 'S', 'alpha' => 'A'];

            foreach ($request->absensi_data as $absen) {
                $statusTeks = strtolower($absen['status']);
                $statusInisial = $statusMap[$statusTeks] ?? 'A'; 

                // DISESUAIKAN DENGAN MIGRATION: Hanya ada student_id, date, status, dan note
                Attendance::updateOrCreate(
                    [
                        'student_id' => $absen['student_id'],
                        'date'       => $request->date,
                    ],
                    [
                        'status'     => $statusInisial,
                        'note'       => $absen['notes'] ?? null // Dari flutter namanya 'notes', masuk ke DB jadi 'note'
                    ]
                );
            }

            return response()->json([
                'success' => true, 
                'message' => 'Data absensi berhasil disimpan!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Detail Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getExistingAttendance(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'date' => 'required|date',
        ]);

        // KARENA DB TIDAK PUNYA class_id, KITA CARI MURIDNYA DULU
        $studentIds = Student::where('class_id', $request->class_id)->pluck('id');

        $attendances = Attendance::whereIn('student_id', $studentIds)
            ->where('date', $request->date)
            ->get();

        // Mengubah format response agar cocok dengan yang diharapkan Flutter
        $formattedData = $attendances->map(function ($item) {
            return [
                'student_id' => $item->student_id,
                // Mengubah H/I/S/A menjadi kata utuh untuk Flutter
                'status' => $item->status == 'H' ? 'Hadir' : ($item->status == 'S' ? 'Sakit' : ($item->status == 'I' ? 'Izin' : 'Alpha')),
                'notes' => $item->note // Mengirim sebagai 'notes' ke Flutter
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedData
        ]);
    }
}