<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Location;
use App\Models\University;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display the landing page (welcome).
     */
    public function index()
    {
        // Get the main university (USU)
        $university = University::where('code', 'usu')->first();

        // Get locations with count of items
        $locations = Location::withCount('items')->get();

        // Get 20 latest books
        $latestBooks = Book::latest()->take(20)->get();

        return view('welcome', compact('university', 'locations', 'latestBooks'));
    }

    /**
     * Display search results.
     */
    public function search(Request $request)
    {
        $query = Book::query();

        // 1. Simple search bar
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('title', 'like', "%{$q}%")
                  ->orWhere('author', 'like', "%{$q}%")
                  ->orWhere('publisher', 'like', "%{$q}%")
                  ->orWhere('subject', 'like', "%{$q}%")
                  ->orWhere('isbn', 'like', "%{$q}%")
                  ->orWhere('classification', 'like', "%{$q}%");
            });
        }

        // 1.5 Starts with (Index Judul)
        if ($request->filled('starts_with')) {
            $query->where('title', 'like', $request->starts_with . '%');
        }

        // 2. Specific search modal parameters
        if ($request->filled('inJudul')) {
            $query->where('title', 'like', "%{$request->inJudul}%");
        }
        if ($request->filled('inPengarang1')) {
            $query->where('author', 'like', "%{$request->inPengarang1}%");
        }
        if ($request->filled('inPenerbit')) {
            $query->where('publisher', 'like', "%{$request->inPenerbit}%");
        }
        if ($request->filled('inSubyek')) {
            $query->where('subject', 'like', "%{$request->inSubyek}%");
        }
        if ($request->filled('intahunterbit')) {
            $query->where('publish_year', $request->intahunterbit);
        }
        if ($request->filled('inisbn')) {
            $query->where('isbn', 'like', "%{$request->inisbn}%");
        }
        if ($request->filled('inKlasifikasi')) {
            $query->where('classification', 'like', "%{$request->inKlasifikasi}%");
        }
        if ($request->filled('inJenis')) {
            $query->where('type', $request->inJenis);
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
}
