<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformationCenter;
use App\Http\Requests\StoreInformationCenterRequest;
use App\Http\Requests\UpdateInformationCenterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class InformationCenterController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'active');

        // Hitung total item aktif dan history/kadaluwarsa
        $countActive = InformationCenter::where('status', '!=', 'archived')
            ->where(function ($q) {
                $q->whereNull('publish_end_at')
                  ->orWhere('publish_end_at', '>=', now());
            })->count();

        $countHistory = InformationCenter::where(function ($q) {
            $q->where('status', 'archived')
              ->orWhere('status', 'expired')
              ->orWhere(function ($sub) {
                  $sub->whereNotNull('publish_end_at')
                      ->where('publish_end_at', '<', now());
              });
        })->count();

        $countTrash = InformationCenter::onlyTrashed()->count();

        $query = InformationCenter::query();

        if ($tab === 'history') {
            $query->where(function ($q) {
                $q->where('status', 'archived')
                  ->orWhere('status', 'expired')
                  ->orWhere(function ($sub) {
                      $sub->whereNotNull('publish_end_at')
                          ->where('publish_end_at', '<', now());
                  });
            });
        } else {
            // Default tab: active
            $query->where('status', '!=', 'archived')
                  ->where(function ($q) {
                      $q->whereNull('publish_end_at')
                        ->orWhere('publish_end_at', '>=', now());
                  });
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('status') && $request->status != '') {
            if ($request->status === 'expired') {
                $query->where('status', 'published')
                      ->whereNotNull('publish_end_at')
                      ->where('publish_end_at', '<', now());
            } elseif ($request->status === 'published') {
                $query->where('status', 'published')
                      ->where(function ($q) {
                          $q->whereNull('publish_end_at')
                            ->orWhere('publish_end_at', '>=', now());
                      });
            } else {
                $query->where('status', $request->status);
            }
        }

        $informationCenters = $query->latest()->paginate(10)->withQueryString();

        return view('admin.information_center.index', compact('informationCenters', 'tab', 'countActive', 'countHistory', 'countTrash'));
    }

    public function create()
    {
        $activeCount = InformationCenter::where('status', '!=', 'archived')
            ->where(function ($q) {
                $q->whereNull('publish_end_at')
                  ->orWhere('publish_end_at', '>=', now());
            })->count();

        $maxSortOrder = max(1, $activeCount + 1);
        return view('admin.information_center.create', compact('maxSortOrder'));
    }

    public function store(StoreInformationCenterRequest $request)
    {
        try {
            $data = $request->validated();
            
            $data['slug'] = Str::slug($data['title']) . '-' . uniqid();
            $data['created_by'] = $this->getValidUserId();

            // Merangkai tanggal & waktu menjadi datetime
            if ($data['status'] === 'published') {
                $data['publish_start_at'] = now()->format('Y-m-d H:i:s');
            } else {
                $startDate = $data['publish_start_date'] ?? date('Y-m-d');
                $startTime = $data['publish_start_time'] ?? date('H:i');
                $data['publish_start_at'] = $startDate . ' ' . $startTime;
            }
            if (!empty($data['publish_end_date']) && !empty($data['publish_end_time'])) {
                $data['publish_end_at'] = $data['publish_end_date'] . ' ' . $data['publish_end_time'];
            } else {
                $data['publish_end_at'] = null;
            }
            unset($data['publish_start_date'], $data['publish_start_time'], $data['publish_end_date'], $data['publish_end_time']);

            // Mapping multi-tombol aksi ke kolom action_button_url
            if (isset($data['action_buttons'])) {
                $data['action_button_url'] = $data['action_buttons'];
            } else {
                $data['action_button_url'] = null;
            }
            unset($data['action_buttons']);

            if ($request->hasFile('images')) {
                $uploadedImages = [];
                foreach ($request->file('images') as $file) {
                    $uploadedImages[] = $this->convertToAvif($file);
                }
                $data['images'] = $uploadedImages;
                $data['image_path'] = $uploadedImages[0]; // Backward compatibility
            } else {
                $defaultImg = 'perpustakaan_depan.webp';
                $data['images'] = [$defaultImg];
                $data['image_path'] = $defaultImg;
            }

            // Proses data kustom kategori menjadi format JSON jika relevan
            $data = $this->processCategoryContent($data, $request);

            \Illuminate\Support\Facades\Log::info('[IC-STORE] Data siap disimpan', ['data_keys' => array_keys($data), 'data' => $data]);

            InformationCenter::create($data);

            return redirect()->route('admin.information-center.index')->with('success', 'Informasi berhasil ditambahkan!');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('[IC-STORE] ERROR: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(InformationCenter $informationCenter)
    {
        return view('admin.information_center.show', compact('informationCenter'));
    }

    public function edit(InformationCenter $informationCenter)
    {
        $activeCount = InformationCenter::where('status', '!=', 'archived')
            ->where(function ($q) {
                $q->whereNull('publish_end_at')
                  ->orWhere('publish_end_at', '>=', now());
            })->count();

        $maxSortOrder = max(1, $activeCount);
        return view('admin.information_center.edit', compact('informationCenter', 'maxSortOrder'));
    }

    public function update(UpdateInformationCenterRequest $request, InformationCenter $informationCenter)
    {
        $data = $request->validated();
        
        $data['updated_by'] = $this->getValidUserId();

        // Merangkai tanggal & waktu menjadi datetime
        if ($data['status'] === 'published') {
            $data['publish_start_at'] = $informationCenter->publish_start_at ?? now()->format('Y-m-d H:i:s');
        } else {
            $startDate = $data['publish_start_date'] ?? date('Y-m-d');
            $startTime = $data['publish_start_time'] ?? date('H:i');
            $data['publish_start_at'] = $startDate . ' ' . $startTime;
        }
        if (!empty($data['publish_end_date']) && !empty($data['publish_end_time'])) {
            $data['publish_end_at'] = $data['publish_end_date'] . ' ' . $data['publish_end_time'];
        } else {
            $data['publish_end_at'] = null;
        }
        unset($data['publish_start_date'], $data['publish_start_time'], $data['publish_end_date'], $data['publish_end_time']);

        // Mapping multi-tombol aksi ke kolom action_button_url
        if (isset($data['action_buttons'])) {
            $data['action_button_url'] = $data['action_buttons'];
        } else {
            $data['action_button_url'] = null;
        }
        unset($data['action_buttons']);

        if ($request->hasFile('images')) {
            // Hapus gambar lama jika ada untuk menghemat disk
            if ($informationCenter->images) {
                foreach ($informationCenter->images as $oldImage) {
                    $oldPath = str_replace('/storage/', '', $oldImage);
                    Storage::disk('public')->delete($oldPath);
                }
            } elseif ($informationCenter->image_path) {
                $oldPath = str_replace('/storage/', '', $informationCenter->image_path);
                Storage::disk('public')->delete($oldPath);
            }
            
            $uploadedImages = [];
            foreach ($request->file('images') as $file) {
                $uploadedImages[] = $this->convertToAvif($file);
            }
            $data['images'] = $uploadedImages;
            $data['image_path'] = $uploadedImages[0]; // Backward compatibility
        }

        // Proses data kustom kategori menjadi format JSON jika relevan
        $data = $this->processCategoryContent($data, $request);

        $informationCenter->update($data);

        return redirect()->route('admin.information-center.index')->with('success', 'Informasi berhasil diperbarui!');
    }

    public function destroy(InformationCenter $informationCenter)
    {
        // Hapus gambar terkait dari penyimpanan sebelum delete record
        if ($informationCenter->images) {
            foreach ($informationCenter->images as $oldImage) {
                $oldPath = str_replace('/storage/', '', $oldImage);
                Storage::disk('public')->delete($oldPath);
            }
        } elseif ($informationCenter->image_path) {
            $oldPath = str_replace('/storage/', '', $informationCenter->image_path);
            Storage::disk('public')->delete($oldPath);
        }

        $informationCenter->delete();
        return redirect()->route('admin.information-center.index')->with('success', 'Informasi berhasil dihapus!');
    }

    /**
     * Konversi gambar yang diunggah ke format AVIF secara otomatis.
     */
    private function convertToAvif($uploadedFile, $destinationFolder = 'information_center'): string
    {
        $filePath = $uploadedFile->getRealPath();
        $mime = $uploadedFile->getMimeType();
        $image = null;

        // Load gambar berdasarkan MimeType
        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($filePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($filePath);
                if ($image) {
                    imagealphablending($image, false);
                    imagesavealpha($image, true);
                }
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($filePath);
                break;
            case 'image/avif':
                // Jika file asli sudah AVIF, simpan langsung
                $fileName = uniqid() . '.avif';
                $path = $uploadedFile->storeAs($destinationFolder, $fileName, 'public');
                return '/storage/' . $path;
        }

        // Fallback jika gagal membuat resource GD
        if (!$image) {
            $path = $uploadedFile->store($destinationFolder, 'public');
            return '/storage/' . $path;
        }

        // Bikin folder penyimpanan di storage/app/public jika belum ada
        $fileName = uniqid() . '.avif';
        $storagePath = storage_path('app/public/' . $destinationFolder);
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        $fullPath = $storagePath . '/' . $fileName;

        // Konversi ke AVIF dengan kualitas 65 (seimbang antara kompresi dan kualitas visual)
        imageavif($image, $fullPath, 65);
        imagedestroy($image);

        return '/storage/' . $destinationFolder . '/' . $fileName;
    }

    /**
     * Memproses konten berdasarkan kategori informasi.
     * Jika kategori adalah tipe kustom, kumpulkan input spesifiknya dan ubah menjadi string JSON.
     */
    private function processCategoryContent(array $data, $request): array
    {
        $category = $data['category'] ?? 'general';

        if ($category === 'event') {
            $leftFeatures = [];
            if (!empty($request->event_left_features)) {
                // Split string per baris
                $leftFeatures = array_filter(
                    array_map('trim', explode("\n", str_replace("\r", "", $request->event_left_features)))
                );
            }
            
            $eventData = [
                'is_custom_event' => true,
                'time' => $request->event_time,
                'location' => $request->event_location,
                'organizer' => $request->event_organizer,
                'participants' => $request->event_participants,
                'facilities' => $request->event_facilities,
                'left_badge' => $request->event_left_badge,
                'left_title' => $request->event_left_title,
                'left_subtitle' => $request->event_left_subtitle,
                'quota_tag' => $request->event_quota_tag,
                'left_features' => array_values($leftFeatures),
                'description' => $data['content'] ?? null,
            ];
            $data['content'] = json_encode($eventData);

        } elseif ($category === 'new_collection' || $category === 'book_recommendation') {
            $collectionData = [
                'is_custom_collection' => true,
                'book_title' => $request->book_title,
                'book_author' => $request->book_author,
                'book_publisher' => $request->book_publisher,
                'shelf_location' => $request->shelf_location,
                'description' => $data['content'] ?? null,
            ];
            $data['content'] = json_encode($collectionData);
            
        } elseif ($category === 'announcement') {
            $announcementData = [
                'is_custom_announcement' => true,
                'time' => $request->announcement_time,
                'location' => $request->announcement_location,
                'description' => $data['content'] ?? null,
            ];
            $data['content'] = json_encode($announcementData);

        } elseif ($category === 'library_news') {
            $newsData = [
                'is_custom_news' => true,
                'date' => $request->news_date,
                'description' => $data['content'] ?? null,
            ];
            $data['content'] = json_encode($newsData);
        }

        // Hapus field request kustom agar tidak mencoba di-insert langsung ke database
        $customFields = [
            'event_time', 'event_location', 'event_organizer', 'event_participants', 'event_facilities',
            'event_left_badge', 'event_left_title', 'event_left_subtitle', 'event_quota_tag', 'event_left_features',
            'book_title', 'book_author', 'book_publisher', 'shelf_location',
            'announcement_time', 'announcement_location', 'news_date'
        ];
        foreach ($customFields as $field) {
            if (isset($data[$field])) {
                unset($data[$field]);
            }
        }

        return $data;
    }

    /**
     * Menampilkan daftar data yang dihapus (Trash / History Arsip).
     */
    public function trash(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $query = InformationCenter::onlyTrashed();

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }
        if ($category) {
            $query->where('category', $category);
        }

        $countActive = InformationCenter::where('status', '!=', 'archived')
            ->where(function ($q) {
                $q->whereNull('publish_end_at')
                  ->orWhere('publish_end_at', '>=', now());
            })->count();

        $countHistory = InformationCenter::where(function ($q) {
            $q->where('status', 'archived')
              ->orWhere('status', 'expired')
              ->orWhere(function ($sub) {
                  $sub->whereNotNull('publish_end_at')
                      ->where('publish_end_at', '<', now());
              });
        })->count();

        $countTrash = InformationCenter::onlyTrashed()->count();

        $trashItems = $query->latest('deleted_at')->paginate(10);
        return view('admin.information_center.trash', compact('trashItems', 'countActive', 'countHistory', 'countTrash'));
    }

    /**
     * Memulihkan data yang di-Soft Delete.
     */
    public function restore($id)
    {
        $info = InformationCenter::onlyTrashed()->findOrFail($id);
        $info->restore();
        return redirect()->route('admin.information-center.trash')->with('success', 'Informasi berhasil dipulihkan!');
    }

    /**
     * Menghapus data secara permanen dari database.
     */
    public function forceDelete($id)
    {
        $info = InformationCenter::onlyTrashed()->findOrFail($id);
        
        // Hapus gambar fisik
        if ($info->images) {
            foreach ($info->images as $oldImage) {
                $oldPath = str_replace('/storage/', '', $oldImage);
                Storage::disk('public')->delete($oldPath);
            }
        } elseif ($info->image_path) {
            $oldPath = str_replace('/storage/', '', $info->image_path);
            Storage::disk('public')->delete($oldPath);
        }

        $info->forceDelete();
        return redirect()->route('admin.information-center.trash')->with('success', 'Informasi berhasil dihapus permanen dari database!');
    }

    /**
     * Menerbitkan kembali informasi yang telah kadaluarsa dengan jadwal tanggal & waktu baru.
     */
    public function republish(Request $request, $id)
    {
        $informationCenter = InformationCenter::findOrFail($id);

        $request->validate([
            'publish_start_date' => 'required|date',
            'publish_start_time' => 'required|string',
            'publish_end_date'   => 'nullable|date|after_or_equal:publish_start_date',
            'publish_end_time'   => 'nullable|string',
        ], [
            'publish_start_date.required' => 'Tanggal mulai tayang wajib diisi.',
            'publish_start_date.date'     => 'Format tanggal mulai tayang tidak valid.',
            'publish_start_time.required' => 'Jam mulai tayang wajib diisi.',
            'publish_end_date.date'       => 'Format tanggal selesai tayang tidak valid.',
            'publish_end_date.after_or_equal' => 'Tanggal selesai tayang tidak boleh mendahului tanggal mulai tayang.',
        ]);

        $publishStartAt = $request->publish_start_date . ' ' . $request->publish_start_time;
        $publishEndAt = null;
        if (!empty($request->publish_end_date) && !empty($request->publish_end_time)) {
            $publishEndAt = $request->publish_end_date . ' ' . $request->publish_end_time;
        }

        $informationCenter->update([
            'publish_start_at' => $publishStartAt,
            'publish_end_at'   => $publishEndAt,
            'status'           => 'published',
            'updated_by'       => $this->getValidUserId(),
        ]);

        return redirect()->route('admin.information-center.index', ['tab' => 'active'])
            ->with('success', 'Informasi "' . $informationCenter->title . '" berhasil ditampilkan kembali dengan jadwal tayang baru!');
    }

    /**
     * Memindahkan informasi aktif/draf ke status diarsipkan.
     */
    public function archive($id)
    {
        $info = InformationCenter::findOrFail($id);
        $info->update(['status' => 'archived']);

        return redirect()->route('admin.information-center.index', ['tab' => 'active'])
            ->with('success', 'Informasi "' . $info->title . '" berhasil dipindahkan ke arsip!');
    }

    /**
     * Memulihkan (Tampilkan Kembali) beberapa data history sekaligus.
     */
    public function bulkRepublishHistory(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ], [
            'ids.required' => 'Pilih setidaknya satu data informasi untuk dipulihkan.',
        ]);

        $count = InformationCenter::whereIn('id', $request->ids)->update([
            'status'           => 'published',
            'publish_start_at' => now()->format('Y-m-d H:i:s'),
            'publish_end_at'   => null,
            'updated_by'       => $this->getValidUserId(),
        ]);

        return redirect()->route('admin.information-center.index', ['tab' => 'history'])
            ->with('success', "Berhasil menampilkan kembali {$count} data informasi ke status Aktif!");
    }

    /**
     * Menghapus beberapa data history sekaligus (Bulk Delete History).
     */
    public function bulkDeleteHistory(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ], [
            'ids.required' => 'Pilih setidaknya satu data informasi untuk dihapus.',
        ]);

        $items = InformationCenter::whereIn('id', $request->ids)->get();
        $count = $items->count();

        foreach ($items as $info) {
            if ($info->images) {
                foreach ($info->images as $oldImage) {
                    $oldPath = str_replace('/storage/', '', $oldImage);
                    Storage::disk('public')->delete($oldPath);
                }
            } elseif ($info->image_path) {
                $oldPath = str_replace('/storage/', '', $info->image_path);
                Storage::disk('public')->delete($oldPath);
            }
            $info->delete();
        }

        return redirect()->route('admin.information-center.index', ['tab' => 'history'])
            ->with('success', "Berhasil menghapus {$count} data informasi!");
    }

    /**
     * Memulihkan beberapa data sekaligus (Bulk Restore).
     */
    public function bulkRestore(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ], [
            'ids.required' => 'Pilih setidaknya satu data informasi untuk dipulihkan.',
        ]);

        $items = InformationCenter::onlyTrashed()->whereIn('id', $request->ids)->get();
        $count = $items->count();

        foreach ($items as $item) {
            $item->restore();
        }

        return redirect()->route('admin.information-center.trash')
            ->with('success', "Berhasil memulihkan {$count} data informasi!");
    }

    /**
     * Menghapus beberapa data secara permanen sekaligus (Bulk Force Delete).
     */
    public function bulkForceDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ], [
            'ids.required' => 'Pilih setidaknya satu data informasi untuk dihapus permanen.',
        ]);

        $items = InformationCenter::onlyTrashed()->whereIn('id', $request->ids)->get();
        $count = $items->count();

        foreach ($items as $info) {
            if ($info->images) {
                foreach ($info->images as $oldImage) {
                    $oldPath = str_replace('/storage/', '', $oldImage);
                    Storage::disk('public')->delete($oldPath);
                }
            } elseif ($info->image_path) {
                $oldPath = str_replace('/storage/', '', $info->image_path);
                Storage::disk('public')->delete($oldPath);
            }

            $info->forceDelete();
        }

        return redirect()->route('admin.information-center.trash')
            ->with('success', "Berhasil menghapus permanen {$count} data informasi dari database!");
    }

    /**
     * Mengambil ID user yang valid dari tabel 'users' untuk menghindari kesalahan Foreign Key Constraint MySQL.
     */
    private function getValidUserId(): ?int
    {
        try {
            $userId = Auth::id();
            if ($userId && \Illuminate\Support\Facades\DB::table('users')->where('id', $userId)->exists()) {
                return (int) $userId;
            }

            $firstUser = \Illuminate\Support\Facades\DB::table('users')->first();
            if ($firstUser && isset($firstUser->id)) {
                return (int) $firstUser->id;
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('[getValidUserId] Exception: ' . $e->getMessage());
        }

        return null;
    }
}
