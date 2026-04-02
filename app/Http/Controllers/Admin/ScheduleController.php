<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // WAJIB ada untuk fitur validasi jadwal bentrok
use App\Models\Subject;
use App\Models\User;
use App\Models\Schedule;
use App\Models\SchoolClass;
use Barryvdh\DomPDF\Facade\Pdf;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua data kelas untuk dropdown pilihan
        $classes = SchoolClass::orderBy('name', 'asc')->get();
        
        // 2. Tangkap ID Kelas yang sedang dipilih user (jika ada)
        $selectedClass = $request->class_id;
        
        $schedules = [];

        // 3. Jika user sudah memilih kelas, tarik jadwal khusus untuk kelas tersebut
        if ($selectedClass) {
            $schedules = Schedule::with(['subject', 'teacher'])
                ->where('class_id', $selectedClass)
                // Urutkan berdasarkan hari standar sekolah Indonesia
                ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
                ->orderBy('jam_mulai', 'asc')
                ->get()
                // Kelompokkan data berdasarkan hari agar mudah di-looping di tabel HTML
                ->groupBy('hari');
        }

        return view('admin.jadwal.index', compact('classes', 'selectedClass', 'schedules'));
    }

    public function create(Request $request)
    {
        // Tangkap ID kelas dari URL (?class_id=...)
        $class_id = $request->query('class_id');
        
        // Jika tidak ada class_id di URL, kembalikan ke halaman jadwal
        if (!$class_id) {
            return redirect('/admin/jadwal')->with('error', 'Pilih kelas terlebih dahulu!');
        }

        $kelas = SchoolClass::findOrFail($class_id);
        $subjects = Subject::orderBy('name', 'asc')->get();
        $teachers = User::where('role', 'guru')->orderBy('name', 'asc')->get();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        return view('admin.jadwal.create', compact('kelas', 'subjects', 'teachers', 'days'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|integer|min:1|max:10',
            'jam_selesai' => 'required|integer|min:1|max:10|gte:jam_mulai',
        ], [
            'jam_selesai.gte' => 'Jam selesai tidak boleh lebih kecil dari jam mulai.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->errors()->first());
        }

        $bentrokKelas = Schedule::with('subject')
            ->where('class_id', $request->class_id)
            ->where('hari', $request->hari)
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<=', $request->jam_selesai)
                      ->where('jam_selesai', '>=', $request->jam_mulai);
            })->first(); // Pakai first() agar kita bisa mengambil nama mapel yang bentrok

        if ($bentrokKelas) {
            return redirect()->back()->withInput()->with('error', 'Gagal! Kelas ini sudah ada jadwal mapel ' . $bentrokKelas->subject->name . ' pada rentang jam tersebut.');
        }

        $bentrokGuru = Schedule::with(['schoolClass', 'teacher'])
            ->where('teacher_id', $request->teacher_id)
            ->where('hari', $request->hari)
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<=', $request->jam_selesai)
                      ->where('jam_selesai', '>=', $request->jam_mulai);
            })->first();

        if ($bentrokGuru) {
            return redirect()->back()->withInput()->with('error', 'Gagal! Guru ' . $bentrokGuru->teacher->name . ' sudah memiliki jadwal mengajar di Kelas ' . $bentrokGuru->schoolClass->name . ' pada rentang jam tersebut.');
        }

        // Simpan ke database
        Schedule::create([
            'academic_year_id' => 1, // Default sementara (tahun ajaran aktif)
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect('/admin/jadwal?class_id=' . $request->class_id)
            ->with('success', 'Jadwal pelajaran berhasil ditambahkan!');
    }

    public function downloadPdf(Request $request)
    {
        $class_id = $request->query('class_id');
        if (!$class_id) {
            return redirect('/admin/jadwal')->with('error', 'Pilih kelas terlebih dahulu!');
        }

        $kelas = SchoolClass::findOrFail($class_id);
        
        $schedules = Schedule::with(['subject', 'teacher'])
            ->where('class_id', $class_id)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy('jam_mulai', 'asc')
            ->get()
            ->groupBy('hari');

        // Render tampilan blade khusus menjadi PDF berbentuk Lanskap (Memanjang)
        $pdf = Pdf::loadView('admin.jadwal.pdf', compact('kelas', 'schedules'))
                  ->setPaper('a4', 'landscape');

        // Mengunduh file dengan nama otomatis
        return $pdf->download('Jadwal_Pelajaran_Kelas_' . $kelas->name . '.pdf');
    }

    public function edit($id)
    {
        $jadwal = Schedule::findOrFail($id);
        $kelas = SchoolClass::findOrFail($jadwal->class_id);
        $subjects = Subject::orderBy('name', 'asc')->get();
        $teachers = User::where('role', 'guru')->orderBy('name', 'asc')->get();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('admin.jadwal.edit', compact('jadwal', 'kelas', 'subjects', 'teachers', 'days'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = Schedule::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|integer|min:1|max:10',
            'jam_selesai' => 'required|integer|min:1|max:10|gte:jam_mulai',
        ], [
            'jam_selesai.gte' => 'Jam selesai tidak boleh lebih kecil dari jam mulai.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->errors()->first());
        }

        $bentrokKelas = Schedule::with('subject')
            ->where('class_id', $jadwal->class_id)
            ->where('hari', $request->hari)
            ->where('id', '!=', $id) // Abaikan jadwal ini sendiri
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<=', $request->jam_selesai)
                      ->where('jam_selesai', '>=', $request->jam_mulai);
            })->first();

        if ($bentrokKelas) {
            return redirect()->back()->withInput()->with('error', 'Gagal! Kelas ini sudah ada jadwal mapel ' . $bentrokKelas->subject->name . ' pada rentang jam tersebut.');
        }

        $bentrokGuru = Schedule::with(['schoolClass', 'teacher'])
            ->where('teacher_id', $request->teacher_id)
            ->where('hari', $request->hari)
            ->where('id', '!=', $id) // Abaikan jadwal ini sendiri
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<=', $request->jam_selesai)
                      ->where('jam_selesai', '>=', $request->jam_mulai);
            })->first();

        if ($bentrokGuru) {
            return redirect()->back()->withInput()->with('error', 'Gagal! Guru ' . $bentrokGuru->teacher->name . ' sudah memiliki jadwal mengajar di Kelas ' . $bentrokGuru->schoolClass->name . ' pada rentang jam tersebut.');
        }

        $jadwal->update([
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect('/admin/jadwal?class_id=' . $jadwal->class_id)
            ->with('success', 'Jadwal pelajaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jadwal = Schedule::findOrFail($id);
        $class_id = $jadwal->class_id;
        $jadwal->delete();

        return redirect('/admin/jadwal?class_id=' . $class_id)
            ->with('success', 'Jadwal pelajaran berhasil dihapus!');
    }
}