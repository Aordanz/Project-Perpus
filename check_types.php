<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Top idjenis_koleksi counts in tblbuku ===" . PHP_EOL;
$counts = DB::select("
    SELECT b.idjenis_koleksi, k.jenis_koleksi, COUNT(*) as cnt 
    FROM tblbuku b 
    LEFT JOIN tbljenis_koleksi k ON b.idjenis_koleksi = k.idjns_koleksi 
    GROUP BY b.idjenis_koleksi, k.jenis_koleksi 
    ORDER BY cnt DESC 
    LIMIT 20
");
foreach ($counts as $r) {
    echo "idjenis_koleksi: {$r->idjenis_koleksi} | name: '{$r->jenis_koleksi}' | count: {$r->cnt}" . PHP_EOL;
}
