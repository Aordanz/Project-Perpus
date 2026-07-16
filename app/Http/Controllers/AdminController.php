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
        $availableItems = Item::where('kodestatus_eksemplar', 'TSD')->count();
        $borrowedItems = Item::where('kodestatus_eksemplar', 'PJM')->count();
        
        $totalBooksWithCover = Book::whereNotNull('cover_image')->count();
        $totalBooksWithoutCover = Book::whereNull('cover_image')->count();

        // Calculate stats for each Faculty
        $facultyStats = \Illuminate\Support\Facades\DB::table('tbllokasi')
            ->join('tbleksemplar', 'tbllokasi.idlokasi', '=', 'tbleksemplar.kodelokasi')
            ->join('tblbuku', 'tbleksemplar.idmaster', '=', 'tblbuku.idmaster')
            ->where('tbllokasi.lokasi', 'LIKE', 'Fakultas%')
            ->select(
                'tbllokasi.lokasi as faculty_name',
                \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT tblbuku.idbuku) as total_books'),
                \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT CASE WHEN tblbuku.cover_image IS NOT NULL THEN tblbuku.idbuku END) as with_cover'),
                \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT CASE WHEN tblbuku.cover_image IS NULL THEN tblbuku.idbuku END) as without_cover')
            )
            ->groupBy('tbllokasi.idlokasi', 'tbllokasi.lokasi')
            ->orderBy('tbllokasi.lokasi')
            ->get();

        return view('admin.index', compact(
            'totalBooks',
            'totalItems',
            'availableItems',
            'borrowedItems',
            'totalBooksWithCover',
            'totalBooksWithoutCover',
            'facultyStats'
        ));
    }

    /**
     * Show the admin 'Tambah Cover' page.
     */
    public function tambahCoverIndex(Request $request)
    {
        // Query books with search
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
                    $q->whereNull('cover_image')->orWhere('cover_image', '');
                });
            } elseif ($filter === 'has_cover') {
                $query->whereNotNull('cover_image')->where('cover_image', '!=', '');
            }
        }

        if ($request->filled('location_filter') && $request->location_filter !== 'all') {
            $locFilter = $request->location_filter;
            $query->whereHas('items', function ($itemQuery) use ($locFilter) {
                $itemQuery->where('kodelokasi', $locFilter);
            });
        }

        $perPage = $request->input('limit', 10);
        if ($perPage === 'all') {
            $perPage = 500;
        } else {
            $perPage = is_numeric($perPage) ? min(500, (int)$perPage) : 10;
        }

        $books = $query->paginate($perPage)->withQueryString();
        $locations = Location::orderBy('lokasi', 'asc')->get();

        if ($request->ajax()) {
            return view('admin.partials.books_table', compact('books'));
        }

        return view('admin.tambah_cover', compact('books', 'locations'));
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
            'images.*'             => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480',

            // Validation for dynamic items
            'items.*.barcode'     => 'required|string|unique:tbleksemplar,nomor_eksemplar|max:255',
            'items.*.location_id' => 'required|exists:locations,id',
            'items.*.type'        => 'required|string|in:STD,KPS',
        ], [
            'items.*.barcode.unique'      => 'Barcode :input sudah digunakan oleh buku lain.',
            'items.*.barcode.required'    => 'Barcode wajib diisi.',
            'items.*.location_id.required'=> 'Lokasi rak wajib dipilih.',
            'items.*.type.required'       => 'Tipe eksemplar wajib dipilih.',
            'images.max'                  => 'Maksimal 4 gambar (1 utama & 3 tambahan) yang dapat diunggah sekaligus.',
            'images.*.max'                => 'Ukuran setiap gambar tidak boleh melebihi 20 MB.',
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
                $mainName = $this->saveImageAsAvif($mainImage);
                $bookData['cover_image'] = $mainName;

                // Save the book
                $book = Book::create($bookData);

                // Save the rest as additional images
                for ($i = 1; $i < count($images); $i++) {
                    $img = $images[$i];
                    $imgName = $this->saveImageAsAvif($img);
                    
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
            'cover_image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
            'delete_cover'         => 'nullable|boolean',
            'pdf_file'             => 'nullable|file|mimes:pdf|max:20480',
            'delete_pdf'           => 'nullable|boolean',
            'additional_images.*'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
            'delete_additional_images.*' => 'nullable|integer|exists:galeri_buku,id',
            'image_order_json'     => 'nullable|string',
            'new_files.*'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
 
            // Existing items update
            'items.*.barcode'      => 'required|string|max:255',
            'items.*.location_id'  => 'required|exists:locations,id',
            'items.*.type'         => 'required|string|in:STD,KPS',
 
            // New items to add
            'new_items.*.barcode'      => 'nullable|string|unique:tbleksemplar,nomor_eksemplar|max:255',
            'new_items.*.location_id'  => 'nullable|exists:locations,id',
            'new_items.*.type'         => 'nullable|string|in:STD,KPS',
        ], [
            'cover_image.max' => 'Ukuran sampul buku tidak boleh melebihi 20 MB.',
            'additional_images.*.max' => 'Ukuran setiap gambar tambahan tidak boleh melebihi 20 MB.',
            'new_files.*.max' => 'Ukuran file gambar baru tidak boleh melebihi 20 MB.',
        ]);

        try {
            DB::beginTransaction();

            // Calculate and validate final additional images count (limit to 3)
            $existingImagesCount = \App\Models\BookImage::where('book_id', $book->id)->count();
            $deletedImagesCount = $request->has('delete_additional_images') ? count($request->delete_additional_images) : 0;
            $newImagesCount = $request->hasFile('additional_images') ? count($request->file('additional_images')) : 0;
            $finalImagesCount = max(0, $existingImagesCount - $deletedImagesCount) + $newImagesCount;

            if ($finalImagesCount > 3) {
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
                
                $oldCover = $book->cover_image;
                $oldAddImages = $book->images->pluck('image_path')->toArray();
                $keptFiles = [];

                $newFiles = $request->file('new_files') ?: [];
                $finalCoverImage = null;
                $finalAddImages = [];

                foreach ($order as $index => $item) {
                    if ($item['type'] === 'existing') {
                        $filename = basename($item['path']);
                        $keptFiles[] = $filename;
                        if ($index === 0) {
                            $finalCoverImage = $filename;
                        } else {
                            $finalAddImages[] = $filename;
                        }
                    } elseif ($item['type'] === 'new') {
                        $fileIdx = $item['index'];
                        if (isset($newFiles[$fileIdx])) {
                            $file = $newFiles[$fileIdx];
                            $name = $this->saveImageAsAvif($file);
                            $keptFiles[] = $name;
                            if ($index === 0) {
                                $finalCoverImage = $name;
                            } else {
                                $finalAddImages[] = $name;
                            }
                        }
                    }
                }

                // Delete unused old main cover image file from disk
                if ($oldCover && !in_array($oldCover, $keptFiles)) {
                    if (file_exists(public_path('covers/' . $oldCover))) {
                        @unlink(public_path('covers/' . $oldCover));
                    }
                }

                // Delete unused old additional images from disk
                foreach ($oldAddImages as $oldPath) {
                    if ($oldPath && !in_array($oldPath, $keptFiles)) {
                        if (file_exists(public_path('covers/' . $oldPath))) {
                            @unlink(public_path('covers/' . $oldPath));
                        }
                    }
                }

                $bookData['cover_image'] = $finalCoverImage;
                
                // Clear old database entries for additional images
                $book->images()->delete();
                // Create new ordered additional images entries
                foreach ($finalAddImages as $path) {
                    $book->images()->create([
                        'image_path' => $path
                    ]);
                }
            } else {
                // Handle deleting the cover image (Legacy)
                if ($request->boolean('delete_cover')) {
                    if ($book->cover_image && file_exists(public_path('covers/' . $book->cover_image))) {
                        @unlink(public_path('covers/' . $book->cover_image));
                    }
                    $bookData['cover_image'] = null;
                }

                // Handle cover image upload (replace old one) (Legacy)
                if ($request->hasFile('cover_image')) {
                    // Delete old cover
                    if ($book->cover_image && file_exists(public_path('covers/' . $book->cover_image))) {
                        @unlink(public_path('covers/' . $book->cover_image));
                    }
                    $image = $request->file('cover_image');
                    $name = $this->saveImageAsAvif($image);
                    $bookData['cover_image'] = $name;
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
                        $name = $this->saveImageAsAvif($file);
                        $book->images()->create([
                            'image_path' => $name,
                         ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.tambah-cover')
                ->with('success', 'Buku "' . $book->title . '" berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memperbarui buku: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete cover image and any additional images of a book.
     */
    public function destroy($id)
    {
        try {
            $book = Book::where('idmaster', $id)->firstOrFail();

            // Delete the cover image file if it exists
            if ($book->cover_image && file_exists(public_path('covers/' . $book->cover_image))) {
                @unlink(public_path('covers/' . $book->cover_image));
            }

            $book->cover_image = null;
            $book->save();

            // Also delete all additional images so they don't persist
            foreach ($book->images as $img) {
                if (file_exists(public_path('covers/' . $img->image_path))) {
                    @unlink(public_path('covers/' . $img->image_path));
                }
                $img->delete();
            }

            return redirect()->route('admin.tambah-cover')
                ->with('success', 'Gambar cover dan tambahan berhasil dihapus.');
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
            
            // Delete the image file if it exists
            if ($img->image_path && file_exists(public_path('covers/' . $img->image_path))) {
                @unlink(public_path('covers/' . $img->image_path));
            }
            
            $img->delete();
            
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
            'name' => 'required|string|max:255',
            'code' => 'required|string|alpha_dash|unique:locations,code|max:255',
            'icon' => 'required|string|max:255',
        ], [
            'code.unique' => 'Kode lokasi sudah terdaftar.',
            'code.alpha_dash' => 'Kode lokasi hanya boleh berisi huruf, angka, tanda hubung (-), dan garis bawah (_).',
        ]);

        try {
            // Find current university (usu)
            $university = \App\Models\University::where('code', 'usu')->first();
            if (!$university) {
                $university = \App\Models\University::first();
            }

            if (!$university) {
                return redirect()->back()->withErrors(['error' => 'Universitas belum terdaftar di sistem.']);
            }

            Location::create([
                'university_id' => $university->id,
                'code' => strtolower($request->code),
                'name' => $request->name,
                'icon' => $request->icon,
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
            throw new \Exception('Tidak dapat membaca gambar.');
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

        // Save path
        $filename = time() . '_' . uniqid() . '.avif';
        $destination = public_path('covers/' . $filename);

        // Ensure covers folder exists
        if (!file_exists(public_path('covers'))) {
            mkdir(public_path('covers'), 0777, true);
        }

        // Compress and save as AVIF (iteratively ensure it is < 150KB)
        $quality = 65; // Good balance for AVIF
        
        do {
            ob_start();
            imageavif($image, null, $quality);
            $data = ob_get_clean();
            
            $size = strlen($data);
            if ($size <= 150 * 1024 || $quality <= 15) {
                file_put_contents($destination, $data);
                break;
            }
            $quality -= 10; // Decrease quality to reduce size
        } while ($quality > 0);

        imagedestroy($image);
        return $filename;
    }
}
