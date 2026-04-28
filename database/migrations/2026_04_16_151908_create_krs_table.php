<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('krs', function (Blueprint $table) {
        $table->id('id_krs');
        $table->string('mahasiswa_nim');
        $table->string('mk_kode');
        $table->integer('semester');
        $table->foreign('mahasiswa_nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
        $table->foreign('mk_kode')->references('kode_mk')->on('mata_kuliah')->onDelete('cascade');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};
