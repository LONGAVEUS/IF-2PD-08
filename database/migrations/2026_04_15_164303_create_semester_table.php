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
       Schema::create('semester', function (Blueprint $table) {
            $table->id('id_semester');
            $table->string('tahun_ajaran');
            $table->enum('tipe_semester', ['ganjil', 'genap']); 
            $table->date('batas_pengisian')->nullable();
            $table->date('batas_tgl_nilai')->nullable();
            $table->enum('status_krs', ['buka', 'tutup'])->default('tutup');
            $table->enum('status_khs', ['proses', 'rilis'])->default('proses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semester');
    }
};
