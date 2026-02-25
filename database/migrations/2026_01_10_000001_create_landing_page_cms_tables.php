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
        // 1. Landing Page Contents (Generic Key-Value Store)
        Schema::create('landing_page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('section')->index(); // hero, about, footer, etc.
            $table->string('key')->unique(); // hero_title, about_image
            $table->longText('value')->nullable();
            $table->string('type')->default('text'); // text, image, richtext
            $table->timestamps();
        });

        // 2. Programs (For 'Program Unggulan' Cards)
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // Class name or image path
            $table->string('image')->nullable();
            $table->boolean('is_featured')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 3. Update Gurus (Add is_featured for Landing Page visibility)
        Schema::table('gurus', function (Blueprint $table) {
            if (!Schema::hasColumn('gurus', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('foto');
            }
            if (!Schema::hasColumn('gurus', 'bio')) {
                $table->text('bio')->nullable()->after('foto');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_page_contents');
        Schema::dropIfExists('programs');
        
        Schema::table('gurus', function (Blueprint $table) {
            if (Schema::hasColumn('gurus', 'is_featured')) {
                $table->dropColumn('is_featured');
            }
            if (Schema::hasColumn('gurus', 'bio')) {
                $table->dropColumn('bio');
            }
        });
    }
};
