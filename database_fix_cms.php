<?php
// c:\laragon\www\sekolah-system\database_fix_cms.php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Starting Database Fix for CMS...\n";

// 1. Landing Page Contents
if (!Schema::hasTable('landing_page_contents')) {
    echo "Creating landing_page_contents table...\n";
    Schema::create('landing_page_contents', function (Blueprint $table) {
        $table->id();
        $table->string('section')->index();
        $table->string('key')->unique();
        $table->longText('value')->nullable();
        $table->string('type')->default('text');
        $table->timestamps();
    });
} else {
    echo "landing_page_contents table already exists.\n";
}

// 2. Programs
if (!Schema::hasTable('programs')) {
    echo "Creating programs table...\n";
    Schema::create('programs', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        $table->string('icon')->nullable();
        $table->string('image')->nullable();
        $table->boolean('is_featured')->default(true);
        $table->integer('sort_order')->default(0);
        $table->timestamps();
    });
} else {
    echo "programs table already exists.\n";
}

// 3. Update Gurus
if (Schema::hasTable('gurus')) {
    Schema::table('gurus', function (Blueprint $table) {
        if (!Schema::hasColumn('gurus', 'is_featured')) {
            echo "Adding is_featured to gurus...\n";
            $table->boolean('is_featured')->default(false)->after('foto');
        }
        if (!Schema::hasColumn('gurus', 'bio')) {
            echo "Adding bio to gurus...\n";
            $table->text('bio')->nullable()->after('foto');
        }
    });
}

echo "Database Fix Completed.\n";
