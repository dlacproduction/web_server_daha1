<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\AcademicYear;

class GradeController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi data
        $request->validate([
            'subject_id' => 'required',
            'type'       => 'required|in:UH1,UH2,UTS,UAS,Tugas',
            'nilai_data' => 'required|array', 
        ]);

        // 2. PERBAIKAN: Cari Tahun Ajaran yang berstatus AKTIF (is_active = 1)
        $tahunAjaran = AcademicYear::where('is_active', 1)->first();
        
        // Fallback: Jika tidak ada yang diset aktif, baru ambil yang terbaru
        if (!$tahunAjaran) {
            $tahunAjaran = AcademicYear::latest()->first();
        }
        
        $academic_year_id = $tahunAjaran ? $tahunAjaran->id : 1; 

        // 3. Simpan nilai
        foreach ($request->nilai_data as $data) {
            if ($data['score'] === null || $data['score'] === '') {
                continue; 
            }

            Grade::updateOrCreate(
                [
                    'student_id'       => $data['student_id'],
                    'subject_id'       => $request->subject_id,
                    'type'             => $request->type,
                    'academic_year_id' => $academic_year_id,
                ],
                [
                    'score'       => $data['score'],
                    'description' => $data['description'] ?? null
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Data nilai berhasil disimpan di Tahun Ajaran: ' . $tahunAjaran->year
        ]);
    }

    public function getExistingGrades(Request $request)
    {
        $request->validate([
            'subject_id' => 'required',
            'class_id'   => 'required',
            'type'       => 'required',
        ]);

        // PERBAIKAN: Gunakan logika yang sama (Cari yang is_active = 1)
        $tahunAjaran = AcademicYear::where('is_active', 1)->first() ?? AcademicYear::latest()->first();
        $academic_year_id = $tahunAjaran ? $tahunAjaran->id : 1;

        $grades = Grade::where('subject_id', $request->subject_id)
            ->where('type', $request->type)
            ->where('academic_year_id', $academic_year_id)
            ->whereIn('student_id', function($query) use ($request) {
                $query->select('id')->from('students')->where('class_id', $request->class_id);
            })
            ->get();

        return response()->json([
            'success' => true,
            'data' => $grades
        ]);
    }
}