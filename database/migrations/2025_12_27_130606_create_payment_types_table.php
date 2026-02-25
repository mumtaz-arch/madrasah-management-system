<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_types', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // SPP, Uang Gedung, Seragam, etc.
            $table->decimal('nominal', 12, 2)->default(0);
            $table->integer('jatuh_tempo_hari')->default(10); // Day of month
            $table->boolean('is_monthly')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_types');
    }
};
