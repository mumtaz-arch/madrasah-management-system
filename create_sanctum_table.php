<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Creating personal_access_tokens table manually...\n";

if (!Schema::hasTable('personal_access_tokens')) {
    try {
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
        echo "Table created successfully.\n";
    } catch (\Exception $e) {
        echo "Failed to create table: " . $e->getMessage() . "\n";
    }
} else {
    echo "Table already exists.\n";
}

// Fake migration
$migration = '2026_02_14_000001_create_personal_access_tokens_table';
$exists = DB::table('migrations')->where('migration', $migration)->exists();
if (!$exists) {
    DB::table('migrations')->insert([
        'migration' => $migration,
        'batch' => DB::table('migrations')->max('batch') + 1
    ]);
    echo "Migration record inserted.\n";
} else {
    echo "Migration record already exists.\n";
}
