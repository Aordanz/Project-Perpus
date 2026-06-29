<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Location;
use App\Models\Item;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(function ($request, $next) {
                if (!auth()->check() || auth()->user()->role !== 'pustakawan') {
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
        $availableItems = Item::where('status', 'Tersedia')->count();
        $borrowedItems = $totalItems - $availableItems;

        return view('admin.index', compact(
            'totalBooks',
            'totalItems',
            'availableItems',
            'borrowedItems'
        ));
    }

    /**
     * Show the admin book collection page.
     */
    public function koleksiBuku(Request $request)
    {
        // Query books with search
        $query = Book::with(['items.location'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('limit', 10);
        if ($perPage === 'all') {
            $perPage = $query->count() ?: 10;
        } else {
            $perPage = is_numeric($perPage) ? (int)$perPage : 10;
        }

        $books = $query->paginate($perPage)->withQueryString();

        // Get locations for the copies form dropdown
        $locations = Location::all();

        if ($request->ajax()) {
            return view('admin.partials.books_table', compact('books'));
        }

        return view('admin.koleksi_buku', compact('books', 'locations'));
    }

    public function galeri(Request $request)
    {
        $query = Book::with(['items'])->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
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
            'images'               => 'nullable|array|max:15',
            'images.*'             => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            // Validation for dynamic items
            'items.*.barcode'     => 'required|string|unique:items,barcode|max:255',
            'items.*.location_id' => 'required|exists:locations,id',
            'items.*.type'        => 'required|string|in:STD,KPS',
        ], [
            'items.*.barcode.unique'      => 'Barcode :input sudah digunakan oleh buku lain.',
            'items.*.barcode.required'    => 'Barcode wajib diisi.',
            'items.*.location_id.required'=> 'Lokasi rak wajib dipilih.',
            'items.*.type.required'       => 'Tipe eksemplar wajib dipilih.',
            'images.max'                  => 'Maksimal 15 gambar yang dapat diunggah sekaligus.'
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

            // Handle multiple image file upload
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                
                // First image is the main cover
                $mainImage = $images[0];
                $mainName  = time() . '_0_' . preg_replace('/\s+/', '_', $mainImage->getClientOriginalName());
                $mainImage->move(public_path('covers'), $mainName);
                $bookData['cover_image'] = $mainName;

                // Save the book
                $book = Book::create($bookData);

                // Save the rest as additional images
                for ($i = 1; $i < count($images); $i++) {
                    $img = $images[$i];
                    $imgName = time() . '_' . $i . '_' . preg_replace('/\s+/', '_', $img->getClientOriginalName());
                    $img->move(public_path('covers'), $imgName);
                    
                    $book->images()->create([
                        'image_path' => $imgName,
                    ]);
                }
            } else {
                // Save the book without cover
                $book = Book::create($bookData);
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
        $book      = Book::with(['items.location', 'images'])->findOrFail($id);
        $locations = Location::all();

        return view('admin.edit', compact('book', 'locations'));
    }

    /**
     * Update the specified book in the database.
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

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
            'cover_image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'delete_cover'         => 'nullable|boolean',
            'pdf_file'             => 'nullable|file|mimes:pdf|max:20480',
            'delete_pdf'           => 'nullable|boolean',
            'additional_images.*'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'delete_additional_images.*' => 'nullable|integer|exists:book_images,id',

            // Existing items update
            'items.*.barcode'      => 'required|string|max:255',
            'items.*.location_id'  => 'required|exists:locations,id',
            'items.*.type'         => 'required|string|in:STD,KPS',

            // New items to add
            'new_items.*.barcode'      => 'nullable|string|unique:items,barcode|max:255',
            'new_items.*.location_id'  => 'nullable|exists:locations,id',
            'new_items.*.type'         => 'nullable|string|in:STD,KPS',
        ]);

        try {
            DB::beginTransaction();

            $bookData = $request->only([
                'title', 'author', 'publisher', 'publication_city', 'edition',
                'publish_year', 'isbn', 'physical_description', 'classification',
                'golongan', 'subject', 'language', 'jenis', 'category', 'general_note', 'call_number'
            ]);

            if (!$request->filled('category')) {
                $bookData['category'] = 'Umum';
            }

            // Handle deleting the cover image
            if ($request->boolean('delete_cover')) {
                if ($book->cover_image && file_exists(public_path('covers/' . $book->cover_image))) {
                    @unlink(public_path('covers/' . $book->cover_image));
                }
                $bookData['cover_image'] = null;
            }

            // Handle cover image upload (replace old one)
            if ($request->hasFile('cover_image')) {
                // Delete old cover
                if ($book->cover_image && file_exists(public_path('covers/' . $book->cover_image))) {
                    @unlink(public_path('covers/' . $book->cover_image));
                }
                $image = $request->file('cover_image');
                $name  = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
                $image->move(public_path('covers'), $name);
                $bookData['cover_image'] = $name;
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
                    Item::where('barcode', (string) $barcode)->update($updateData);
                }
            }

            // Delete items marked for removal
            if ($request->has('delete_items')) {
                Item::whereIn('barcode', $request->delete_items)->delete();
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

            // Delete selected additional images
            if ($request->has('delete_additional_images')) {
                $imagesToDelete = \App\Models\BookImage::whereIn('id', $request->delete_additional_images)->get();
                foreach ($imagesToDelete as $img) {
                    if (file_exists(public_path('covers/' . $img->image_path))) {
                        @unlink(public_path('covers/' . $img->image_path));
                    }
                    $img->delete();
                }
            }

            // Upload new additional images (only if book has a cover or a new cover is uploaded)
            if ($request->hasFile('additional_images')) {
                $hasCover = ($book->cover_image && !$request->boolean('delete_cover')) || $request->hasFile('cover_image');
                if (!$hasCover) {
                    throw new \Exception('Unggah sampul default terlebih dahulu sebelum menambahkan gambar tambahan.');
                }
                foreach ($request->file('additional_images') as $file) {
                    $name = time() . '_' . uniqid() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                    $file->move(public_path('covers'), $name);
                    $book->images()->create([
                        'image_path' => $name,
                     ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.index')
                ->with('success', 'Buku "' . $book->title . '" berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memperbarui buku: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete a book and its physical copies.
     */
    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);

            // Delete the cover image file if it exists
            if ($book->cover_image && file_exists(public_path('covers/' . $book->cover_image))) {
                @unlink(public_path('covers/' . $book->cover_image));
            }

            // Delete the PDF file if it exists
            if ($book->pdf_file && file_exists(public_path('ebooks/' . $book->pdf_file))) {
                @unlink(public_path('ebooks/' . $book->pdf_file));
            }

            $book->delete(); // cascades to items via migration constraint

            return redirect()->route('admin.index')
                ->with('success', 'Buku dan semua eksemplarnya berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Gagal menghapus buku: ' . $e->getMessage()]);
        }
    }
}
