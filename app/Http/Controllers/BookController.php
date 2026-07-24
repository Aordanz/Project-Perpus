<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Location;
use App\Models\University;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Apply advanced search logic to the query.
     * Supports: Exact Match, Semantic Search (Synonyms), Full-Text Search, Fuzzy Search
     */
    /**
     * Apply advanced search logic to the query.
     * Supports: Exact Match, Semantic Search (Synonyms), Full-Text Search, Fuzzy Search
     */
    private function applyAdvancedSearch($query, $q, $columns = ['judul_buku', 'pengarang', 'subjek', 'isbn', 'noklasifikasi'])
    {
        // Bersihkan tanda kutip dari query untuk pencarian yang mengabaikan tanda baca
        $qClean = str_replace(["'", '"', '`'], '', $q);
        
        // Normalisasi Typo / Leetspeak (misal: 1 -> i, 0 -> o, 4 -> a, 3 -> e, 5 -> s, 7 -> t, 8 -> b, @ -> a)
        $typoMap = ['1' => 'i', '0' => 'o', '4' => 'a', '3' => 'e', '5' => 's', '7' => 't', '8' => 'b', '@' => 'a'];
        $qNormalized = strtr(strtolower($qClean), $typoMap);

        // 1. EXACT MATCH (if query is wrapped in quotes)
        if (preg_match('/^"(.*)"$/', $q, $matches)) {
            $exactTerm = $matches[1];
            $query->where(function($w) use ($columns, $exactTerm) {
                foreach ($columns as $column) {
                    $w->orWhere($column, '=', $exactTerm);
                }
            });
            return;
        }

        // 2. SEMANTIC SEARCH & TYPO CORRECTION (Levenshtein & Synonyms)
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

        // Dictionary for Levenshtein typo correction
        $dictionary = [
            'ekonomi', 'manajemen', 'akuntansi', 'komputer', 'teknologi', 'informatika', 
            'sistem', 'informasi', 'hukum', 'pidana', 'perdata', 'agama', 'islam', 
            'kedokteran', 'kesehatan', 'keperawatan', 'sejarah', 'sastra', 'bahasa', 
            'indonesia', 'pendidikan', 'psikologi', 'filsafat', 'metode', 'penelitian', 
            'analisis', 'pengantar', 'teori', 'aplikasi', 'pemrograman', 'algoritma', 
            'database', 'jaringan', 'biologi', 'kimia', 'fisika', 'matematika', 'teknik', 
            'mesin', 'elektro', 'arsitektur', 'politik', 'sosial', 'komunikasi', 
            'administrasi', 'bisnis', 'pemasaran', 'organisasi', 'keuangan', 'investasi', 
            'perbankan', 'pajak', 'audit', 'kategori', 'koleksi', 'logika', 'laporan'
        ];

        // Kita gabungkan input asli, yang dibersihkan, dan yang dinormalisasi
        $searchTerms = array_unique([$q, $qClean, $qNormalized]);
        $qLower = strtolower($qNormalized);
        
        // Auto-correct typos using Levenshtein distance
        $qWords = explode(' ', $qLower);
        foreach ($qWords as $w) {
            $wClean = trim($w);
            if (strlen($wClean) >= 4) {
                $maxDist = strlen($wClean) <= 5 ? 1 : 2;
                foreach ($dictionary as $dictWord) {
                    if (abs(strlen($dictWord) - strlen($wClean)) <= $maxDist) {
                        if (levenshtein($wClean, $dictWord) <= $maxDist) {
                            $searchTerms[] = $dictWord;
                        }
                    }
                }
            }
        }

        // Add related terms if keyword matches our dictionary
        foreach ($synonyms as $key => $relatedTerms) {
            if (str_contains($qLower, $key) || in_array($qLower, $relatedTerms)) {
                $searchTerms[] = $key;
                $searchTerms = array_merge($searchTerms, $relatedTerms);
            }
        }
        $searchTerms = array_unique($searchTerms);

        $query->where(function($w) use ($columns, $searchTerms, $qNormalized) {
            // 3. MULTI-WORD SEARCH (Memastikan SEMUA kata ada)
            if (str_contains($qNormalized, ' ')) {
                $words = explode(' ', preg_replace('/\s+/', ' ', trim($qNormalized)));
                $w->orWhere(function($queryMulti) use ($columns, $words) {
                    foreach ($words as $word) {
                        if (strlen($word) > 2) { // Abaikan kata hubung pendek
                            $queryMulti->where(function($queryWord) use ($columns, $word) {
                                foreach ($columns as $column) {
                                    // Menggunakan DB::raw untuk menghapus petik dari string database saat pencocokan
                                    $queryWord->orWhereRaw("REPLACE(REPLACE({$column}, '''', ''), '\"', '') LIKE ?", ["%{$word}%"]);
                                }
                            });
                        }
                    }
                });
            }

            foreach ($searchTerms as $term) {
                // PARTIAL MATCH (Normal LIKE)
                foreach ($columns as $column) {
                    $w->orWhereRaw("REPLACE(REPLACE({$column}, '''', ''), '\"', '') LIKE ?", ["%{$term}%"]);
                }
            }
            
            // 4. FUZZY MATCH (mengubah spasi menjadi wildcard '%')
            if (str_contains($qNormalized, ' ')) {
                $qCleanSpaces = preg_replace('/\s+/', ' ', trim($qNormalized));
                $fuzzyTerm = '%' . str_replace(' ', '%', $qCleanSpaces) . '%';
                foreach ($columns as $column) {
                    $w->orWhereRaw("REPLACE(REPLACE({$column}, '''', ''), '\"', '') LIKE ?", [$fuzzyTerm]);
                }
            }
        });

        // 5. RELEVANCE SORTING (Prioritaskan buku yang diawali kata kunci)
        $qTrimmed = trim($qNormalized);
        if (!empty($qTrimmed)) {
            $query->orderByRaw("
                CASE 
                    WHEN LOWER(REPLACE(REPLACE(judul_buku, '''', ''), '\"', '')) LIKE ? THEN 1
                    WHEN LOWER(REPLACE(REPLACE(judul_buku, '''', ''), '\"', '')) LIKE ? THEN 2
                    WHEN LOWER(REPLACE(REPLACE(pengarang, '''', ''), '\"', '')) LIKE ? THEN 3
                    ELSE 4
                END ASC
            ", ["{$qTrimmed}%", "% {$qTrimmed}%", "{$qTrimmed}%"]);
        }
    }

    /**
     * Display the landing page (welcome).
     */
    public function index()
    {
        // Get the main university (usu) - disabled because legacy DB doesn't use this table
        $university = null;

        // Location IDs that are NOT shown in the old OPAC (digilib.usu.ac.id):
        // 2  = Layanan Referensi dan Literasi Informasi
        // 3  = Layanan Referensi
        // 4  = Layanan Deposit
        // 26 = Rumah Sakit Pendidikan USU
        // 27 = Fakultas Ilmu Komputer dan TI
        // 31 = The Gade Creative Lounge
        // 36 = Belum Ada Lokasi
        $excludedLocationIds = [2, 3, 4, 26, 27, 31, 36];

        // Get locations with count of distinct book titles (judul) instead of physical items
        $locationCounts = \Illuminate\Support\Facades\DB::table('tbleksemplar')
            ->join('tblbuku', 'tbleksemplar.idmaster', '=', 'tblbuku.idmaster')
            ->where('tblbuku.status_tampil', 1)
            ->select('tbleksemplar.kodelokasi', \Illuminate\Support\Facades\DB::raw('count(distinct tbleksemplar.idmaster) as total_judul'))
            ->groupBy('tbleksemplar.kodelokasi')
            ->pluck('total_judul', 'kodelokasi');

        $locations = Location::all()->map(function ($location) use ($locationCounts) {
            $location->items_count = $locationCounts[$location->idlokasi] ?? 0;
            return $location;
        })->filter(function ($location) use ($excludedLocationIds) {
            return !in_array($location->idlokasi, $excludedLocationIds) && $location->items_count > 0;
        })->sortByDesc('items_count')->values();

        // Get 20 latest books with items.location eager loaded
        $latestBooks = Book::with(['items.location', 'publisherRelation', 'collectionTypeRelation'])->latest()->take(20)->get();

        // Get Active Information Center data
        $activeInfos = \App\Models\InformationCenter::where('status', 'published')
            ->where('publish_start_at', '<=', now())
            ->where(function ($q) {
                $q->whereNull('publish_end_at')
                  ->orWhere('publish_end_at', '>=', now());
            })
            ->orderBy('popup_priority', 'asc')
            ->orderBy('publish_start_at', 'desc')
            ->get();

        return view('welcome', compact('university', 'locations', 'latestBooks', 'activeInfos'));
    }

    /**
     * Display books starting with a specific initial.
     */
    public function indexJudulShow(Request $request, $initial)
    {
        $perPage = $request->input('per_page', 5);
        $query = Book::with(['items.location', 'publisherRelation', 'collectionTypeRelation'])
            ->where('judul_buku', 'like', $initial . '%')
            ->orderBy('judul_buku', 'asc');

        if ($perPage === 'all' || $perPage == 0) {
            $books = $query->paginate(20)->withQueryString();
        } else {
            $books = $query->paginate((int) $perPage)->withQueryString();
        }

        return view('index-judul-show', compact('books', 'initial', 'perPage'));
    }

    /**
     * Display search results.
     */
    public function search(Request $request)
    {
        $query = Book::query();

        // 1. Simple search bar (Advanced Search)
        if ($request->filled('q')) {
            $this->applyAdvancedSearch($query, $request->q);
        }

        // 1.5 Starts with (Index Judul)
        if ($request->filled('starts_with')) {
            $query->where('judul_buku', 'like', $request->starts_with . '%');
        }

        // 2. Specific search modal parameters
        if ($request->filled('inJudul')) {
            $this->applyAdvancedSearch($query, $request->inJudul, ['judul_buku']);
        }
        if ($request->filled('inPengarang1')) {
            $this->applyAdvancedSearch($query, $request->inPengarang1, ['pengarang']);
        }
        if ($request->filled('inPenerbit')) {
            $query->whereHas('publisherRelation', function ($q) use ($request) {
                $q->where('penerbit', 'like', "%{$request->inPenerbit}%");
            });
        }
        if ($request->filled('inSubyek')) {
            $this->applyAdvancedSearch($query, $request->inSubyek, ['subjek']);
        }
        if ($request->filled('intahunterbit')) {
            $query->where('tahun', 'like', "%{$request->intahunterbit}%");
        }
        if ($request->filled('inisbn')) {
            $this->applyAdvancedSearch($query, $request->inisbn, ['isbn']);
        }
        if ($request->filled('inKlasifikasi')) {
            $this->applyAdvancedSearch($query, $request->inKlasifikasi, ['noklasifikasi']);
        }
        if ($request->filled('inJenis')) {
            $query->where('jenis', $request->inJenis);
        }

        // Barcode or Location filtering (relates to items)
        if ($request->filled('inbarcode') || $request->filled('inLokasi')) {
            $query->whereHas('items', function ($itemQuery) use ($request) {
                if ($request->filled('inbarcode')) {
                    $itemQuery->where('nomor_eksemplar', 'like', "%{$request->inbarcode}%");
                }
                if ($request->filled('inLokasi')) {
                    $itemQuery->whereHas('location', function ($locQuery) use ($request) {
                        $locQuery->where('lokasi', $request->inLokasi);
                    });
                }
            });
        }

        // Paginate results
        $perPage = (int) $request->input('per_page', 10);
        if ($perPage <= 0) $perPage = 10;
        
        $books = $query->with(['items.location', 'publisherRelation'])->paginate($perPage)->withQueryString();

        // If AJAX/JSON requested, return JSON API response
        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest' || $request->has('json')) {
            $transformedBooks = collect($books->items())->map(function ($book) {
                $locNames = $book->items->map(function($i) { 
                    return __($i->location->name ?? ''); 
                })->filter()->unique()->values()->all();

                return [
                    'id' => $book->id,
                    'title' => $book->title ?: __('Judul Tidak Tersedia'),
                    'author' => $book->author ?: '-',
                    'publisher' => $book->publisher ?: '-',
                    'publish_year' => $book->publish_year ?: '-',
                    'call_number' => $book->call_number ?: '-',
                    'category' => __($book->category ?: 'Umum'),
                    'jenis' => $book->jenis_label,
                    'jenis_badge_color' => $book->jenis_badge_color,
                    'cover_image' => $book->cover_image ? asset('covers/' . $book->cover_image) : null,
                    'locations' => !empty($locNames) ? implode(', ', $locNames) : __('Tidak ditentukan'),
                    'detail_url' => route('books.show', $book->id),
                ];
            });

            return response()->json([
                'data' => $transformedBooks,
                'total' => $books->total(),
                'per_page' => $books->perPage(),
                'current_page' => $books->currentPage(),
                'last_page' => $books->lastPage(),
            ]);
        }

        // Direct browser visits to /search redirect to homepage
        return redirect()->route('home');
    }

    /**
     * Display a specific book detail.
     */
    public function show($id)
    {
        $book = Book::with(['items.location', 'publisherRelation', 'collectionTypeRelation'])->where('idmaster', $id)->firstOrFail();
        
        return view('detail', compact('book'));
    }

    /**
     * Display the 20 latest books.
     */
    public function latest(Request $request)
    {
        $query = Book::with(['items.location', 'publisherRelation', 'collectionTypeRelation'])->latest();

        if ($request->filled('q')) {
            $this->applyAdvancedSearch($query, $request->q);
        }

        if ($request->filled('location')) {
            $locationCode = $request->location;
            $query->whereHas('items.location', function ($q) use ($locationCode) {
                $q->where('lokasi', $locationCode);
            });
        }

        $latestBooks = $query->take(50)->get();
        
        $locations = Location::all();
        
        return view('koleksi-terbaru', compact('latestBooks', 'locations'));
    }

    /**
     * Display the gallery page.
     */
    public function galeri(Request $request)
    {
        $query = Book::with(['items.location', 'publisherRelation', 'collectionTypeRelation']);
        
        if ($request->filled('q')) {
            $this->applyAdvancedSearch($query, $request->q);
        }

        // Filter berdasarkan DDC category key (digit pertama nopanggil) atau filter khusus "terlaris"
        if ($request->filled('category')) {
            $catKey = $request->category;

            if ($catKey === 'terlaris') {
                // Cache data ID buku paling sering dipinjam dari tbltransaksi_pinjam selama 24 jam (86400 detik)
                $terlarisBookIds = \Illuminate\Support\Facades\Cache::remember('buku_terlaris_ids', 86400, function () {
                    return \Illuminate\Support\Facades\DB::table('tbltransaksi_pinjam')
                        ->select('idmaster', \Illuminate\Support\Facades\DB::raw('COUNT(*) as total_pinjam'))
                        ->whereNotNull('idmaster')
                        ->where('idmaster', '!=', '')
                        ->groupBy('idmaster')
                        ->orderByDesc('total_pinjam')
                        ->limit(200)
                        ->pluck('idmaster')
                        ->toArray();
                });

                if (!empty($terlarisBookIds)) {
                    $query->whereIn('idmaster', $terlarisBookIds);
                    $validIds = array_filter($terlarisBookIds, function($v) {
                        return is_numeric($v) || is_string($v);
                    });
                    if (!empty($validIds)) {
                        $quotedIds = implode(',', array_map(function($id) {
                            return "'" . addslashes($id) . "'";
                        }, $validIds));
                        $query->orderByRaw("FIELD(idmaster, {$quotedIds})");
                    }
                }
            } else {
                $query->where('nopanggil', 'like', $catKey . '%')
                      ->orderBy('judul_buku', 'asc')
                      ->orderBy('idbuku', 'asc');
            }
        } else {
            $query->orderBy('judul_buku', 'asc')->orderBy('idbuku', 'asc');
        }

        $perPage = $request->input('per', 24);
        $books = $query->paginate($perPage)->withQueryString();

        // Kirim data kategori DDC ke view
        $ddcCategories = Book::getDdcCategories();

        if ($request->ajax()) {
            return view('partials.gallery_content', compact('books', 'perPage'));
        }

        return view('galeri', compact('books', 'perPage', 'ddcCategories'));
    }

}
