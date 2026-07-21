<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
            'popup_priority' => (int) ($this->popup_priority ?? 1),
            'sort_order' => (int) ($this->sort_order ?? 0),
            'show_popup' => $this->has('show_popup') ? 1 : 0,
            'show_navbar' => $this->has('show_navbar') ? 1 : 0,
            'is_featured' => $this->has('is_featured') ? 1 : 0,
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            'category' => 'required|in:event,announcement,maintenance,new_collection,tips,promotion,general',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status' => 'required|in:draft,published,archived',
            'show_popup' => 'boolean',
            'show_navbar' => 'boolean',
            'is_featured' => 'boolean',
            'popup_priority' => 'required|integer|min:1',
            'sort_order' => 'required|integer|min:0',
            'publish_start_date' => 'required|date',
            'publish_start_time' => 'required|string',
            'publish_end_date' => 'nullable|date|after_or_equal:publish_start_date',
            'publish_end_time' => 'nullable|string',
            'action_buttons' => 'nullable|array',
            'action_buttons.*.name' => 'required_with:action_buttons|string|max:255',
            'action_buttons.*.url' => 'required_with:action_buttons|url|max:255',
            'action_buttons.*.new_tab' => 'nullable|boolean',
            'contact_name' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            
            // Aturan baru untuk field kustom dinamis
            'event_time' => 'nullable|string|max:255',
            'event_location' => 'nullable|string|max:255',
            'event_organizer' => 'nullable|string|max:255',
            'event_participants' => 'nullable|string|max:255',
            'event_facilities' => 'nullable|string|max:255',
            'event_left_badge' => 'nullable|string|max:255',
            'event_left_title' => 'nullable|string|max:255',
            'event_left_subtitle' => 'nullable|string|max:1000',
            'event_quota_tag' => 'nullable|string|max:255',
            'event_left_features' => 'nullable|string',
            'maintenance_services' => 'nullable|string|max:255',
            'maintenance_downtime' => 'nullable|string|max:255',
            'maintenance_alternative' => 'nullable|url|max:255',
            'book_title' => 'nullable|string|max:255',
            'book_author' => 'nullable|string|max:255',
            'book_publisher' => 'nullable|string|max:255',
            'shelf_location' => 'nullable|string|max:255',
            'promo_period' => 'nullable|string|max:255',
            'promo_benefit' => 'nullable|string|max:255',
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
            'category.required' => 'Kategori Informasi wajib dipilih.',
            'category.in' => 'Kategori Informasi yang dipilih tidak valid.',
            'status.required' => 'Status Publikasi wajib dipilih.',
            'status.in' => 'Status Publikasi yang dipilih tidak valid.',
            'publish_start_date.required' => 'Tanggal mulai tayang wajib diisi.',
            'publish_start_date.date' => 'Format tanggal mulai tayang tidak valid.',
            'publish_start_time.required' => 'Jam mulai tayang wajib diisi.',
            'publish_end_date.date' => 'Format tanggal selesai tayang tidak valid.',
            'publish_end_date.after_or_equal' => 'Tanggal selesai tayang tidak boleh mendahului tanggal mulai tayang.',
            'popup_priority.integer' => 'Prioritas popup harus berupa angka bulat.',
            'sort_order.integer' => 'Urutan pengurutan harus berupa angka bulat.',
            'image_path.image' => 'File yang diunggah harus berupa gambar.',
            'image_path.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'image_path.max' => 'Ukuran gambar tidak boleh melebihi 5MB.',
            'action_buttons.*.name.required_with' => 'Nama/Label tombol aksi wajib diisi.',
            'action_buttons.*.url.required_with' => 'Link URL tombol aksi wajib diisi.',
            'action_buttons.*.url.url' => 'Format Link URL tombol aksi tidak valid (contoh: https://google.com).',
            'contact_email.email' => 'Format alamat email narahubung tidak valid.',
        ];
    }
}
