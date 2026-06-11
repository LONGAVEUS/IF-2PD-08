<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE nilai MODIFY COLUMN nilai_huruf ENUM('A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'E') NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE nilai MODIFY COLUMN nilai_huruf ENUM('A', 'B+', 'B', 'C+', 'C', 'D', 'E') NULL");
    }
};