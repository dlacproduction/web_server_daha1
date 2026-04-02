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
        Schema::table('attendances', function (Blueprint $table) {
            // Menambahkan kolom class_id dan teacher_id tanpa menghapus tabel
            $table->unsignedBigInteger('class_id')->nullable()->after('student_id');
            $table->unsignedBigInteger('teacher_id')->nullable()->after('class_id');
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['class_id', 'teacher_id']);
        });
    }
};
