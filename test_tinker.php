<?php $book = App\Models\Book::with("items")->find(10); echo "Total: " . $book->items->count() . "\nAvailable: " . $book->items->where("status", "Tersedia")->count() . "\n";
