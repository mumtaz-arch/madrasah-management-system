<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = ['santris', 'attendances', 'tagihans', 'users', 'exams', 'teacher_journals', 'personal_access_tokens'];
$driver = DB::connection()->getDriverName();
echo "Database Driver: $driver\n";

foreach ($tables as $table) {
    echo "Indexes for table: $table\n";
    if (!Schema::hasTable($table)) {
        echo "Table does not exist.\n";
        continue;
    }

    if ($driver === 'sqlite') {
        $indexes = DB::select("PRAGMA index_list($table)");
        foreach ($indexes as $index) {
            echo " - " . $index->name . " (unique: " . $index->unique . ")\n";
        }
    } elseif ($driver === 'mysql' || $driver === 'mariadb') {
        $indexes = DB::select("SHOW INDEX FROM $table");
        foreach ($indexes as $index) {
            echo " - " . $index->Key_name . " (" . $index->Column_name . ")\n";
        }
    } else {
        echo "Unsupported driver: $driver\n";
    }
    echo "\n";
}
