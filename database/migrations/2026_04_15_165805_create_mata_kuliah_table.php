<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('mata_kuliah', function (Blueprint $table) {
            $table->string('kode_mk')->primary();
            $table->string('nama_mk');
            $table->integer('sks');
            $table->integer('semester');
            $table->string('dosen_nidn');
            $table->foreign('dosen_nidn')->references('nidn')->on('dosen')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_kuliah');
    }
};
