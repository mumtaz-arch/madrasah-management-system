<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

echo "Fixing database...\n";
try {
    Schema::table('tagihans', function (Blueprint $table) {
        if (!Schema::hasColumn('tagihans', 'metode_bayar')) { echo "Adding metode_bayar...\n"; $table->string('metode_bayar')->nullable()->after('status'); }
        if (!Schema::hasColumn('tagihans', 'bukti_bayar')) { echo "Adding bukti_bayar...\n"; $table->string('bukti_bayar')->nullable()->after('metode_bayar'); }
        if (!Schema::hasColumn('tagihans', 'tanggal_bayar')) { echo "Adding tanggal_bayar...\n"; $table->date('tanggal_bayar')->nullable()->after('bukti_bayar'); }
        if (!Schema::hasColumn('tagihans', 'nominal_bayar')) { echo "Adding nominal_bayar...\n"; $table->decimal('nominal_bayar', 15, 2)->nullable()->after('tanggal_bayar'); }
        if (!Schema::hasColumn('tagihans', 'verified_by')) { echo "Adding verified_by...\n"; $table->unsignedBigInteger('verified_by')->nullable()->after('nominal_bayar'); }
        if (!Schema::hasColumn('tagihans', 'verified_at')) { echo "Adding verified_at...\n"; $table->timestamp('verified_at')->nullable()->after('verified_by'); }
        if (!Schema::hasColumn('tagihans', 'catatan_pembayaran')) { echo "Adding catatan_pembayaran...\n"; $table->text('catatan_pembayaran')->nullable()->after('verified_at'); }
    });
    echo "Done.\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
