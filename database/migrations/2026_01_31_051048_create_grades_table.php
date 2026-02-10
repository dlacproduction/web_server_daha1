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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects');
            // Tipe nilai
            $table->enum('type', ['UH1', 'UH2', 'UTS', 'UAS', 'Tugas']); 
            $table->double('score'); // Nilai (misal: 85.5)
            $table->text('description')->nullable(); // Deskripsi capaian kompetensi (penting untuk K13/Merdeka)
            $table->foreignId('academic_year_id')->constrained('academic_years');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
