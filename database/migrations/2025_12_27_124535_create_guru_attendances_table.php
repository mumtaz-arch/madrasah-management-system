<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guru_attendances', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha'])->default('hadir');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->unique(['tanggal', 'guru_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guru_attendances');
    }
};
