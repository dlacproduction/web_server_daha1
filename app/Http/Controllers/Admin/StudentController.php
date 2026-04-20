<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\SchoolClass; // Cukup dipanggil sekali, kita gunakan ini untuk menggantikan 'Kelas'
use App\Models\User;
use App\Exports\SiswaExport;
use Maatwebsite\Excel\Facades\Excel; // Typo 'Facadas' sudah diperbaiki
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $filterKelas = $request->class_id;
        
        // Perbaikan: Menggunakan SchoolClass, bukan Kelas
        $kelasList = SchoolClass::orderBy('name', 'asc')->get(); 
        
        $query = Student::with(['schoolClass', 'parent']);

        // --- TAMBAHAN PENTING: Logika Filter Kelas ---
        if ($filterKelas) {
            $query->where('class_id', $filterKelas);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%');
            });
        }

        $students = $query->orderBy('nis', 'desc')->paginate(10);
        
        // Perbaikan: Pastikan $kelasList dan $filterKelas ikut dikirim ke View agar dropdown di HTML bisa membaca datanya
        return view('admin.siswa.index', compact('students', 'kelasList', 'filterKelas')); 
    }

    // --- FUNGSI BARU: Untuk Mengunduh Excel ---
    public function exportExcel(Request $request)
    {
        $filterKelas = $request->class_id;
        
        // Cek apakah ada filter kelas yang dikirim
        if ($filterKelas) {
            // Cari data kelas berdasarkan ID tersebut
            $kelas = \App\Models\SchoolClass::find($filterKelas);
            
            // Ambil nama kelasnya (misal: "VII-A"), ganti spasi dengan underscore agar aman di semua OS
            $namaKelas = $kelas ? $kelas->name : $filterKelas;
            
            $namaFile = "Data Siswa Kelas $namaKelas.xlsx";
        } else {
            // Jika tidak ada filter, berarti unduh semua
            $namaFile = "Data Semua Siswa.xlsx";
        }

        return Excel::download(new SiswaExport($filterKelas), $namaFile);
    }

    public function create()
    {
        $classes = SchoolClass::orderBy('name', 'asc')->get();
        $parents = User::where('role', 'wali_murid')->orderBy('name', 'asc')->get();

        return view('admin.siswa.create', compact('classes', 'parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|numeric|unique:students,nis',
            'gender' => 'required|in:Laki - laki,Perempuan',
            'class_id' => 'required|exists:classes,id',
            'parent_id' => 'nullable|exists:users,id',
        ]);

        $kodeUnik = mt_rand(100000, 999999);

        Student::create([
            'nis'      => $request->nis,
            'name'     => $request->name,
            'gender'   => $request->gender,
            'class_id' => $request->class_id,
            'parent_id'=> $request->parent_id ?? null,
            'token'    => $kodeUnik, // Simpan angka 6 digit tersebut
        ]);

        return redirect('/admin/students')->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        
        $classes = SchoolClass::orderBy('name', 'asc')->get();
        $parents = User::where('role', 'wali_murid')->orderBy('name', 'asc')->get();

        return view('admin.siswa.edit', compact('student', 'classes', 'parents'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|numeric|unique:students,nis,' . $id, 
            'gender' => 'required|in:Laki - laki,Perempuan', 
            'class_id' => 'required|exists:classes,id',
            'parent_id' => 'nullable|exists:users,id',
        ]);

        $student->update($request->all());

        return redirect('/admin/students')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect('/admin/students')->with('success', 'Data siswa berhasil dihapus!');
    }

    public function printTokens(Request $request)
    {
        // Ambil data siswa yang sudah memiliki token
        $query = Student::whereNotNull('token')->with('schoolClass');

        // Jika Admin sedang memfilter kelas tertentu, cetak kelas itu saja
        if ($request->class_id) {
            $query->where('class_id', $request->class_id);
        }

        // Urutkan berdasarkan kelas, lalu nama siswa agar mudah dibagikan
        $students = $query->orderBy('class_id')->orderBy('name')->get();

        if ($students->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data siswa / token untuk dicetak.');
        }

        // Generate PDF
        $pdf = Pdf::loadView('admin.siswa.pdf_token', compact('students'))
                  ->setPaper('a4', 'portrait');

        // Gunakan stream() agar PDF terbuka di tab baru, bukan langsung ter-download
        return $pdf->stream('Kartu_Token_Akses.pdf');
    }
}