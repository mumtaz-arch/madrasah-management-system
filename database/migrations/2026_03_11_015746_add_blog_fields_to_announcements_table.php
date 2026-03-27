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
        Schema::table('announcements', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->string('image')->nullable()->after('slug');
            $table->text('excerpt')->nullable()->after('image');
        });
        
        // Populate existing slugs since they are unique nullable, we might want to ensure they are set if needed.
        // For now, we will just assign slugs for existing announcements.
        // DB::table('announcements')->get()->each(function ($announcement) {
        //     DB::table('announcements')->where('id', $announcement->id)->update([
        //         'slug' => \Illuminate\Support\Str::slug($announcement->title) . '-' . $announcement->id
        //     ]);
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn(['slug', 'image', 'excerpt']);
        });
    }
};
