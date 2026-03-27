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
        Schema::table('santris', function (Blueprint $table) {
            $table->string('rfid_uid')->nullable()->unique()->after('nis');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->time('waktu_masuk')->nullable()->after('tanggal');
            $table->time('waktu_pulang')->nullable()->after('waktu_masuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('santris', function (Blueprint $table) {
            $table->dropColumn('rfid_uid');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['waktu_masuk', 'waktu_pulang']);
        });
    }
};
