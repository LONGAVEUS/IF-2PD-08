<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->string('nidn')->primary();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('jurusan');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
