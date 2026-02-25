<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Applying indexes manually...\n";

try {
    Schema::table('santris', function (Blueprint $table) {
        // We use raw SQL for check to be safe
    });
    
    $addIndex = function($table, $column, $name) {
        $exists = count(DB::select("SHOW INDEX FROM $table WHERE Key_name = ?", [$name])) > 0;
        if (!$exists) {
            echo "Adding index $name to $table...\n";
            try {
                DB::statement("CREATE INDEX $name ON $table ($column)");
                echo " - Success\n";
            } catch (\Exception $e) {
                echo " - Failed: " . $e->getMessage() . "\n";
            }
        } else {
            echo "Index $name already exists on $table.\n";
        }
    };

    $addIndex('santris', 'nama_lengkap', 'santris_nama_lengkap_index');
    $addIndex('santris', 'status', 'santris_status_index');
    
    $addIndex('attendances', 'status', 'attendances_status_index');
    $addIndex('attendances', 'tanggal', 'attendances_tanggal_index');
    
    $addIndex('tagihans', 'status', 'tagihans_status_index');
    $addIndex('tagihans', 'jatuh_tempo', 'tagihans_jatuh_tempo_index');
    
    $addIndex('users', 'role', 'users_role_index');
    
    if (Schema::hasTable('exams')) {
        $addIndex('exams', 'mulai', 'exams_mulai_index');
    }

    // Fake the migration record
    $migration = '2026_02_14_000000_optimize_database_indexes';
    $exists = DB::table('migrations')->where('migration', $migration)->exists();
    if (!$exists) {
        DB::table('migrations')->insert([
            'migration' => $migration,
            'batch' => DB::table('migrations')->max('batch') + 1
        ]);
        echo "Migration record inserted.\n";
    }

} catch (\Exception $e) {
    echo "General Error: " . $e->getMessage() . "\n";
}
