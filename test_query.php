<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::enableQueryLog();

$start = microtime(true);
$locationsList = \Illuminate\Support\Facades\DB::table('tbllokasi')
    ->leftJoin('tbleksemplar', 'tbllokasi.idlokasi', '=', 'tbleksemplar.kodelokasi')
    ->leftJoin('tblbuku', 'tbleksemplar.idmaster', '=', 'tblbuku.idmaster')
    ->select('tbllokasi.lokasi', \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT tblbuku.idbuku) as book_count'))
    ->groupBy('tbllokasi.idlokasi', 'tbllokasi.lokasi')
    ->orderByRaw("CASE WHEN tbllokasi.lokasi = 'Belum Ada Lokasi' THEN 1 ELSE 2 END")
    ->orderByDesc('book_count')
    ->orderBy('tbllokasi.lokasi')
    ->pluck('tbllokasi.lokasi');

echo "Query 1 took: " . (microtime(true) - $start) . " seconds\n";
