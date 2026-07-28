<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInformationCenterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'popup_priority' => 1,
            'sort_order' => (int) ($this->sort_order ?? 1),
            'show_popup' => 1,
            'show_navbar' => 1,
            'is_featured' => 0,
        ]);
    }

    public function rules(): array
    {
        $activeCount = \App\Models\InformationCenter::where('status', '!=', 'archived')
            ->where(function ($q) {
                $q->whereNull('publish_end_at')
                  ->orWhere('publish_end_at', '>=', now());
            })->count();
        $maxSortOrder = max(1, $activeCount);
        return [
            'title' => 'required_if:type,text|nullable|string|max:255',
            'content' => 'required_if:type,text|nullable|string',
            'category' => 'required|in:event,announcement,book_recommendation,tips,library_news',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:20480',
            'image_fit' => 'nullable|in:cover,contain,fill',
            'image_position' => 'nullable|in:center,top,bottom',
            'image_scale' => 'nullable|integer|min:50|max:300',
            'image_x' => 'nullable|numeric|min:0|max:100',
            'image_y' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:draft,published',
            'show_popup' => 'boolean',
            'show_navbar' => 'boolean',
            'is_featured' => 'boolean',
            'popup_priority' => 'required|integer|min:1',
            'sort_order' => 'required|integer|min:1|max:' . $maxSortOrder,
            'publish_start_date' => 'required_if:status,draft|nullable|date',
            'publish_start_time' => 'required_if:status,draft|nullable|string',
            'publish_end_date' => 'required_with:publish_end_time|nullable|date',
            'publish_end_time' => 'required_with:publish_end_date|nullable|string',
            'action_buttons' => 'nullable|array|max:1',
            'action_buttons.*.name' => 'required_with:action_buttons|string|max:255',
            'action_buttons.*.url' => 'required_with:action_buttons|url|max:255',
            'action_buttons.*.new_tab' => 'nullable|boolean',
            'contact_name' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            
            // Tipe Informasi
            'type' => 'required|in:poster,text',
            
            // Aturan baru untuk field kustom dinamis
            'event_time' => [Rule::requiredIf(fn() => $this->category === 'event' && $this->type === 'text'), 'nullable', 'string', 'max:255'],
            'event_location' => [Rule::requiredIf(fn() => $this->category === 'event' && $this->type === 'text'), 'nullable', 'string', 'max:255'],
            'event_organizer' => 'nullable|string|max:255',
            'event_participants' => 'nullable|string|max:255',
            'event_facilities' => 'nullable|string|max:255',
            'event_left_badge' => 'nullable|string|max:255',
            'event_left_title' => 'nullable|string|max:255',
            'event_left_subtitle' => 'nullable|string|max:1000',
            'event_quota_tag' => 'nullable|string|max:255',
            'event_left_features' => 'nullable|string',
            'book_title' => [Rule::requiredIf(fn() => $this->category === 'book_recommendation' && $this->type === 'text'), 'nullable', 'string', 'max:255'],
            'book_author' => [Rule::requiredIf(fn() => $this->category === 'book_recommendation' && $this->type === 'text'), 'nullable', 'string', 'max:255'],
            'book_publisher' => 'nullable|string|max:255',
            'shelf_location' => 'nullable|string|max:255',
            'announcement_time' => 'nullable|string|max:255',
            'announcement_location' => 'nullable|string|max:255',
            'news_date' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul Informasi wajib diisi.',
            'title.string' => 'Judul Informasi harus berupa teks.',
            'title.max' => 'Judul Informasi tidak boleh lebih dari 255 karakter.',
            'content.required_if' => 'Isi Informasi Lengkap wajib diisi.',
            'images.required_if' => 'Gambar Poster wajib diunggah.',
            'event_time.required_if' => 'Waktu Kegiatan wajib diisi.',
            'event_location.required_if' => 'Lokasi Kegiatan wajib diisi.',
            'book_title.required_if' => 'Judul Buku wajib diisi.',
            'book_author.required_if' => 'Penulis Buku wajib diisi.',
            'category.required' => 'Kategori Informasi wajib dipilih.',
            'category.in' => 'Kategori Informasi yang dipilih tidak valid.',
            'status.required' => 'Status Publikasi wajib dipilih.',
            'status.in' => 'Status Publikasi yang dipilih tidak valid.',
            'publish_start_date.required' => 'Tanggal tayang wajib diisi.',
            'publish_start_date.required_if' => 'Tanggal tayang wajib diisi.',
            'publish_start_date.date' => 'Format tanggal tayang tidak valid.',
            'publish_start_time.required_if' => 'Jam mulai tayang wajib diisi jika Anda memilih Simpan sebagai Draf.',
            'publish_end_date.required_with' => 'Tanggal Selesai Tayang wajib diisi jika Jam Selesai Tayang diisi.',
            'publish_end_time.required_with' => 'Jam Selesai Tayang wajib diisi jika Tanggal Selesai Tayang diisi.',
            'publish_end_date.date' => 'Format tanggal selesai tayang tidak valid.',
            'publish_end_date.after_or_equal' => 'Tanggal selesai tayang tidak boleh mendahului tanggal mulai tayang.',
            'popup_priority.integer' => 'Prioritas popup harus berupa angka bulat.',
            'sort_order.integer' => 'Urutan pengurutan harus berupa angka bulat.',
            'sort_order.max' => 'Urutan pengurutan tidak boleh lebih dari jumlah maksimal informasi yang tersedia.',
            'images.*.image' => 'File yang diunggah harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'images.*.max' => 'Ukuran gambar tidak boleh melebihi 20MB.',
            'images.*.dimensions' => 'Gambar harus memiliki rasio Potrait 4:5.',
            'image_x.numeric' => 'Format posisi gambar X tidak valid.',
            'image_y.numeric' => 'Format posisi gambar Y tidak valid.',
            'image_scale.integer' => 'Format skala gambar tidak valid.',
            'action_buttons.*.name.required_with' => 'Nama/Label tombol aksi wajib diisi.',
            'action_buttons.*.url.required_with' => 'Link URL tombol aksi wajib diisi.',
            'action_buttons.*.url.url' => 'Format Link URL tombol aksi tidak valid (contoh: https://google.com).',
            'contact_email.email' => 'Format alamat email narahubung tidak valid.',
        ];
    }

    /**
     * Additional validation rules after standard validation.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->status === 'draft') {
                $startDate = $this->publish_start_date;
                $startTime = $this->publish_start_time;
                if ($startDate && $startTime) {
                    $startDateTime = \Carbon\Carbon::parse($startDate . ' ' . $startTime);
                    if ($startDateTime->isPast()) {
                        $validator->errors()->add('publish_start_time', 'Waktu mulai tayang untuk draf/jadwal tidak boleh sebelum jam saat ini.');
                    }
                }
            }
        });
    }
}
