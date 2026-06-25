<?php
require __DIR__ . "/vendor/autoload.php"; 
$app = require_once __DIR__ . "/bootstrap/app.php"; 
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class); 
$kernel->bootstrap(); 
DB::enableQueryLog(); 
$books = App\Models\Book::where(function($w) {
    $q = 'prinsip prinsip biokimia';
    $w->orWhereFullText(['title', 'author', 'publisher', 'subject'], $q, ['mode' => 'boolean']);
    $fuzzyTerm = '%' . str_replace(' ', '%', $q) . '%';
    $w->orWhere('title', 'like', $fuzzyTerm);
})->get(); 
echo json_encode(DB::getQueryLog());
echo "\n";
echo "Found: " . count($books);
