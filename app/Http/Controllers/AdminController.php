<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Location;
use App\Models\Item;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(function ($request, $next) {
                \Log::info('[ADMIN-DEBUG] Middleware hit', [
                    'auth_check' => auth()->check(),
                    'session_id' => session()->getId(),
                    'user'       => auth()->check() ? auth()->user()->username : null,
                    'role'       => auth()->check() ? auth()->user()->role : null,
                ]);

                if (!auth()->check() || auth()->user()->role !== 'pustakawan') {
                    \Log::warning('[ADMIN-DEBUG] Access DENIED. auth()->check()=' . (auth()->check() ? 'true' : 'false'));
                    return redirect()->route('login')->withErrors(['email' => 'Silakan masuk sebagai Pustakawan terlebih dahulu.']);
                }
                return $next($request);
            }),
        ];
    }
    /**
     * Show the admin dashboard and book list.
     */
    public function index(Request $request)
    {
        // Calculate dashboard statistics
        $totalBooks = Book::count();
        $totalItems = Item::count();
        $availableItems = Item::where('kodestatus_eksemplar', 'TSD')->count();
        $borrowedItems = Item::where('kodestatus_eksemplar', 'PJM')->count();
        
        $totalBooksWithCover = Book::whereHas('images')->count();
        $totalBooksWithoutCover = Book::whereDoesntHave('images')->count();
        
        $totalBooksWithRingkasan = Book::whereNotNull('ringkasanbuku')->where('ringkasanbuku', '!=', '')->count();
        $totalBooksWithoutRingkasan = Book::where(function($q) {
            $q->whereNull('ringkasanbuku')->orWhere('ringkasanbuku', '');
        })->count();

        // Get list of all locations for the dropdown, with "Belum Ada Lokasi" at the top
        $locationsList = \Illuminate\Support\Facades\DB::table('tbllokasi')
            ->orderByRaw("CASE WHEN lokasi = 'Belum Ada Lokasi' THEN 1 ELSE 2 END")
            ->orderBy('lokasi')
            ->pluck('lokasi');

        // Calculate stats for each Location or Koleksi Terbaru for Cover
        if ($request->filled('lokasi_cover') && $request->lokasi_cover !== 'all') {
            if ($request->lokasi_cover === 'koleksi_terbaru') {
                $yearPrefix = date('y');
                $prefix = $yearPrefix . '00';
                $fullYear = date('Y');
                $hasNewFormat = \Illuminate\Support\Facades\DB::table('tbleksemplar')
                    ->join('tblbuku', 'tbleksemplar.idmaster', '=', 'tblbuku.idmaster')
                    ->where('tbleksemplar.nomor_eksemplar', 'like', $prefix . '%')
                    ->whereRaw('LENGTH(tbleksemplar.nomor_eksemplar) = 8')
                    ->whereRaw('tbleksemplar.nomor_eksemplar REGEXP "^[0-9]+$"')
                    ->where('tblbuku.tahun', $fullYear)
                    ->exists();
                if (!$hasNewFormat) {
                    $prefix = (string)((int)$yearPrefix - 1) . '00';
                    $fullYear = (string)((int)$fullYear - 1);
                }
                $latest40Ids = Book::select('tblbuku.idmaster')
                    ->join('tbleksemplar', 'tblbuku.idmaster', '=', 'tbleksemplar.idmaster')
                    ->where('tbleksemplar.nomor_eksemplar', 'like', $prefix . '%')
                    ->whereRaw('LENGTH(tbleksemplar.nomor_eksemplar) = 8')
                    ->whereRaw('tbleksemplar.nomor_eksemplar REGEXP "^[0-9]+$"')
                    ->where('tblbuku.tahun', $fullYear)
                    ->groupBy('tblbuku.idmaster')
                    ->orderByRaw('MAX(CAST(SUBSTRING(tbleksemplar.nomor_eksemplar, 5) AS UNSIGNED)) DESC')
                    ->limit(40)
                    ->pluck('idmaster');

                $locationStatsCover = \Illuminate\Support\Facades\DB::table('tblbuku')
                    ->leftJoin('galeri_buku', 'tblbuku.idmaster', '=', 'galeri_buku.book_id')
                    ->whereIn('tblbuku.idmaster', $latest40Ids)
                    ->select(
                        \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT tblbuku.idbuku) as total_books'),
                        \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT CASE WHEN galeri_buku.id IS NOT NULL THEN tblbuku.idbuku END) as with_cover'),
                        \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT CASE WHEN galeri_buku.id IS NULL THEN tblbuku.idbuku END) as without_cover')
                    )->first();
                $selectedLocationCover = 'Koleksi Terbaru';
            } else {
                $locationStatsCover = \Illuminate\Support\Facades\DB::table('tbllokasi')
                    ->join('tbleksemplar', 'tbllokasi.idlokasi', '=', 'tbleksemplar.kodelokasi')
                    ->join('tblbuku', 'tbleksemplar.idmaster', '=', 'tblbuku.idmaster')
                    ->leftJoin('galeri_buku', 'tblbuku.idmaster', '=', 'galeri_buku.book_id')
                    ->where('tbllokasi.lokasi', $request->lokasi_cover)
                    ->select(
                        \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT tblbuku.idbuku) as total_books'),
                        \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT CASE WHEN galeri_buku.id IS NOT NULL THEN tblbuku.idbuku END) as with_cover'),
                        \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT CASE WHEN galeri_buku.id IS NULL THEN tblbuku.idbuku END) as without_cover')
                    )->first();
                $selectedLocationCover = $request->lokasi_cover;
            }
        } else {
            $locationStatsCover = (object) [
                'total_books' => $totalBooks,
                'with_cover' => $totalBooksWithCover,
                'without_cover' => $totalBooksWithoutCover
            ];
            $selectedLocationCover = 'Semua Lokasi';
        }

        // Calculate stats for each Location or Koleksi Terbaru for Ringkasan
        if ($request->filled('lokasi_ringkasan') && $request->lokasi_ringkasan !== 'all') {
            if ($request->lokasi_ringkasan === 'koleksi_terbaru') {
                $yearPrefix = date('y');
                $prefix = $yearPrefix . '00';
                $fullYear = date('Y');
                $hasNewFormat = \Illuminate\Support\Facades\DB::table('tbleksemplar')
                    ->join('tblbuku', 'tbleksemplar.idmaster', '=', 'tblbuku.idmaster')
                    ->where('tbleksemplar.nomor_eksemplar', 'like', $prefix . '%')
                    ->whereRaw('LENGTH(tbleksemplar.nomor_eksemplar) = 8')
                    ->whereRaw('tbleksemplar.nomor_eksemplar REGEXP "^[0-9]+$"')
                    ->where('tblbuku.tahun', $fullYear)
                    ->exists();
                if (!$hasNewFormat) {
                    $prefix = (string)((int)$yearPrefix - 1) . '00';
                    $fullYear = (string)((int)$fullYear - 1);
                }
                $latest40Ids = Book::select('tblbuku.idmaster')
                    ->join('tbleksemplar', 'tblbuku.idmaster', '=', 'tbleksemplar.idmaster')
                    ->where('tbleksemplar.nomor_eksemplar', 'like', $prefix . '%')
                    ->whereRaw('LENGTH(tbleksemplar.nomor_eksemplar) = 8')
                    ->whereRaw('tbleksemplar.nomor_eksemplar REGEXP "^[0-9]+$"')
                    ->where('tblbuku.tahun', $fullYear)
                    ->groupBy('tblbuku.idmaster')
                    ->orderByRaw('MAX(CAST(SUBSTRING(tbleksemplar.nomor_eksemplar, 5) AS UNSIGNED)) DESC')
                    ->limit(40)
                    ->pluck('idmaster');

                $locationStatsRingkasan = \Illuminate\Support\Facades\DB::table('tblbuku')
                    ->whereIn('idmaster', $latest40Ids)
                    ->select(
                        \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT idbuku) as total_books'),
                        \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT CASE WHEN ringkasanbuku IS NOT NULL AND ringkasanbuku != "" THEN idbuku END) as with_ringkasan'),
                        \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT CASE WHEN ringkasanbuku IS NULL OR ringkasanbuku = "" THEN idbuku END) as without_ringkasan')
                    )->first();
                $selectedLocationRingkasan = 'Koleksi Terbaru';
            } else {
                $locationStatsRingkasan = \Illuminate\Support\Facades\DB::table('tbllokasi')
                    ->join('tbleksemplar', 'tbllokasi.idlokasi', '=', 'tbleksemplar.kodelokasi')
                    ->join('tblbuku', 'tbleksemplar.idmaster', '=', 'tblbuku.idmaster')
                    ->where('tbllokasi.lokasi', $request->lokasi_ringkasan)
                    ->select(
                        \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT tblbuku.idbuku) as total_books'),
                        \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT CASE WHEN tblbuku.ringkasanbuku IS NOT NULL AND tblbuku.ringkasanbuku != "" THEN tblbuku.idbuku END) as with_ringkasan'),
                        \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT CASE WHEN tblbuku.ringkasanbuku IS NULL OR tblbuku.ringkasanbuku = "" THEN tblbuku.idbuku END) as without_ringkasan')
                    )->first();
                $selectedLocationRingkasan = $request->lokasi_ringkasan;
            }
        } else {
            $locationStatsRingkasan = (object) [
                'total_books' => $totalBooks,
                'with_ringkasan' => $totalBooksWithRingkasan,
                'without_ringkasan' => $totalBooksWithoutRingkasan
            ];
            $selectedLocationRingkasan = 'Semua Lokasi';
        }

        return view('admin.index', compact(
            'totalBooks',
            'totalItems',
            'availableItems',
            'borrowedItems',
            'totalBooksWithCover',
            'totalBooksWithoutCover',
            'totalBooksWithRingkasan',
            'totalBooksWithoutRingkasan',
            'locationStatsCover',
            'selectedLocationCover',
            'locationStatsRingkasan',
            'selectedLocationRingkasan',
            'locationsList'
        ));
    }

    /**
     * Show the admin 'Tambah Cover' page.
     */
    public function tambahCoverIndex(Request $request)
    {
        // Query books with search
        $query = Book::with(['images', 'items.location'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_buku', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%")
                  ->orWhere('idpenerbit', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('cover_filter')) {
            $filter = $request->cover_filter;
            if ($filter === 'no_cover') {
                $query->whereDoesntHave('images');
            } elseif ($filter === 'has_cover') {
                $query->whereHas('images');
            }
        }

        if ($request->filled('location_filter') && $request->location_filter !== 'all') {
            $locFilter = $request->location_filter;
            if ($locFilter === 'koleksi_terbaru') {
                $yearPrefix = date('y');
                $prefix = $yearPrefix . '00';
                $fullYear = date('Y');
                $hasNewFormat = \Illuminate\Support\Facades\DB::table('tbleksemplar')
                    ->join('tblbuku', 'tbleksemplar.idmaster', '=', 'tblbuku.idmaster')
                    ->where('tbleksemplar.nomor_eksemplar', 'like', $prefix . '%')
                    ->whereRaw('LENGTH(tbleksemplar.nomor_eksemplar) = 8')
                    ->whereRaw('tbleksemplar.nomor_eksemplar REGEXP "^[0-9]+$"')
                    ->where('tblbuku.tahun', $fullYear)
                    ->exists();
                if (!$hasNewFormat) {
                    $prefix = (string)((int)$yearPrefix - 1) . '00';
                    $fullYear = (string)((int)$fullYear - 1);
                }
                $latest40Ids = Book::select('tblbuku.idmaster')
                    ->join('tbleksemplar', 'tblbuku.idmaster', '=', 'tbleksemplar.idmaster')
                    ->where('tbleksemplar.nomor_eksemplar', 'like', $prefix . '%')
                    ->whereRaw('LENGTH(tbleksemplar.nomor_eksemplar) = 8')
                    ->whereRaw('tbleksemplar.nomor_eksemplar REGEXP "^[0-9]+$"')
                    ->where('tblbuku.tahun', $fullYear)
                    ->groupBy('tblbuku.idmaster')
                    ->orderByRaw('MAX(CAST(SUBSTRING(tbleksemplar.nomor_eksemplar, 5) AS UNSIGNED)) DESC')
                    ->limit(40)
                    ->pluck('idmaster');

                $query->whereIn('idmaster', $latest40Ids);
            } else {
                $query->whereHas('items', function ($itemQuery) use ($locFilter) {
                    $itemQuery->where('kodelokasi', $locFilter);
                });
            }
        }

        $perPage = $request->input('limit', 10);
        if ($perPage === 'all') {
            $perPage = 500;
        } else {
            $perPage = is_numeric($perPage) ? min(500, (int)$perPage) : 10;
        }

        $books = $query->paginate($perPage)->withQueryString();
        $locations = Location::orderByRaw("CASE WHEN lokasi = 'Belum Ada Lokasi' THEN 1 ELSE 2 END")
            ->orderBy('lokasi', 'asc')
            ->get();

        $actionType = 'cover';
        if ($request->ajax()) {
            return view('admin.partials.books_table', compact('books', 'actionType'));
        }

        return view('admin.tambah_cover', compact('books', 'locations', 'actionType'));
    }

    public function tambahRingkasanIndex(Request $request)
    {
        $query = Book::with(['items.location'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_buku', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%")
                  ->orWhere('idpenerbit', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('cover_filter')) {
            $filter = $request->cover_filter;
            if ($filter === 'no_cover') {
                $query->where(function ($q) {
                    $q->whereNull('ringkasanbuku')->orWhere('ringkasanbuku', '');
                });
            } elseif ($filter === 'has_cover') {
                $query->whereNotNull('ringkasanbuku')->where('ringkasanbuku', '!=', '');
            }
        }

        if ($request->filled('location_filter') && $request->location_filter !== 'all') {
            $locFilter = $request->location_filter;
            if ($locFilter === 'koleksi_terbaru') {
                $yearPrefix = date('y');
                $prefix = $yearPrefix . '00';
                $fullYear = date('Y');
                $hasNewFormat = \Illuminate\Support\Facades\DB::table('tbleksemplar')
                    ->join('tblbuku', 'tbleksemplar.idmaster', '=', 'tblbuku.idmaster')
                    ->where('tbleksemplar.nomor_eksemplar', 'like', $prefix . '%')
                    ->whereRaw('LENGTH(tbleksemplar.nomor_eksemplar) = 8')
                    ->whereRaw('tbleksemplar.nomor_eksemplar REGEXP "^[0-9]+$"')
                    ->where('tblbuku.tahun', $fullYear)
                    ->exists();
                if (!$hasNewFormat) {
                    $prefix = (string)((int)$yearPrefix - 1) . '00';
                    $fullYear = (string)((int)$fullYear - 1);
                }
                $latest40Ids = Book::select('tblbuku.idmaster')
                    ->join('tbleksemplar', 'tblbuku.idmaster', '=', 'tbleksemplar.idmaster')
                    ->where('tbleksemplar.nomor_eksemplar', 'like', $prefix . '%')
                    ->whereRaw('LENGTH(tbleksemplar.nomor_eksemplar) = 8')
                    ->whereRaw('tbleksemplar.nomor_eksemplar REGEXP "^[0-9]+$"')
                    ->where('tblbuku.tahun', $fullYear)
                    ->groupBy('tblbuku.idmaster')
                    ->orderByRaw('MAX(CAST(SUBSTRING(tbleksemplar.nomor_eksemplar, 5) AS UNSIGNED)) DESC')
                    ->limit(40)
                    ->pluck('idmaster');

                $query->whereIn('idmaster', $latest40Ids);
            } else {
                $query->whereHas('items', function ($itemQuery) use ($locFilter) {
                    $itemQuery->where('kodelokasi', $locFilter);
                });
            }
        }

        $perPage = $request->input('limit', 10);
        if ($perPage === 'all') {
            $perPage = 500;
        } else {
            $perPage = is_numeric($perPage) ? min(500, (int)$perPage) : 10;
        }

        $books = $query->paginate($perPage)->withQueryString();
        $locations = Location::orderByRaw("CASE WHEN lokasi = 'Belum Ada Lokasi' THEN 1 ELSE 2 END")
            ->orderBy('lokasi', 'asc')
            ->get();

        $actionType = 'ringkasan';
        if ($request->ajax()) {
            return view('admin.partials.books_table', compact('books', 'actionType'));
        }

        return view('admin.tambah_ringkasan', compact('books', 'locations', 'actionType'));
    }

    public function galeri(Request $request)
    {
        $query = Book::with(['items'])->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_buku', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('limit', 10);
        if ($perPage === 'all') {
            $perPage = $query->count() ?: 10;
        } else {
            $perPage = is_numeric($perPage) ? (int)$perPage : 10;
        }

        $books = $query->paginate($perPage)->withQueryString();
        
        if ($request->ajax()) {
            return view('admin.partials.gallery_grid', compact('books'));
        }

        return view('admin.galeri', compact('books'));
    }

    public function pesan(Request $request)
    {
        $perPage = $request->input('limit', 10);
        if ($perPage === 'all') {
            $perPage = Message::count() ?: 10;
        } else {
            $perPage = is_numeric($perPage) ? (int)$perPage : 10;
        }
        $messages = Message::latest()->paginate($perPage)->withQueryString();
        return view('admin.pesan', compact('messages'));
    }

    /**
     * Store a new book along with its physical copies (items).
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'                => 'required|string|max:255',
            'author'               => 'required|string|max:255',
            'publisher'            => 'nullable|string|max:255',
            'publication_city'     => 'nullable|string|max:255',
            'edition'              => 'nullable|string|max:255',
            'publish_year'         => 'nullable|integer',
            'isbn'                 => 'nullable|string|max:255',
            'physical_description' => 'nullable|string|max:255',
            'classification'       => 'nullable|string|max:255',
            'golongan'             => 'nullable|string|max:255',
            'subject'              => 'nullable|string|max:255',
            'language'             => 'nullable|string|max:255',
            'jenis'                => 'nullable|string|max:255',
            'category'             => 'nullable|string|max:255',
            'general_note'         => 'nullable|string',
            'pdf_file'             => 'nullable|file|mimes:pdf|max:20480',
            'images'               => 'nullable|array|max:4',
            'images.*'             => 'file|mimes:jpeg,png,jpg,gif,svg,webp,avif,bmp,heic|max:20480',

            // Validation for dynamic items
            'items.*.barcode'     => 'required|string|unique:tbleksemplar,nomor_eksemplar|max:255',
            'items.*.location_id' => 'required|exists:tbllokasi,idlokasi',
            'items.*.type'        => 'required|string|in:STD,KPS',
        ], [
            'items.*.barcode.unique'      => 'Barcode :input sudah digunakan oleh buku lain.',
            'items.*.barcode.required'    => 'Barcode wajib diisi.',
            'items.*.location_id.required'=> 'Lokasi rak wajib dipilih.',
            'items.*.type.required'       => 'Tipe eksemplar wajib dipilih.',
            'images.max'                  => 'Maksimal 4 gambar (1 utama & 3 tambahan) yang dapat diunggah sekaligus.',
            'images.*.max'                => 'Ukuran setiap gambar tidak boleh melebihi 20 MB.',
            'images.*.image'              => 'File yang diunggah harus berupa gambar.',
            'images.*.mimes'              => 'Format gambar harus jpeg, png, jpg, gif, svg, webp, avif, bmp, atau heic.',
        ]);

        try {
            DB::beginTransaction();

            $bookData = $request->only([
                'title', 'author', 'publisher', 'publication_city', 'edition',
                'publish_year', 'isbn', 'physical_description', 'classification',
                'golongan', 'subject', 'language', 'jenis', 'category', 'general_note'
            ]);

            // Build call number from classification + author + title if not provided
            $bookData['call_number'] = $request->input('call_number')
                ?: (trim($request->input('classification') . ' ' . substr($request->input('author'), 0, 3) . ' ' . strtolower(substr($request->input('title'), 0, 1))));

            if (!$request->filled('category')) {
                $bookData['category'] = 'Umum';
            }

            // Handle optional PDF/E-book upload
            if ($request->hasFile('pdf_file')) {
                $pdf = $request->file('pdf_file');
                $pdfName = time() . '_' . preg_replace('/\s+/', '_', $pdf->getClientOriginalName());
                $pdf->move(public_path('ebooks'), $pdfName);
                $bookData['pdf_file'] = $pdfName;
            }

            // Save the book
            $book = Book::create($bookData);

            // Handle multiple image file upload into galeri_buku
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $index => $img) {
                    $imgName = $this->saveImageAsAvif($img);
                    $book->images()->create([
                        'image_path' => $imgName,
                        'is_cover'   => $index === 0 ? 1 : 0,
                        'sort_order' => $index,
                    ]);
                }
            }

            // Add copies/items if provided
            if ($request->has('items')) {
                foreach ($request->items as $itemData) {
                    Item::create([
                        'barcode'     => $itemData['barcode'],
                        'book_id'     => $book->id,
                        'location_id' => $itemData['location_id'],
                        'call_number' => $book->call_number,
                        'status'      => 'Tersedia',
                        'type'        => $itemData['type'] ?? 'STD',
                    ]);
                }
            }

            DB::commit();

            // Auto-clear cache beranda agar buku baru langsung tampil
            $this->clearBookCache();

            return redirect()->route('admin.index')
                ->with('success', 'Buku "' . $book->title . '" dan eksemplarnya berhasil ditambahkan ke database.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal menyimpan buku: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the edit form for a specific book.
     */
    public function edit($id)
    {
        $book      = Book::with(['items.location', 'images'])->where('idmaster', $id)->firstOrFail();
        $locations = Location::all();

        return view('admin.edit', compact('book', 'locations'));
    }

    /**
     * Update the specified book in the database.
     */
    public function update(Request $request, $id)
    {
        $book = Book::where('idmaster', $id)->firstOrFail();

        $request->validate([
            'title'                => 'required|string|max:255',
            'author'               => 'required|string|max:255',
            'publisher'            => 'nullable|string|max:255',
            'publication_city'     => 'nullable|string|max:255',
            'edition'              => 'nullable|string|max:255',
            'publish_year'         => 'nullable|integer',
            'isbn'                 => 'nullable|string|max:255',
            'physical_description' => 'nullable|string|max:255',
            'classification'       => 'nullable|string|max:255',
            'golongan'             => 'nullable|string|max:255',
            'subject'              => 'nullable|string|max:255',
            'language'             => 'nullable|string|max:255',
            'jenis'                => 'nullable|string|max:255',
            'category'             => 'nullable|string|max:255',
            'general_note'         => 'nullable|string',
            'cover_image'          => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,avif,bmp,heic|max:20480',
            'delete_cover'         => 'nullable|boolean',
            'pdf_file'             => 'nullable|file|mimes:pdf|max:20480',
            'delete_pdf'           => 'nullable|boolean',
            'additional_images.*'  => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,avif,bmp,heic|max:20480',
            'delete_additional_images.*' => 'nullable|integer|exists:galeri_buku,id',
            'image_order_json'     => 'nullable|string',
            'new_files.*'          => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,avif,bmp,heic|max:20480',
 
            // Existing items update
            'items.*.barcode'      => 'required|string|max:255',
            'items.*.location_id'  => 'required|exists:tbllokasi,idlokasi',
            'items.*.type'         => 'required|string|in:STD,KPS',
 
            // New items to add
            'new_items.*.barcode'      => 'nullable|string|unique:tbleksemplar,nomor_eksemplar|max:255',
            'new_items.*.location_id'  => 'nullable|exists:tbllokasi,idlokasi',
            'new_items.*.type'         => 'nullable|string|in:STD,KPS',
        ], [
            'cover_image.image' => 'File sampul buku harus berupa gambar.',
            'cover_image.mimes' => 'Format sampul buku harus jpeg, png, jpg, gif, svg, webp, avif, bmp, atau heic.',
            'cover_image.max' => 'Ukuran sampul buku tidak boleh melebihi 20 MB.',
            'additional_images.*.image' => 'File tambahan harus berupa gambar.',
            'additional_images.*.mimes' => 'Format file tambahan harus jpeg, png, jpg, gif, svg, webp, avif, bmp, atau heic.',
            'additional_images.*.max' => 'Ukuran setiap gambar tambahan tidak boleh melebihi 20 MB.',
            'new_files.*.image' => 'File gambar baru harus berupa gambar.',
            'new_files.*.mimes' => 'Format file gambar baru harus jpeg, png, jpg, gif, svg, webp, avif, bmp, atau heic.',
            'new_files.*.max' => 'Ukuran file gambar baru tidak boleh melebihi 20 MB.',
        ]);

        try {
            DB::beginTransaction();

            // Calculate and validate final additional images count (limit to 4 total: 1 cover + 3 additional)
            $existingImagesCount = $book->images()->count();
            $deletedImagesCount = $request->has('delete_additional_images') ? count($request->delete_additional_images) : 0;
            $newImagesCount = $request->hasFile('additional_images') ? count($request->file('additional_images')) : 0;
            $newFilesCount = $request->hasFile('new_files') ? count($request->file('new_files')) : 0;
            $finalImagesCount = max(0, $existingImagesCount - $deletedImagesCount) + max($newImagesCount, $newFilesCount);

            if ($finalImagesCount > 4) {
                throw new \Exception('Maksimal total gambar tambahan adalah 3 foto.');
            }

            $bookData = $request->only([
                'title', 'author', 'publisher', 'publication_city', 'edition',
                'publish_year', 'isbn', 'physical_description', 'classification',
                'golongan', 'subject', 'language', 'jenis', 'category', 'general_note', 'call_number'
            ]);

            if (!$request->filled('category')) {
                $bookData['category'] = 'Umum';
            }

            // Handle cover and additional images sequence using custom order JSON
            if ($request->filled('image_order_json')) {
                $order = json_decode($request->image_order_json, true);
                
                $oldImages = $book->images->pluck('image_path')->toArray();
                $keptFiles = [];

                $newFiles = $request->file('new_files') ?: [];
                $finalImageRecords = [];

                foreach ($order as $index => $item) {
                    if ($item['type'] === 'existing') {
                        $filename = basename($item['path']);
                        $keptFiles[] = $filename;
                        $finalImageRecords[] = [
                            'image_path' => $filename,
                            'is_cover'   => $index === 0 ? 1 : 0,
                            'sort_order' => $index,
                        ];
                    } elseif ($item['type'] === 'new') {
                        $fileIdx = $item['index'];
                        if (isset($newFiles[$fileIdx])) {
                            $file = $newFiles[$fileIdx];
                            $name = $this->saveImageAsAvif($file);
                            $keptFiles[] = $name;
                            $finalImageRecords[] = [
                                'image_path' => $name,
                                'is_cover'   => $index === 0 ? 1 : 0,
                                'sort_order' => $index,
                            ];
                        } else {
                            throw new \Exception("File gambar ke-" . ($index + 1) . " tidak diterima server. Pastikan ukuran file tidak melebihi batas upload server.");
                        }
                    }
                }

                // Delete unused old image files from disk
                foreach ($oldImages as $oldPath) {
                    if ($oldPath && !in_array($oldPath, $keptFiles)) {
                        if (file_exists(public_path('covers/' . $oldPath))) {
                            @unlink(public_path('covers/' . $oldPath));
                        }
                    }
                }

                // Synchronize database entries using UPDATE and INSERT (Zero-DELETE strategy).
                // This prevents SQL 1142 DELETE command denied errors on servers where
                // database user only has SELECT, INSERT, and UPDATE privileges.
                $existingImageModels = $book->images()->get();
                $finalCount = count($finalImageRecords);
                $existingCount = $existingImageModels->count();

                // 1. Update existing records in-place
                for ($i = 0; $i < min($finalCount, $existingCount); $i++) {
                    $existingImageModels[$i]->update([
                        'image_path' => $finalImageRecords[$i]['image_path'],
                        'is_cover'   => $finalImageRecords[$i]['is_cover'],
                        'sort_order' => $finalImageRecords[$i]['sort_order'],
                    ]);
                }

                // 2. If there are more new records than existing ones, recycle blank slots or insert
                for ($i = $existingCount; $i < $finalCount; $i++) {
                    $recycled = \App\Models\BookImage::where('book_id', 0)
                        ->orWhere('image_path', '')
                        ->orWhereNull('image_path')
                        ->first();

                    if ($recycled) {
                        $recycled->update([
                            'book_id'    => $book->idmaster,
                            'image_path' => $finalImageRecords[$i]['image_path'],
                            'is_cover'   => $finalImageRecords[$i]['is_cover'],
                            'sort_order' => $finalImageRecords[$i]['sort_order'],
                        ]);
                    } else {
                        $book->images()->create($finalImageRecords[$i]);
                    }
                }

                // 3. If there are leftover existing records (user reduced images), decouple them cleanly
                for ($i = $finalCount; $i < $existingCount; $i++) {
                    $existingImageModels[$i]->update([
                        'book_id'    => 0,
                        'image_path' => '',
                        'is_cover'   => 0,
                        'sort_order' => 9999,
                    ]);
                }
            } else {
                // Handle deleting the cover image (Legacy)
                if ($request->boolean('delete_cover')) {
                    $cover = $book->images()->where('is_cover', 1)->first() ?? $book->images()->first();
                    if ($cover) {
                        if (file_exists(public_path('covers/' . $cover->image_path))) {
                            @unlink(public_path('covers/' . $cover->image_path));
                        }
                        $cover->update([
                            'book_id'    => 0,
                            'image_path' => '',
                            'is_cover'   => 0,
                            'sort_order' => 9999,
                        ]);
                    }
                }

                // Handle cover image upload (replace old one) (Legacy)
                if ($request->hasFile('cover_image')) {
                    $image = $request->file('cover_image');
                    $name = $this->saveImageAsAvif($image);
                    
                    $cover = $book->images()->where('is_cover', 1)->first() ?? $book->images()->first();
                    if ($cover) {
                        if (file_exists(public_path('covers/' . $cover->image_path))) {
                            @unlink(public_path('covers/' . $cover->image_path));
                        }
                        $cover->update(['image_path' => $name, 'is_cover' => 1]);
                    } else {
                        $book->images()->create([
                            'image_path' => $name,
                            'is_cover'   => 1,
                            'sort_order' => 0,
                        ]);
                    }
                }
            }

            // Handle deleting the PDF file
            if ($request->boolean('delete_pdf')) {
                if ($book->pdf_file && file_exists(public_path('ebooks/' . $book->pdf_file))) {
                    @unlink(public_path('ebooks/' . $book->pdf_file));
                }
                $bookData['pdf_file'] = null;
            }

            // Handle PDF upload (replace old one)
            if ($request->hasFile('pdf_file')) {
                // Delete old PDF if exists
                if ($book->pdf_file && file_exists(public_path('ebooks/' . $book->pdf_file))) {
                    @unlink(public_path('ebooks/' . $book->pdf_file));
                }
                $pdf = $request->file('pdf_file');
                $pdfName  = time() . '_' . preg_replace('/\s+/', '_', $pdf->getClientOriginalName());
                $pdf->move(public_path('ebooks'), $pdfName);
                $bookData['pdf_file'] = $pdfName;
            }

            if (auth()->check()) {
                $bookData['userinput'] = auth()->user()->username ?? $book->userinput;
                $bookData['iduser']    = auth()->user()->iduser ?? $book->iduser;
            }
            $bookData['tgledit'] = now();

            $book->update($bookData);

            // Update existing items - Cast barcode to string to avoid truncated incorrect double error in MySQL
            if ($request->has('items')) {
                foreach ($request->items as $barcode => $itemData) {
                    $updateData = [
                        'location_id' => $itemData['location_id'],
                        'type'        => $itemData['type'] ?? 'STD',
                    ];
                    if (isset($itemData['status'])) {
                        $updateData['status'] = $itemData['status'];
                    }
                    Item::where('nomor_eksemplar', (string) $barcode)->update($updateData);
                }
            }

            // Delete items marked for removal
            if ($request->has('delete_items')) {
                Item::whereIn('nomor_eksemplar', $request->delete_items)->delete();
            }

            // Add new items
            if ($request->has('new_items')) {
                foreach ($request->new_items as $newItem) {
                    if (!empty($newItem['barcode']) && !empty($newItem['location_id'])) {
                        Item::create([
                            'barcode'     => $newItem['barcode'],
                            'book_id'     => $book->id,
                            'location_id' => $newItem['location_id'],
                            'call_number' => $book->call_number,
                            'status'      => 'Tersedia',
                            'type'        => $newItem['type'] ?? 'STD',
                        ]);
                    }
                }
            }

            if (!$request->filled('image_order_json')) {
                // Delete selected additional images (Zero-DELETE strategy via decouple)
                if ($request->has('delete_additional_images')) {
                    $imagesToDelete = \App\Models\BookImage::whereIn('id', $request->delete_additional_images)->get();
                    foreach ($imagesToDelete as $img) {
                        if (file_exists(public_path('covers/' . $img->image_path))) {
                            @unlink(public_path('covers/' . $img->image_path));
                        }
                        $img->update([
                            'book_id'    => 0,
                            'image_path' => '',
                            'is_cover'   => 0,
                            'sort_order' => 9999,
                        ]);
                    }
                }

                // Upload new additional images (only if book has a cover or a new cover is uploaded)
                if ($request->hasFile('additional_images')) {
                    $hasCover = ($book->cover_image && !$request->boolean('delete_cover')) || $request->hasFile('cover_image');
                    if (!$hasCover) {
                        throw new \Exception('Unggah sampul default terlebih dahulu sebelum menambahkan gambar tambahan.');
                    }
                    foreach ($request->file('additional_images') as $file) {
                        $name = $this->saveImageAsAvif($file);
                        $book->images()->create([
                            'image_path' => $name,
                         ]);
                    }
                }
            }

            DB::commit();

            // Auto-clear cache beranda agar perubahan buku langsung tampil
            $this->clearBookCache();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Buku "' . $book->title . '" berhasil diperbarui.',
                ]);
            }

            return redirect()->back()
                ->with('success', 'Buku "' . $book->title . '" berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Tangani error privilege database server (INSERT/UPDATE/DELETE denied)
            $msg = $e->getMessage();
            if (str_contains($msg, '1142') || str_contains($msg, 'command denied')) {
                $friendlyMsg = 'Upload cover gagal: server database kampus belum mengizinkan operasi ini. '
                    . 'Mohon hubungi admin IT kampus untuk memberikan hak INSERT/UPDATE pada tabel galeri_buku '
                    . 'ke user digilib@10.168.17.233. (Error: ' . $msg . ')';
            } else {
                $friendlyMsg = 'Gagal memperbarui buku: ' . $msg;
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $friendlyMsg,
                ], 422);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => $friendlyMsg]);
        }
    }


    public function updateRingkasan(Request $request, $id)
    {
        $book = Book::where('idmaster', $id)->firstOrFail();

        $request->validate([
            'ringkasanbuku' => 'nullable|string',
        ]);

        try {
            $updateData = [
                'ringkasanbuku' => $request->ringkasanbuku,
                'tgledit'       => now(),
            ];
            if (auth()->check()) {
                $updateData['userinput'] = auth()->user()->username ?? $book->userinput;
                $updateData['iduser']    = auth()->user()->iduser ?? $book->iduser;
            }
            $book->update($updateData);

            // Auto-clear cache beranda agar ringkasan buku langsung tampil
            $this->clearBookCache();

            return redirect()->back()
                ->with('success', 'Ringkasan buku "' . $book->title . '" berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memperbarui ringkasan buku: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete cover image and any additional images of a book.
     */
    public function destroy($id)
    {
        try {
            $book = Book::where('idmaster', $id)->firstOrFail();

            // Delete all images from disk and decouple from galeri_buku (Zero-DELETE strategy)
            foreach ($book->images as $img) {
                if (file_exists(public_path('covers/' . $img->image_path))) {
                    @unlink(public_path('covers/' . $img->image_path));
                }
                $img->update([
                    'book_id'    => 0,
                    'image_path' => '',
                    'is_cover'   => 0,
                    'sort_order' => 9999,
                ]);
            }

            // Auto-clear cache beranda agar perubahan cover langsung tampil
            $this->clearBookCache();

            return redirect()->back()
                ->with('success', 'Gambar cover dan galeri berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Gagal menghapus cover: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete an additional book image immediately via AJAX.
     */
    public function deleteImage($id)
    {
        try {
            $img = \App\Models\BookImage::findOrFail($id);
            
            // Delete the image file if it exists, decouple row (Zero-DELETE strategy)
            if ($img->image_path && file_exists(public_path('covers/' . $img->image_path))) {
                @unlink(public_path('covers/' . $img->image_path));
            }
            
            $img->update([
                'book_id'    => 0,
                'image_path' => '',
                'is_cover'   => 0,
                'sort_order' => 9999,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Gambar tambahan berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus gambar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tampilkan halaman editor data referensi AI Chatbot (data_perpus.txt).
     */
    public function chatbotData()
    {
        $path    = storage_path('app/private/data_perpus.txt');
        $content = file_exists($path) ? file_get_contents($path) : '';
        $backupExists = file_exists($path . '.bak');
        $charCount = mb_strlen($content);

        $statusPath = storage_path('app/private/chatbot_status.txt');
        $chatbotDisabled = file_exists($statusPath) && trim(file_get_contents($statusPath)) === 'disabled';
        $chatbotStatus = $chatbotDisabled ? 'disabled' : 'active';

        return view('admin.chatbot_data', compact('content', 'backupExists', 'charCount', 'chatbotStatus'));
    }

    /**
     * Aktifkan / Nonaktifkan layanan AI Chatbot.
     */
    public function chatbotToggleStatus(Request $request)
    {
        $statusPath = storage_path('app/private/chatbot_status.txt');
        $currentDisabled = file_exists($statusPath) && trim(file_get_contents($statusPath)) === 'disabled';
        $newStatus = $currentDisabled ? 'active' : 'disabled';

        file_put_contents($statusPath, $newStatus);

        $msg = $newStatus === 'active'
            ? 'Layanan AI Chatbot berhasil DIAKTIFKAN kembali untuk pengunjung web.'
            : 'Layanan AI Chatbot berhasil DINONAKTIFKAN sementara.';

        return redirect()->route('admin.chatbot-data')->with('success', $msg);
    }

    /**
     * Simpan perubahan data referensi AI Chatbot ke file data_perpus.txt.
     * Membuat backup otomatis sebelum menimpa file lama.
     */
    public function chatbotDataUpdate(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:10',
        ], [
            'content.required' => 'Data referensi AI tidak boleh kosong.',
            'content.min'      => 'Data referensi AI terlalu pendek (minimal 10 karakter).',
        ]);

        $path    = storage_path('app/private/data_perpus.txt');
        $content = $request->input('content');

        // Buat backup file lama sebelum ditimpa
        if (file_exists($path)) {
            @copy($path, $path . '.bak');
        }

        $result = file_put_contents($path, $content);

        if ($result === false) {
            // Jika gagal tulis, kembalikan dari backup
            if (file_exists($path . '.bak')) {
                @copy($path . '.bak', $path);
            }
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal menyimpan data: Server tidak dapat menulis ke file. File lama telah dipulihkan dari backup.']);
        }

        return redirect()->route('admin.chatbot-data')
            ->with('success', 'Data referensi AI Chatbot berhasil disimpan. Cache chatbot lama otomatis tidak berlaku untuk pertanyaan baru.');
    }

    /**
     * Hapus semua cache jawaban AI chatbot dari tabel chat_caches.
     */
    public function chatbotCacheClear()
    {
        try {
            \App\Models\ChatCache::truncate();
            return redirect()->route('admin.chatbot-data')
                ->with('success', 'Seluruh cache jawaban AI Chatbot berhasil dihapus. Chatbot akan memakai data terbaru untuk semua pertanyaan.');
        } catch (\Exception $e) {
            return redirect()->route('admin.chatbot-data')
                ->withErrors(['error' => 'Gagal menghapus cache: ' . $e->getMessage()]);
        }
    }

    /**
     * Clear semua cache yang berkaitan dengan data buku di beranda & halaman lainnya.
     * Dipanggil otomatis setiap kali admin menambah, mengubah, atau menghapus buku.
     */
    private function clearBookCache(): void
    {
        Cache::forget('home_location_counts');
        Cache::forget('home_location_counts_v2');
        Cache::forget('home_location_ids');
        Cache::forget('home_location_ids_v2');
        Cache::forget('home_latest_book_ids');
        Cache::forget('home_latest_book_ids_v2');
        Cache::forget('all_locations_list');
        Cache::forget('latest_book_ids_' . md5('|'));
    }

    /**
     * Show the locations management index.
     */
    public function lokasiIndex(Request $request)
    {
        $query = Location::withCount('items')->orderBy('name');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('limit', 10);
        if ($perPage === 'all') {
            $perPage = $query->count() ?: 10;
        } else {
            $perPage = is_numeric($perPage) ? (int)$perPage : 10;
        }

        $locations = $query->paginate($perPage)->withQueryString();

        return view('admin.lokasi.index', compact('locations'));
    }

    /**
     * Store a new location.
     */
    public function lokasiStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:tbllokasi,lokasi|max:255',
            'icon' => 'required|string|max:255',
        ], [
            'name.unique' => 'Nama lokasi sudah terdaftar.',
            'name.required' => 'Nama lokasi wajib diisi.',
        ]);

        try {
            Location::create([
                'lokasi' => $request->name,
                'icon' => $request->icon,
                'userinput' => auth()->user()->username ?? 'admin',
                'tglinput' => now(),
            ]);

            return redirect()->route('admin.lokasi.index')
                ->with('success', 'Lokasi baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Gagal menambahkan lokasi: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete a location.
     */
    public function lokasiDestroy($id)
    {
        try {
            $location = Location::withCount('items')->findOrFail($id);

            if ($location->items_count > 0) {
                return redirect()->back()
                    ->withErrors(['error' => 'Gagal menghapus lokasi: Lokasi ini sedang digunakan oleh ' . $location->items_count . ' eksemplar buku.']);
            }

            $location->delete();

            return redirect()->route('admin.lokasi.index')
                ->with('success', 'Lokasi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Gagal menghapus lokasi: ' . $e->getMessage()]);
        }
    }

    /**
     * Compress and convert image to AVIF format, keeping it under 150KB.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string Filename of the saved AVIF image
     */
    private function saveImageAsAvif($file)
    {
        $info = getimagesize($file->getRealPath());
        if (!$info) {
            throw new \Exception('Berkas yang diunggah bukan gambar valid.');
        }

        $mime = $info['mime'];
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($file->getRealPath());
                break;
            case 'image/png':
                $image = imagecreatefrompng($file->getRealPath());
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($file->getRealPath());
                break;
            case 'image/gif':
                $image = imagecreatefromgif($file->getRealPath());
                break;
            default:
                $image = imagecreatefromstring(file_get_contents($file->getRealPath()));
                break;
        }

        if (!$image) {
            // Jika GD tidak mendukung (misalnya gambar AVIF atau format lain)
            // maka simpan file aslinya saja tanpa konversi
            $extension = $file->getClientOriginalExtension() ?: 'img';
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $file->move(public_path('covers'), $filename);
            return $filename;
        }

        // Resize image if it exceeds 1200px width/height to save space
        $width = imagesx($image);
        $height = imagesy($image);
        $maxDimension = 1200;

        if ($width > $maxDimension || $height > $maxDimension) {
            if ($width > $height) {
                $newWidth = $maxDimension;
                $newHeight = (int)($height * ($maxDimension / $width));
            } else {
                $newHeight = $maxDimension;
                $newWidth = (int)($width * ($maxDimension / $height));
            }
            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
            
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            
            imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $resizedImage;
        }

        $coversDir = public_path('covers');
        if (!file_exists($coversDir)) {
            if (!@mkdir($coversDir, 0755, true) && !file_exists($coversDir)) {
                throw new \Exception("Folder covers ({$coversDir}) tidak ada dan tidak dapat dibuat otomatis oleh PHP. Mohon buat folder 'public/covers' di server.");
            }
        }

        if (!is_writable($coversDir)) {
            @chmod($coversDir, 0775);
            if (!is_writable($coversDir)) {
                throw new \Exception("Folder 'public/covers' di server tidak memiliki izin tulis (write permission). Jalankan 'chmod -R 775 public/covers' di server.");
            }
        }

        // Cek apakah server support fungsi imageavif
        $supportAvif = function_exists('imageavif');
        $extension = $supportAvif ? '.avif' : '.webp';

        // Save path
        $filename = time() . '_' . uniqid() . $extension;
        $destination = $coversDir . '/' . $filename;

        $savedSuccessfully = false;

        if ($supportAvif) {
            // Compress and save as AVIF with a single pass for better performance
            $savedSuccessfully = @imageavif($image, $destination, 50);
        }

        if (!$savedSuccessfully && function_exists('imagewebp')) {
            $filename = str_replace('.avif', '.webp', $filename);
            $destination = $coversDir . '/' . $filename;
            $savedSuccessfully = @imagewebp($image, $destination, 75);
        }

        if (!$savedSuccessfully && function_exists('imagejpeg')) {
            $filename = str_replace(['.avif', '.webp'], '.jpg', $filename);
            $destination = $coversDir . '/' . $filename;
            $savedSuccessfully = @imagejpeg($image, $destination, 80);
        }

        imagedestroy($image);

        // Fallback: if GD fails to write compressed format, directly move original file
        if (!$savedSuccessfully || !file_exists($destination) || filesize($destination) === 0) {
            $originalExt = $file->getClientOriginalExtension() ?: 'jpg';
            $filename = time() . '_' . uniqid() . '.' . $originalExt;
            $destination = $coversDir . '/' . $filename;
            $file->move($coversDir, $filename);
            if (!file_exists($destination)) {
                throw new \Exception("Gagal menyimpan file gambar cover ke {$destination}.");
            }
        }

        return $filename;
    }

    // =========================================================================
    // TAMBAH USER (hanya idgroup=3)
    // =========================================================================

    /**
     * Tampilkan form tambah user.
     * Hanya bisa diakses oleh user dengan idgroup = 3.
     */
    public function tambahUserIndex()
    {
        if (!auth()->check() || (int) auth()->user()->idgroup !== 3) {
            abort(403, 'Akses ditolak. Fitur ini hanya untuk Pengolahan / IT Admin (idgroup=3).');
        }

        return view('admin.tambah_user');
    }

    /**
     * Simpan user baru ke tbluser.
     * Otomatis dialokasikan ke idgroup 212 (Pustakawan Web) agar tidak bentrok dengan grup bawaan LIBAS Delphi.
     * Hanya bisa diakses oleh user dengan idgroup = 3.
     */
    public function tambahUserStore(\Illuminate\Http\Request $request)
    {
        if (!auth()->check() || (int) auth()->user()->idgroup !== 3) {
            abort(403, 'Akses ditolak. Fitur ini hanya untuk Pengolahan / IT Admin (idgroup=3).');
        }

        $validated = $request->validate([
            'username'     => 'required|string|max:50|unique:tbluser,username',
            'nama_lengkap' => 'required|string|max:100',
            'keterangan'   => 'nullable|string|max:200',
        ], [
            'username.required'     => 'Username wajib diisi.',
            'username.unique'       => 'Username sudah digunakan, pilih username lain.',
            'username.max'          => 'Username maksimal 50 karakter.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.max'      => 'Nama lengkap maksimal 100 karakter.',
            'keterangan.max'        => 'Keterangan maksimal 200 karakter.',
        ]);

        // Pastikan idgroup 212 terdaftar di tblgroup_user agar relasi tetap rapi dan tidak bentrok
        DB::table('tblgroup_user')->updateOrInsert(
            ['idgroup_user' => 212],
            [
                'nama_group'           => 'Pustakawan',
                'keterangan'           => 'Akun Pustakawan Web OPAC USU',
                'status_administrator' => 1,
                'userinput'            => auth()->user()->username ?? 'admin',
                'tgljaminput'          => now(),
            ]
        );

        // Password default: username + "123" (kompatibel format MD5 LIBAS Delphi)
        $defaultPassword = md5($validated['username'] . '123');

        DB::table('tbluser')->insert([
            'username'            => $validated['username'],
            'nama_lengkap'        => $validated['nama_lengkap'],
            'keterangan'          => $validated['keterangan'] ?? 'Pustakawan',
            'idgroup'             => 212, // Idgroup 212 khusus pustakawan baru, terisolasi dari group 1-15
            'password'            => $defaultPassword,
            'role'                => 'pustakawan',
            'status'              => 'Aktif',
            'status_administrator'=> 1,
            'iduser_input'        => auth()->user()->iduser,
            'tglinput'            => now(),
            'updated_at'          => now(),
            'email'               => null,
            'notelp'              => null,
        ]);

        return redirect()->route('admin.tambah-user')
            ->with('success', "User \"" . $validated['username'] . "\" berhasil ditambahkan (Kelompok Pustakawan idgroup 212)! Password default: " . $validated['username'] . "123 (tolong segera diganti).");
    }

    /**
     * Hapus user dari tbluser.
     * Hanya bisa diakses oleh user dengan idgroup = 3.
     */
    public function tambahUserDestroy($id)
    {
        if (!auth()->check() || (int) auth()->user()->idgroup !== 3) {
            abort(403, 'Akses ditolak. Fitur ini hanya untuk Pengolahan / IT Admin (idgroup=3).');
        }

        $currentUserId = auth()->user()->iduser;
        if ((int) $id === (int) $currentUserId) {
            return redirect()->back()->withErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri yang sedang digunakan.']);
        }

        $user = DB::table('tbluser')->where('iduser', $id)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'User tidak ditemukan.']);
        }

        DB::table('tbluser')->where('iduser', $id)->delete();

        return redirect()->route('admin.tambah-user')
            ->with('success', "User \"" . ($user->username ?? $user->nama_lengkap) . "\" berhasil dihapus dari sistem.");
    }

    /**
     * Tampilkan form ganti password untuk user yang sedang login.
     */
    public function gantiPasswordIndex()
    {
        return view('admin.ganti_password');
    }

    /**
     * Proses ubah password user yang sedang login.
     */
    public function gantiPasswordUpdate(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password'         => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required'         => 'Password baru wajib diisi.',
            'password.min'              => 'Password baru minimal 6 karakter.',
            'password.confirmed'        => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = auth()->user();
        $storedPassword = $user->getAttributes()['password'] ?? '';
        $currentInput = $request->current_password;

        // Validasi password lama (hybrid Bcrypt / MD5 LIBAS Delphi / SHA1 / plaintext)
        $valid = false;
        if (str_starts_with($storedPassword, '$2y$') || str_starts_with($storedPassword, '$2a$') || str_starts_with($storedPassword, '$2b$')) {
            $valid = \Illuminate\Support\Facades\Hash::check($currentInput, $storedPassword);
        } elseif (hash_equals(strtolower($storedPassword), md5($currentInput))) {
            $valid = true;
        } elseif (hash_equals(strtolower($storedPassword), sha1($currentInput))) {
            $valid = true;
        } elseif ($storedPassword === $currentInput) {
            $valid = true;
        }

        if (!$valid) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Password saat ini yang Anda masukkan salah.']);
        }

        // Simpan password baru menggunakan MD5 agar tetap kompatibel dengan aplikasi desktop LIBAS Delphi kampus
        $newHashed = md5($request->password);

        DB::table('tbluser')
            ->where('iduser', $user->iduser)
            ->update([
                'password'   => $newHashed,
                'updated_at' => now(),
            ]);

        // Logout dan redirect ke halaman login agar sesi bersih dengan password baru
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Password Anda berhasil diperbarui! Silakan login kembali menggunakan password baru Anda.');
    }

    // =========================================================================
    // PERKEMBANGAN (hanya idgroup=3)
    // =========================================================================

    /**
     * Tampilkan statistik perkembangan (cover & ringkasan).
     * Jika idgroup = 3: melihat perkembangan semua pustakawan (Supervisor Dashboard).
     * Jika idgroup != 3: hanya melihat perkembangannya sendiri (Personal Dashboard).
     */
    public function perkembangan()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $currentUser = auth()->user();
        $isSupervisor = ((int) $currentUser->idgroup === 3);

        // =====================================================================
        // VIEW PERSONAL (idgroup != 3) - Hanya bisa melihat perkembangannya sendiri
        // =====================================================================
        if (!$isSupervisor) {
            $myUsername    = $currentUser->username;
            $myNamaLengkap = $currentUser->nama_lengkap;
            $myIdUser      = $currentUser->iduser;

            // Total Cover pribadi
            $myTotalCover = DB::table('tblbuku')
                ->join('galeri_buku', function($join) {
                    $join->on('galeri_buku.book_id', '=', 'tblbuku.idmaster')
                         ->where('galeri_buku.is_cover', '=', 1)
                         ->whereNotNull('galeri_buku.image_path')
                         ->where('galeri_buku.image_path', '!=', '');
                })
                ->where(function($q) use ($myIdUser, $myUsername, $myNamaLengkap) {
                    $q->where('tblbuku.iduser', $myIdUser)
                      ->orWhere('tblbuku.userinput', $myUsername);
                    if (!empty($myNamaLengkap)) {
                        $q->orWhere('tblbuku.userinput', $myNamaLengkap);
                    }
                })
                ->count();

            // Total Ringkasan pribadi
            $myTotalRingkasan = DB::table('tblbuku')
                ->whereNotNull('tblbuku.ringkasanbuku')
                ->where('tblbuku.ringkasanbuku', '!=', '')
                ->where(function($q) use ($myIdUser, $myUsername, $myNamaLengkap) {
                    $q->where('tblbuku.iduser', $myIdUser)
                      ->orWhere('tblbuku.userinput', $myUsername);
                    if (!empty($myNamaLengkap)) {
                        $q->orWhere('tblbuku.userinput', $myNamaLengkap);
                    }
                })
                ->count();

            // Riwayat Bulanan Pribadi
            $namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            $coverBulanan = DB::table('tblbuku')
                ->join('galeri_buku', function($join) {
                    $join->on('galeri_buku.book_id', '=', 'tblbuku.idmaster')
                         ->where('galeri_buku.is_cover', '=', 1)
                         ->whereNotNull('galeri_buku.image_path')
                         ->where('galeri_buku.image_path', '!=', '');
                })
                ->where(function($q) use ($myIdUser, $myUsername, $myNamaLengkap) {
                    $q->where('tblbuku.iduser', $myIdUser)
                      ->orWhere('tblbuku.userinput', $myUsername);
                    if (!empty($myNamaLengkap)) {
                        $q->orWhere('tblbuku.userinput', $myNamaLengkap);
                    }
                })
                ->whereNotNull('galeri_buku.created_at')
                ->select(
                    DB::raw('YEAR(galeri_buku.created_at) as tahun'),
                    DB::raw('MONTH(galeri_buku.created_at) as bulan'),
                    DB::raw('COUNT(DISTINCT tblbuku.idmaster) as jumlah_cover')
                )
                ->groupBy(DB::raw('YEAR(galeri_buku.created_at)'), DB::raw('MONTH(galeri_buku.created_at)'))
                ->get();

            $ringkasanBulanan = DB::table('tblbuku')
                ->whereNotNull('tblbuku.ringkasanbuku')
                ->where('tblbuku.ringkasanbuku', '!=', '')
                ->where(function($q) use ($myIdUser, $myUsername, $myNamaLengkap) {
                    $q->where('tblbuku.iduser', $myIdUser)
                      ->orWhere('tblbuku.userinput', $myUsername);
                    if (!empty($myNamaLengkap)) {
                        $q->orWhere('tblbuku.userinput', $myNamaLengkap);
                    }
                })
                ->whereNotNull(DB::raw('COALESCE(tblbuku.tgledit, tblbuku.tglinput)'))
                ->select(
                    DB::raw('YEAR(COALESCE(tblbuku.tgledit, tblbuku.tglinput)) as tahun'),
                    DB::raw('MONTH(COALESCE(tblbuku.tgledit, tblbuku.tglinput)) as bulan'),
                    DB::raw('COUNT(tblbuku.idmaster) as jumlah_ringkasan')
                )
                ->groupBy(DB::raw('YEAR(COALESCE(tblbuku.tgledit, tblbuku.tglinput))'), DB::raw('MONTH(COALESCE(tblbuku.tgledit, tblbuku.tglinput))'))
                ->get();

            $monthlyMap = [];
            foreach ($coverBulanan as $c) {
                $k = sprintf('%04d-%02d', $c->tahun, $c->bulan);
                $monthlyMap[$k] = [
                    'label'     => $namaBulan[$c->bulan] . ' ' . $c->tahun,
                    'cover'     => (int) $c->jumlah_cover,
                    'ringkasan' => 0,
                ];
            }
            foreach ($ringkasanBulanan as $r) {
                $k = sprintf('%04d-%02d', $r->tahun, $r->bulan);
                if (!isset($monthlyMap[$k])) {
                    $monthlyMap[$k] = [
                        'label'     => $namaBulan[$r->bulan] . ' ' . $r->tahun,
                        'cover'     => 0,
                        'ringkasan' => (int) $r->jumlah_ringkasan,
                    ];
                } else {
                    $monthlyMap[$k]['ringkasan'] = (int) $r->jumlah_ringkasan;
                }
            }
            ksort($monthlyMap);
            $chartMonths    = array_values(array_column($monthlyMap, 'label'));
            $chartCovers    = array_values(array_column($monthlyMap, 'cover'));
            $chartRingkasan = array_values(array_column($monthlyMap, 'ringkasan'));

            // Buku-buku yang dikontribusikan oleh user ini (terbaru, limit 50)
            $recentBooks = DB::table('tblbuku')
                ->leftJoin('galeri_buku', function($join) {
                    $join->on('galeri_buku.book_id', '=', 'tblbuku.idmaster')
                         ->where('galeri_buku.is_cover', '=', 1);
                })
                ->where(function($q) use ($myIdUser, $myUsername, $myNamaLengkap) {
                    $q->where('tblbuku.iduser', $myIdUser)
                      ->orWhere('tblbuku.userinput', $myUsername);
                    if (!empty($myNamaLengkap)) {
                        $q->orWhere('tblbuku.userinput', $myNamaLengkap);
                    }
                })
                ->select(
                    'tblbuku.idmaster',
                    'tblbuku.judul_buku',
                    'tblbuku.nopanggil',
                    'tblbuku.ringkasanbuku',
                    DB::raw('COALESCE(tblbuku.tgledit, tblbuku.tglinput) as tgl_aktivitas'),
                    'galeri_buku.image_path as cover_image'
                )
                ->orderByDesc(DB::raw('COALESCE(tblbuku.tgledit, tblbuku.tglinput)'))
                ->limit(50)
                ->get();

            return view('admin.perkembangan_personal', compact(
                'currentUser',
                'myTotalCover',
                'myTotalRingkasan',
                'monthlyMap',
                'chartMonths',
                'chartCovers',
                'chartRingkasan',
                'recentBooks'
            ));
        }

        // =====================================================================
        // VIEW SUPERVISOR (idgroup = 3) - Melihat semua perkembangan pustakawan
        // =====================================================================

        // ---- Ambil SEMUA user dengan role pustakawan sebagai basis ----
        $semuaUser = DB::table('tbluser')
            ->where('role', 'pustakawan')
            ->select('iduser', 'username', 'nama_lengkap', 'keterangan')
            ->orderBy('username')
            ->get();

        // ---- Statistik Cover per User (berdasarkan username di tblbuku) ----
        $coverStats = DB::table('tblbuku')
            ->join('galeri_buku', function($join) {
                $join->on('galeri_buku.book_id', '=', 'tblbuku.idmaster')
                     ->where('galeri_buku.is_cover', '=', 1)
                     ->whereNotNull('galeri_buku.image_path')
                     ->where('galeri_buku.image_path', '!=', '');
            })
            ->whereNotNull('tblbuku.userinput')
            ->where('tblbuku.userinput', '!=', '')
            ->select(
                DB::raw('tblbuku.userinput as username'),
                DB::raw('COUNT(DISTINCT tblbuku.idmaster) as jumlah_cover')
            )
            ->groupBy('tblbuku.userinput')
            ->get()
            ->keyBy('username');

        // ---- Statistik Ringkasan per User ----
        $ringkasanStats = DB::table('tblbuku')
            ->whereNotNull('tblbuku.ringkasanbuku')
            ->where('tblbuku.ringkasanbuku', '!=', '')
            ->whereNotNull('tblbuku.userinput')
            ->where('tblbuku.userinput', '!=', '')
            ->select(
                DB::raw('tblbuku.userinput as username'),
                DB::raw('COUNT(tblbuku.idmaster) as jumlah_ringkasan')
            )
            ->groupBy('tblbuku.userinput')
            ->get()
            ->keyBy('username');

        // ---- Gabungkan: semua user + kontribusi mereka (0 jika belum ada) ----
        $mergedMap = [];

        foreach ($semuaUser as $u) {
            $cover = 0;
            if (isset($coverStats[$u->username])) {
                $cover += (int) $coverStats[$u->username]->jumlah_cover;
            } elseif ($u->nama_lengkap && isset($coverStats[$u->nama_lengkap])) {
                $cover += (int) $coverStats[$u->nama_lengkap]->jumlah_cover;
            }

            $ringkasan = 0;
            if (isset($ringkasanStats[$u->username])) {
                $ringkasan += (int) $ringkasanStats[$u->username]->jumlah_ringkasan;
            } elseif ($u->nama_lengkap && isset($ringkasanStats[$u->nama_lengkap])) {
                $ringkasan += (int) $ringkasanStats[$u->nama_lengkap]->jumlah_ringkasan;
            }

            $mergedMap[] = [
                'iduser'           => $u->iduser,
                'username'         => $u->username,
                'nama_lengkap'     => $u->nama_lengkap,
                'keterangan'       => $u->keterangan,
                'jumlah_cover'     => $cover,
                'jumlah_ringkasan' => $ringkasan,
            ];
        }

        // Sort by total (cover+ringkasan) descending
        usort($mergedMap, function($a, $b) {
            return ($b['jumlah_cover'] + $b['jumlah_ringkasan']) <=> ($a['jumlah_cover'] + $a['jumlah_ringkasan']);
        });

        $stats = collect($mergedMap);

        // Data untuk grafik: top 10 user yang sudah berkontribusi (cover+ringkasan > 0)
        $statsForChart  = $stats->filter(fn($u) => ($u['jumlah_cover'] + $u['jumlah_ringkasan']) > 0)->take(10);
        $chartLabels    = $statsForChart->pluck('username')->values()->toArray();
        $chartCovers    = $statsForChart->pluck('jumlah_cover')->values()->toArray();
        $chartRingkasan = $statsForChart->pluck('jumlah_ringkasan')->values()->toArray();

        // ---- Data Bulanan untuk PDF ----
        // Ringkasan per bulan per user
        $ringkasanBulanan = DB::table('tblbuku')
            ->leftJoin('tbluser', 'tblbuku.iduser', '=', 'tbluser.iduser')
            ->whereNotNull('tblbuku.ringkasanbuku')
            ->where('tblbuku.ringkasanbuku', '!=', '')
            ->whereNotNull('tblbuku.userinput')
            ->where('tblbuku.userinput', '!=', '')
            ->whereNotNull(DB::raw('COALESCE(tblbuku.tgledit, tblbuku.tglinput)'))
            ->select(
                DB::raw('YEAR(COALESCE(tblbuku.tgledit, tblbuku.tglinput)) as tahun'),
                DB::raw('MONTH(COALESCE(tblbuku.tgledit, tblbuku.tglinput)) as bulan'),
                DB::raw('tblbuku.userinput as username'),
                DB::raw('COALESCE(tbluser.nama_lengkap, tblbuku.userinput) as nama_lengkap'),
                DB::raw('COALESCE(tbluser.keterangan, \'\') as keterangan'),
                DB::raw('COUNT(tblbuku.idmaster) as jumlah_ringkasan')
            )
            ->groupBy(
                DB::raw('YEAR(COALESCE(tblbuku.tgledit, tblbuku.tglinput))'),
                DB::raw('MONTH(COALESCE(tblbuku.tgledit, tblbuku.tglinput))'),
                'tblbuku.userinput',
                DB::raw('COALESCE(tbluser.nama_lengkap, tblbuku.userinput)'),
                DB::raw('COALESCE(tbluser.keterangan, \'\')')
            )
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        // Cover per bulan per user (via galeri_buku.created_at)
        $coverBulanan = DB::table('tblbuku')
            ->leftJoin('tbluser', 'tblbuku.iduser', '=', 'tbluser.iduser')
            ->join('galeri_buku', function($join) {
                $join->on('galeri_buku.book_id', '=', 'tblbuku.idmaster')
                     ->where('galeri_buku.is_cover', '=', 1)
                     ->whereNotNull('galeri_buku.image_path')
                     ->where('galeri_buku.image_path', '!=', '');
            })
            ->whereNotNull('tblbuku.userinput')
            ->where('tblbuku.userinput', '!=', '')
            ->whereNotNull('galeri_buku.created_at')
            ->select(
                DB::raw('YEAR(galeri_buku.created_at) as tahun'),
                DB::raw('MONTH(galeri_buku.created_at) as bulan'),
                DB::raw('tblbuku.userinput as username'),
                DB::raw('COALESCE(tbluser.nama_lengkap, tblbuku.userinput) as nama_lengkap'),
                DB::raw('COALESCE(tbluser.keterangan, \'\') as keterangan'),
                DB::raw('COUNT(DISTINCT tblbuku.idmaster) as jumlah_cover')
            )
            ->groupBy(
                DB::raw('YEAR(galeri_buku.created_at)'),
                DB::raw('MONTH(galeri_buku.created_at)'),
                'tblbuku.userinput',
                DB::raw('COALESCE(tbluser.nama_lengkap, tblbuku.userinput)'),
                DB::raw('COALESCE(tbluser.keterangan, \'\')')
            )
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        // Gabungkan data bulanan ke satu struktur: ['YYYY-MM' => ['label' => '...', 'users' => [...]]]
        $monthlyData = [];
        $namaBulan   = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        foreach ($ringkasanBulanan as $r) {
            $key = sprintf('%04d-%02d', $r->tahun, $r->bulan);
            if (!isset($monthlyData[$key])) {
                $monthlyData[$key] = [
                    'label' => $namaBulan[$r->bulan] . ' ' . $r->tahun,
                    'users' => [],
                ];
            }
            $monthlyData[$key]['users'][$r->username] = [
                'username'        => $r->username,
                'nama_lengkap'    => $r->nama_lengkap,
                'keterangan'      => $r->keterangan,
                'jumlah_ringkasan'=> (int) $r->jumlah_ringkasan,
                'jumlah_cover'    => 0,
            ];
        }

        foreach ($coverBulanan as $c) {
            $key = sprintf('%04d-%02d', $c->tahun, $c->bulan);
            if (!isset($monthlyData[$key])) {
                $monthlyData[$key] = [
                    'label' => $namaBulan[$c->bulan] . ' ' . $c->tahun,
                    'users' => [],
                ];
            }
            if (isset($monthlyData[$key]['users'][$c->username])) {
                $monthlyData[$key]['users'][$c->username]['jumlah_cover'] = (int) $c->jumlah_cover;
                if (empty($monthlyData[$key]['users'][$c->username]['keterangan']) && !empty($c->keterangan)) {
                    $monthlyData[$key]['users'][$c->username]['keterangan'] = $c->keterangan;
                }
            } else {
                $monthlyData[$key]['users'][$c->username] = [
                    'username'        => $c->username,
                    'nama_lengkap'    => $c->nama_lengkap,
                    'keterangan'      => $c->keterangan,
                    'jumlah_ringkasan'=> 0,
                    'jumlah_cover'    => (int) $c->jumlah_cover,
                ];
            }
        }

        // Urutkan data user per bulan berdasarkan total kontribusi DESC
        foreach ($monthlyData as $key => &$m) {
            $userList = array_values($m['users']);
            usort($userList, function($a, $b) {
                return ($b['jumlah_cover'] + $b['jumlah_ringkasan']) <=> ($a['jumlah_cover'] + $a['jumlah_ringkasan']);
            });
            $m['users'] = $userList;
            $m['total_cover'] = array_sum(array_column($userList, 'jumlah_cover'));
            $m['total_ringkasan'] = array_sum(array_column($userList, 'jumlah_ringkasan'));
        }
        unset($m);

        // Sort descending by year-month
        krsort($monthlyData);

        $totalUserTerdaftar = $semuaUser->count();

        return view('admin.perkembangan', compact(
            'stats', 'chartLabels', 'chartCovers', 'chartRingkasan', 'monthlyData', 'totalUserTerdaftar'
        ));
    }
}
