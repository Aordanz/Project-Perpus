<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$record = Illuminate\Support\Facades\DB::table('tbleksemplar')
    ->select('idmaster')
    ->groupBy('idmaster')
    ->havingRaw('count(*) = 2')
    ->inRandomOrder()
    ->first();

if ($record) {
    $book = App\Models\Book::find($record->idmaster);
    echo "Judul Buku: " . $book->judul_buku . "\n";
} else {
    echo "Tidak ada buku dengan 2 eksemplar.\n";
}
