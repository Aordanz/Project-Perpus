<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$q = "Cases in corporate financial reporting";
$query = App\Models\Book::query();

$controller = new App\Http\Controllers\BookController();
$reflection = new ReflectionClass($controller);
$method = $reflection->getMethod('applyAdvancedSearch');
$method->setAccessible(true);
$method->invoke($controller, $query, $q);

echo "Query SQL:\n" . $query->toSql() . "\n";
echo "Result count: " . $query->count() . "\n";
