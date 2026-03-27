<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Announcement;
use Illuminate\Support\Str;

$announcements = Announcement::whereNull('slug')->get();
foreach ($announcements as $a) {
    $a->update(['slug' => Str::slug($a->title) . '-' . $a->id]);
}
echo "Slugs updated successfully.\n";
