<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Location;
use App\Models\University;
use App\Models\Message;
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
        
        // Normalisasi Typo / Leetspeak (misal: 1 -> i, 0 -> o, 4 -> a)
        $typoMap = ['1' => 'i', '0' => 'o', '4' => 'a', '3' => 'e', '5' => 's', '8' => 'b'];
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

        // 2. SEMANTIC SEARCH (Synonyms Mapping)
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

        // Kita gabungkan input asli, yang dibersihkan, dan yang dinormalisasi
        $searchTerms = array_unique([$q, $qClean, $qNormalized]);
        $qLower = strtolower($qNormalized);
        
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
        });

        // Get 20 latest books with items.location eager loaded
        $latestBooks = Book::with('items.location')->latest()->take(20)->get();

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
        $query = Book::with(['items.location'])
            ->where('judul_buku', 'like', $initial . '%')
            ->orderBy('judul_buku', 'asc');

        if ($perPage === 'all' || $perPage == 0) {
            // Membatasi maksimal 500 data agar tidak kehabisan memori server
            $books = $query->paginate(500)->withQueryString();
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

        // Paginate results (supports dynamic per_page or custom limit)
        $perPage = request()->input('per_page', 10);
        if ($perPage === 'all') {
            // Membatasi maksimal 500 data agar tidak kehabisan memori RAM server
            $books = $query->with(['items.location'])->paginate(500)->withQueryString();
        } else {
            $books = $query->with(['items.location'])->paginate((int)$perPage)->withQueryString();
        }

        // Get locations for the advanced search form in results page
        $locations = Location::all();

        return view('search', compact('books', 'locations'));
    }

    /**
     * Display a specific book detail.
     */
    public function show($id)
    {
        $book = Book::with(['items.location'])->where('idmaster', $id)->firstOrFail();
        
        return view('detail', compact('book'));
    }

    /**
     * Display the 20 latest books.
     */
    public function latest(Request $request)
    {
        $query = Book::with(['items.location'])->latest();

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
        // Urutkan berdasarkan abjad (judul_buku) lalu berdasarkan ID (penomoran)
        $query = Book::with(['items.location'])->orderBy('judul_buku', 'asc')->orderBy('idbuku', 'asc');
        
        if ($request->filled('q')) {
            $this->applyAdvancedSearch($query, $request->q);
        }

        // Filter berdasarkan DDC category key (digit pertama nopanggil)
        if ($request->filled('category')) {
            $catKey = $request->category;
            $query->where('nopanggil', 'like', $catKey . '%');
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

    /**
     * Store a new contact message.
     */
    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachments' => 'nullable|array|max:3',
            'attachments.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'subject', 'message']);
        
        $attachmentsPath = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . uniqid() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $file->move(public_path('contacts'), $filename);
                $attachmentsPath[] = $filename;
            }
        }
        $data['attachments'] = $attachmentsPath;

        Message::create($data);

        return back()->with('success', 'Pesan Anda telah berhasil dikirim! Tim kami akan merespons secepat mungkin.');
    }
}
