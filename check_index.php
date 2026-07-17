<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$sql = "EXPLAIN SELECT tbllokasi.lokasi, COUNT(DISTINCT tbleksemplar.idmaster) as book_count
        FROM tbllokasi
        LEFT JOIN tbleksemplar ON tbllokasi.idlokasi = tbleksemplar.kodelokasi
        GROUP BY tbllokasi.idlokasi, tbllokasi.lokasi";
        
$result = DB::select($sql);
print_r($result);
