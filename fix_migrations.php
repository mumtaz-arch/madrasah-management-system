<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$migration = '2026_02_13_054915_create_teacher_journals_table';

// Check if already in migrations table
$exists = DB::table('migrations')->where('migration', $migration)->exists();

if ($exists) {
    echo "Migration record already exists.\n";
} else {
    // Check if table exists to be sure
    if (Schema::hasTable('teacher_journals')) {
        echo "Table teacher_journals exists. Inserting migration record...\n";
        DB::table('migrations')->insert([
            'migration' => $migration,
            'batch' => DB::table('migrations')->max('batch') + 1
        ]);
        echo "Migration record inserted successfully.\n";
    } else {
        echo "Table teacher_journals does NOT exist. Cannot fake migration.\n";
    }
}
