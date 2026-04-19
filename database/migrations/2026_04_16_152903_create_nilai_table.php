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
        Schema::create('nilai', function (Blueprint $table) {
            $table->id('id_nilai');
            $table->foreignId('detail_krs_id')->unique()->constrained('detail_krs', 'id_detail_krs')->onDelete('cascade');
            $table->enum('nilai_huruf', ['A', 'B+', 'B', 'C+', 'C', 'D', 'E'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
