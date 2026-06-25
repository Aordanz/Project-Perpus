<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Location;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard and book list.
     */
    public function index(Request $request)
    {
        // 1. Calculate dashboard statistics
        $totalBooks = Book::count();
        $totalItems = Item::count();
        $availableItems = Item::where('status', 'Tersedia')->count();
        $borrowedItems = $totalItems - $availableItems;

        // 2. Query books with search
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

        $books = $query->paginate(10)->withQueryString();

        // 3. Get locations for the copies form dropdown
        $locations = Location::all();

        return view('admin.index', compact(
            'totalBooks',
            'totalItems',
            'availableItems',
            'borrowedItems',
            'books',
            'locations'
        ));
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
            'type'                 => 'nullable|string|max:255',
            'general_note'         => 'nullable|string',
            'cover_image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            // Validation for dynamic items
            'items.*.barcode'     => 'required|string|unique:items,barcode|max:255',
            'items.*.location_id' => 'required|exists:locations,id',
            'items.*.status'      => 'required|string|in:Tersedia,Dipinjam',
        ], [
            'items.*.barcode.unique'      => 'Barcode :input sudah digunakan oleh buku lain.',
            'items.*.barcode.required'    => 'Barcode wajib diisi.',
            'items.*.location_id.required'=> 'Lokasi rak wajib dipilih.',
        ]);

        try {
            DB::beginTransaction();

            $bookData = $request->only([
                'title', 'author', 'publisher', 'publication_city', 'edition',
                'publish_year', 'isbn', 'physical_description', 'classification',
                'golongan', 'subject', 'language', 'type', 'general_note'
            ]);

            // Build call number from classification + author + title if not provided
            $bookData['call_number'] = $request->input('call_number')
                ?: (trim($request->input('classification') . ' ' . substr($request->input('author'), 0, 3) . ' ' . strtolower(substr($request->input('title'), 0, 1))));

            // Set category to subject value for search consistency
            $bookData['category'] = $request->input('subject') ?: 'Umum';

            // Handle cover image file upload
            if ($request->hasFile('cover_image')) {
                $image = $request->file('cover_image');
                $name  = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
                $image->move(public_path('covers'), $name);
                $bookData['cover_image'] = $name;
            }

            // Save the book
            $book = Book::create($bookData);

            // Add copies/items if provided
            if ($request->has('items')) {
                foreach ($request->items as $itemData) {
                    Item::create([
                        'barcode'     => $itemData['barcode'],
                        'book_id'     => $book->id,
                        'location_id' => $itemData['location_id'],
                        'call_number' => $book->call_number,
                        'status'      => $itemData['status'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.index')
                ->with('success', 'Buku "' . $book->title . '" dan salinannya berhasil ditambahkan ke database.');
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
        $book      = Book::with(['items.location'])->findOrFail($id);
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
            'type'                 => 'nullable|string|max:255',
            'general_note'         => 'nullable|string',
            'cover_image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            // Existing items update
            'items.*.barcode'      => 'required|string|max:255',
            'items.*.location_id'  => 'required|exists:locations,id',
            'items.*.status'       => 'required|string|in:Tersedia,Dipinjam',

            // New items to add
            'new_items.*.barcode'      => 'nullable|string|unique:items,barcode|max:255',
            'new_items.*.location_id'  => 'nullable|exists:locations,id',
            'new_items.*.status'       => 'nullable|string|in:Tersedia,Dipinjam',
        ]);

        try {
            DB::beginTransaction();

            $bookData = $request->only([
                'title', 'author', 'publisher', 'publication_city', 'edition',
                'publish_year', 'isbn', 'physical_description', 'classification',
                'golongan', 'subject', 'language', 'type', 'general_note', 'call_number'
            ]);

            $bookData['category'] = $request->input('subject') ?: 'Umum';

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

            $book->update($bookData);

            // Update existing items
            if ($request->has('items')) {
                foreach ($request->items as $barcode => $itemData) {
                    Item::where('barcode', $barcode)->update([
                        'location_id' => $itemData['location_id'],
                        'status'      => $itemData['status'],
                    ]);
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
                            'status'      => $newItem['status'] ?? 'Tersedia',
                        ]);
                    }
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

            $book->delete(); // cascades to items via migration constraint

            return redirect()->route('admin.index')
                ->with('success', 'Buku dan semua eksemplarnya berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Gagal menghapus buku: ' . $e->getMessage()]);
        }
    }
}
