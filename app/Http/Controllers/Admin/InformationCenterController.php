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
        $query = InformationCenter::query();

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

        return view('admin.information_center.index', compact('informationCenters'));
    }

    public function create()
    {
        return view('admin.information_center.create');
    }

    public function store(StoreInformationCenterRequest $request)
    {
        try {
            $data = $request->validated();
            
            $data['slug'] = Str::slug($data['title']) . '-' . uniqid();
            $data['created_by'] = Auth::id() ?? 1;

            // Merangkai tanggal & waktu menjadi datetime
            $data['publish_start_at'] = $data['publish_start_date'] . ' ' . $data['publish_start_time'];
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

            if ($request->hasFile('image_path')) {
                $data['image_path'] = $this->convertToAvif($request->file('image_path'));
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
        return view('admin.information_center.edit', compact('informationCenter'));
    }

    public function update(UpdateInformationCenterRequest $request, InformationCenter $informationCenter)
    {
        $data = $request->validated();
        
        $data['updated_by'] = Auth::id() ?? 1;

        // Merangkai tanggal & waktu menjadi datetime
        $data['publish_start_at'] = $data['publish_start_date'] . ' ' . $data['publish_start_time'];
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

        if ($request->hasFile('image_path')) {
            // Hapus gambar lama jika ada untuk menghemat disk
            if ($informationCenter->image_path) {
                $oldPath = str_replace('/storage/', '', $informationCenter->image_path);
                Storage::disk('public')->delete($oldPath);
            }
            $data['image_path'] = $this->convertToAvif($request->file('image_path'));
        }

        // Proses data kustom kategori menjadi format JSON jika relevan
        $data = $this->processCategoryContent($data, $request);

        $informationCenter->update($data);

        return redirect()->route('admin.information-center.index')->with('success', 'Informasi berhasil diperbarui!');
    }

    public function destroy(InformationCenter $informationCenter)
    {
        // Hapus gambar terkait dari penyimpanan sebelum delete record
        if ($informationCenter->image_path) {
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

        } elseif ($category === 'maintenance') {
            $maintenanceData = [
                'is_custom_maintenance' => true,
                'affected_services' => $request->maintenance_services,
                'estimated_downtime' => $request->maintenance_downtime,
                'alternative_link' => $request->maintenance_alternative,
                'description' => $data['content'] ?? null,
            ];
            $data['content'] = json_encode($maintenanceData);

        } elseif ($category === 'new_collection') {
            $collectionData = [
                'is_custom_collection' => true,
                'book_title' => $request->book_title,
                'book_author' => $request->book_author,
                'book_publisher' => $request->book_publisher,
                'shelf_location' => $request->shelf_location,
                'description' => $data['content'] ?? null,
            ];
            $data['content'] = json_encode($collectionData);

        } elseif ($category === 'promotion') {
            $promoData = [
                'is_custom_promotion' => true,
                'promo_period' => $request->promo_period,
                'promo_benefit' => $request->promo_benefit,
                'description' => $data['content'] ?? null,
            ];
            $data['content'] = json_encode($promoData);
        }

        // Hapus field request kustom agar tidak mencoba di-insert langsung ke database
        $customFields = [
            'event_time', 'event_location', 'event_organizer', 'event_participants', 'event_facilities',
            'event_left_badge', 'event_left_title', 'event_left_subtitle', 'event_quota_tag', 'event_left_features',
            'maintenance_services', 'maintenance_downtime', 'maintenance_alternative',
            'book_title', 'book_author', 'book_publisher', 'shelf_location',
            'promo_period', 'promo_benefit'
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

        $trashItems = $query->latest('deleted_at')->paginate(10);
        return view('admin.information_center.trash', compact('trashItems'));
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
        if ($info->image_path) {
            $oldPath = str_replace('/storage/', '', $info->image_path);
            Storage::disk('public')->delete($oldPath);
        }

        $info->forceDelete();
        return redirect()->route('admin.information-center.trash')->with('success', 'Informasi berhasil dihapus permanen dari database!');
    }
}
