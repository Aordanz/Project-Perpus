<?php require 'vendor/autoload.php'; require 'bootstrap/app.php'; $app = app(); $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); echo App\Models\Book::count();
