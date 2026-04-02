<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function jadwalGuru(Request $request)
    {
        // 1. Ambil data user yang sedang login dari token
        $user = $request->user();

        // 2. Pastikan yang mengakses adalah guru
        if ($user->role !== 'guru') {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Anda bukan guru.'
            ], 403);
        }

        // 3. Tarik data jadwal khusus untuk guru ini, sertakan nama kelas dan mapelnya
        $schedules = Schedule::with(['schoolClass', 'subject'])
            ->where('teacher_id', $user->id)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data jadwal mengajar berhasil diambil',
            'data' => $schedules
        ]);
    }
}