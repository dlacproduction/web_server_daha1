<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            
            // Relasi (Tetap sama seperti sebelumnya)
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->foreignId('class_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            
            // Data Waktu (DIPERBARUI untuk menyesuaikan sistem aSc Timetable)
            $table->string('hari', 10); // Contoh: Senin, Selasa, dst.
            $table->integer('jam_mulai'); // Contoh: 2 (mulai jam ke-2)
            $table->integer('jam_selesai'); // Contoh: 4 (selesai jam ke-4)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
