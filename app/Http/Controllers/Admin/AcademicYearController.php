<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicYear;

class AcademicYearController extends Controller
{
    public function index()
    {
        $years = AcademicYear::orderBy('created_at', 'desc')->get();
        return view('admin.academic_years.index', compact('years'));
    }

    public function create()
    {
        return view('admin.academic_years.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year'     => 'required|string',             // Input dari form bernama 'year'
            'semester' => 'required|in:Ganjil,Genap',    // Input dari form bernama 'semester'
        ]);

        // 2. Simpan ke Database
        AcademicYear::create([
            'year'      => $request->year,     // <--- Petakan 'year' ke kolom 'name'
            'semester'  => $request->semester, // <--- Semester tetap ke semester
            'is_active' => false               // Default false
        ]);

        return redirect('/admin/academic-years')->with('success', 'Tahun ajaran berhasil dibuat!');
    }

    // --- FITUR KUNCI: AKTIFKAN TAHUN AJARAN ---
    public function setActive($id)
    {
        // 1. Non-aktifkan SEMUA tahun ajaran dulu
        AcademicYear::query()->update(['is_active' => false]);

        // 2. Aktifkan tahun ajaran yang dipilih
        $year = AcademicYear::findOrFail($id);
        $year->update(['is_active' => true]);

        return redirect('/admin/academic-years')->with('success', "Tahun ajaran {$year->name} sekarang AKTIF!");
    }
    
    public function destroy($id)
    {
        $year = AcademicYear::findOrFail($id);
        if($year->is_active) {
            return back()->with('error', 'Tidak bisa menghapus tahun ajaran yang sedang aktif!');
        }
        $year->delete();
        return back()->with('success', 'Tahun ajaran dihapus.');
    }
}