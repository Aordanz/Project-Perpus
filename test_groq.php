<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;

$path = 'private/data_perpus.txt';
echo "Exists: " . (Storage::disk('local')->exists($path) ? 'Yes' : 'No') . "\n";
echo "Path: " . Storage::disk('local')->path($path) . "\n";
