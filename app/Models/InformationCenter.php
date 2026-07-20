<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformationCenter extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'publish_start_at' => 'datetime',
        'publish_end_at' => 'datetime',
        'show_popup' => 'boolean',
        'show_navbar' => 'boolean',
        'is_featured' => 'boolean',
        'is_action_open_in_new_tab' => 'boolean',
        'action_button_url' => 'array', // ditambahkan untuk multi-tombol aksi (menyimpan JSON array)
    ];

    public function getComputedStatusAttribute()
    {
        if ($this->status === 'published' && $this->publish_end_at && $this->publish_end_at->isPast()) {
            return 'expired';
        }
        return $this->status;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updator()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
