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
    private function applyAdvancedSearch($query, $q, $columns = ['title', 'author', 'publisher', 'subject', 'isbn', 'classification'])
    {
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

        $searchTerms = [$q];
        $qLower = strtolower($q);
        
        // Add related terms if keyword matches our dictionary
        foreach ($synonyms as $key => $relatedTerms) {
            if (str_contains($qLower, $key) || in_array($qLower, $relatedTerms)) {
                $searchTerms[] = $key;
                $searchTerms = array_merge($searchTerms, $relatedTerms);
            }
        }
        $searchTerms = array_unique($searchTerms);

        $query->where(function($w) use ($columns, $searchTerms, $q) {
            // 3. FULL TEXT SEARCH (FTS) for exact keyword/phrase relevance
            // Hanya aktifkan FTS jika mencari di seluruh kolom utama yang di-index (yaitu ke-4 kolom bersama-sama)
            $requiredFts = ['title', 'author', 'publisher', 'subject'];
            $hasAllFts = count(array_intersect($requiredFts, $columns)) === count($requiredFts);
            if ($hasAllFts) {
                $w->orWhereFullText($requiredFts, $q, ['mode' => 'boolean']);
            }

            foreach ($searchTerms as $term) {
                // PARTIAL MATCH (Normal LIKE)
                foreach ($columns as $column) {
                    $w->orWhere($column, 'like', "%{$term}%");
                }
            }
            
            // 4. FUZZY MATCH (mengubah spasi menjadi wildcard '%' contoh: 'Budi Santoso' -> '%Budi%Santoso%')
            // Berguna jika ada typo spasi atau pencarian beberapa kata yang tidak berurutan
            if (str_contains($q, ' ')) {
                // Pastikan setiap spasi (bahkan multiple spasi) diubah menjadi % tunggal
                $qClean = preg_replace('/\s+/', ' ', trim($q));
                $fuzzyTerm = '%' . str_replace(' ', '%', $qClean) . '%';
                foreach ($columns as $column) {
                    $w->orWhere($column, 'like', $fuzzyTerm);
                }
            }
        });
    }

    /**
     * Display the landing page (welcome).
     */
    public function index()
    {
        // Get the main university (USU)
        $university = University::where('code', 'usu')->first();

        // Get locations with count of items
        $locations = Location::withCount('items')->get();

        // Get 20 latest books with items.location eager loaded
        $latestBooks = Book::with('items.location')->latest()->take(20)->get();

        return view('welcome', compact('university', 'locations', 'latestBooks'));
    }

    /**
     * Display books starting with a specific initial.
     */
    public function indexJudulShow(Request $request, $initial)
    {
        $perPage = $request->input('per_page', 10);
        $query = Book::with(['items.location'])
            ->where('title', 'like', $initial . '%');

        if ($perPage === 'all' || $perPage == 0) {
            $books = $query->get()->toArray();
            // Wrap in a LengthAwarePaginator-like structure for view compatibility
            $books = new \Illuminate\Pagination\LengthAwarePaginator(
                $query->get(),
                $query->count(),
                $query->count() ?: 1,
                1
            );
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
            $query->where('title', 'like', $request->starts_with . '%');
        }

        // 2. Specific search modal parameters
        if ($request->filled('inJudul')) {
            $this->applyAdvancedSearch($query, $request->inJudul, ['title']);
        }
        if ($request->filled('inPengarang1')) {
            $this->applyAdvancedSearch($query, $request->inPengarang1, ['author']);
        }
        if ($request->filled('inPenerbit')) {
            $this->applyAdvancedSearch($query, $request->inPenerbit, ['publisher']);
        }
        if ($request->filled('inSubyek')) {
            $this->applyAdvancedSearch($query, $request->inSubyek, ['subject']);
        }
        if ($request->filled('intahunterbit')) {
            $query->where('publish_year', $request->intahunterbit);
        }
        if ($request->filled('inisbn')) {
            $this->applyAdvancedSearch($query, $request->inisbn, ['isbn']);
        }
        if ($request->filled('inKlasifikasi')) {
            $this->applyAdvancedSearch($query, $request->inKlasifikasi, ['classification']);
        }
        if ($request->filled('inJenis')) {
            $query->where('jenis', $request->inJenis);
        }

        // Barcode or Location filtering (relates to items)
        if ($request->filled('inbarcode') || $request->filled('inLokasi')) {
            $query->whereHas('items', function ($itemQuery) use ($request) {
                if ($request->filled('inbarcode')) {
                    $itemQuery->where('barcode', 'like', "%{$request->inbarcode}%");
                }
                if ($request->filled('inLokasi')) {
                    $itemQuery->whereHas('location', function ($locQuery) use ($request) {
                        $locQuery->where('code', $request->inLokasi);
                    });
                }
            });
        }

        // Paginate results (supports dynamic per_page or custom limit)
        $perPage = request()->input('per_page', 10);
        if ($perPage === 'all') {
            $books = $query->with(['items.location'])->paginate(999999)->withQueryString();
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
        $book = Book::with(['items.location'])->findOrFail($id);
        
        return view('detail', compact('book'));
    }

    /**
     * Display the 20 latest books.
     */
    public function latest(Request $request)
    {
        $query = Book::with(['items.location'])->latest();

        if ($request->filled('location')) {
            $locationCode = $request->location;
            $query->whereHas('items.location', function ($q) use ($locationCode) {
                $q->where('code', $locationCode);
            });
        }

        $latestBooks = $query->take(20)->get();
        
        $locations = Location::all();
        
        return view('koleksi-terbaru', compact('latestBooks', 'locations'));
    }

    /**
     * Display the gallery page.
     */
    public function galeri(Request $request)
    {
        // Urutkan berdasarkan abjad (title) lalu berdasarkan ID (penomoran)
        $query = Book::with(['items.location'])->orderBy('title', 'asc')->orderBy('id', 'asc');
        
        if ($request->filled('q')) {
            $this->applyAdvancedSearch($query, $request->q);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $perPage = $request->input('per', 24);
        $books = $query->paginate($perPage)->withQueryString();

        if ($request->ajax()) {
            return view('partials.gallery_content', compact('books', 'perPage'));
        }

        return view('galeri', compact('books', 'perPage'));
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
