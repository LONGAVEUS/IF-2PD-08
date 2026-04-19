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
        Schema::create('detail_krs', function (Blueprint $table) {
            $table->id('id_detail_krs');
            $table->foreignId('krs_id')->constrained('krs', 'id_krs')->onDelete('cascade');
            $table->string('mk_kode');
            $table->foreign('mk_kode')->references('kode_mk')->on('mata_kuliah')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_krs');
    }
};
