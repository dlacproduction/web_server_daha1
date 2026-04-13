<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SiswaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $class_id;

    public function __construct($class_id = null)
    {
        $this->class_id = $class_id;
    }

    // Menggunakan collection() yang lebih stabil daripada query()
    public function collection()
    {
        if ($this->class_id) {
            // Ambil data siswa berdasarkan kelas yang difilter
            return Student::with('schoolClass')->where('class_id', $this->class_id)->get();
        }
        
        // Jika tidak ada filter, ambil semua siswa
        return Student::with('schoolClass')->orderBy('class_id', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'Nama Siswa',
            'Kelas',
        ];
    }

    public function map($student): array
    {
        static $no = 0;
        $no++;
        
        return [
            $no,
            $student->nis ?? '-',
            $student->name,
            $student->schoolClass->name ?? 'Belum ada',
        ];
    }
}