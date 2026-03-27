<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL, alter enum safely via DB statement
        DB::statement("ALTER TABLE attendances MODIFY COLUMN status ENUM('hadir', 'terlambat', 'izin', 'sakit', 'alpha') DEFAULT 'hadir'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE attendances MODIFY COLUMN status ENUM('hadir', 'izin', 'sakit', 'alpha') DEFAULT 'hadir'");
    }
};
