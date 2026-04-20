<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            // Tetap gunakan string(6) agar angka 0 di depan tidak hilang
            $table->string('token', 6)->nullable()->unique();
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            // Jangan lupa isi method down untuk menghapus kolom jika di-rollback
            $table->dropColumn('token');
        });
    }
};