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
        Schema::create('teacher_journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('gurus')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('mapels')->onDelete('cascade');
            
            $table->date('date');
            $table->string('topic'); // Materi
            $table->string('method'); // Metode Pembelajaran
            
            $table->integer('present_count')->default(0);
            $table->integer('absent_count')->default(0);
            
            $table->text('notes')->nullable();
            
            // Status: draft, sent, verified
            $table->string('status')->default('draft')->index();
            
            // Verification
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_journals');
    }
};
