<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id('id_nilai');
            $table->unsignedBigInteger('krs_id');
            $table->enum('nilai_huruf', ['A', 'B+', 'B', 'C+', 'C', 'D', 'E'])->nullable();
            $table->float('bobot')->nullable();
            $table->foreign('krs_id')->references('id_krs')->on('krs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
