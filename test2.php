<?php
require __DIR__ . "/vendor/autoload.php"; 
$app = require_once __DIR__ . "/bootstrap/app.php"; 
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class); 
$kernel->bootstrap(); 

$q = "prinsip prinsip biokimia";

$query = App\Models\Book::query();

$columns = ['title', 'author', 'publisher', 'subject', 'isbn', 'classification'];

$searchTerms = [$q];
$qLower = strtolower($q);

$synonyms = [
    'komputer' => ['it', 'teknologi', 'sistem informasi', 'laptop', 'informatika', 'software', 'hardware', 'jaringan'],
    'skripsi' => ['tugas akhir', 'tesis', 'disertasi', 'penelitian', 'jurnal', 'karya ilmiah'],
    'hukum' => ['undang-undang', 'pidana', 'perdata', 'kriminal', 'konstitusi', 'pengadilan', 'ham'],
    'agama' => ['islam', 'kristen', 'katolik', 'hindu', 'buddha', 'kepercayaan', 'teologi', 'akhlak'],
    'kedokteran' => ['medis', 'kesehatan', 'keperawatan', 'farmasi', 'obat', 'penyakit', 'klinik'],
    'sejarah' => ['historis', 'masa lalu', 'purbakala', 'zaman', 'kemerdekaan', 'kerajaan'],
    'ekonomi' => ['bisnis', 'keuangan', 'akuntansi', 'manajemen', 'pasar', 'uang', 'perdagangan'],
    'sastra' => ['bahasa', 'puisi', 'novel', 'linguistik', 'cerpen', 'drama'],
];

foreach ($synonyms as $key => $relatedTerms) {
    if (str_contains($qLower, $key) || in_array($qLower, $relatedTerms)) {
        $searchTerms[] = $key;
        $searchTerms = array_merge($searchTerms, $relatedTerms);
    }
}
$searchTerms = array_unique($searchTerms);

$query->where(function($w) use ($columns, $searchTerms, $q) {
    $w->orWhereFullText(['title', 'author', 'publisher', 'subject'], $q, ['mode' => 'boolean']);

    foreach ($searchTerms as $term) {
        foreach ($columns as $column) {
            $w->orWhere($column, 'like', "%{$term}%");
        }
    }
    
    if (str_contains($q, ' ')) {
        $fuzzyTerm = '%' . str_replace(' ', '%', $q) . '%';
        foreach ($columns as $column) {
            $w->orWhere($column, 'like', $fuzzyTerm);
        }
    }
});

$books = $query->get();
echo "Found books: " . $books->count() . "\n";
foreach($books as $b) { echo "- " . $b->title . "\n"; }
