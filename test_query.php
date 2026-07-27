<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Book;

// Test query with type=buku
$query = Book::with(['items.location', 'publisherRelation', 'collectionTypeRelation']);

$typeQuery = 'buku';
$query->whereHas('collectionTypeRelation', function ($ct) use ($typeQuery) {
    $ct->whereRaw('LOWER(jenis_koleksi) = ?', [$typeQuery]);
});

$books = $query->paginate(24);

echo "Total results for type=buku: " . $books->total() . PHP_EOL;

$nonBukuCount = 0;
foreach ($books as $b) {
    $jName = $b->jenis_name;
    if (strtolower($jName) !== 'buku') {
        echo "NON-BUKU FOUND! ID: {$b->idbuku} | jenis_name: {$jName} | idjenis_koleksi: {$b->idjenis_koleksi}" . PHP_EOL;
        $nonBukuCount++;
    }
}

if ($nonBukuCount === 0) {
    echo "SUCCESS! All 24 books on page 1 are 'Buku'." . PHP_EOL;
}
