<?php
$logFile = 'storage/logs/laravel.log';
if (!file_exists($logFile)) {
    echo "Log file not found.";
    exit;
}

$lines = file($logFile);
$errors = array_filter($lines, function($line) {
    return strpos($line, 'local.ERROR') !== false;
});
$lastErrors = array_slice($errors, -5);

foreach ($lastErrors as $error) {
    echo $error;
}
