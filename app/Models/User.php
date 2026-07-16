<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Menggunakan tabel tbluser dari database OPAC lama.
     * Kolom-kolom asli TIDAK diubah/dihapus.
     */
    protected $table = 'tbluser';

    /**
     * Primary key dari tbluser adalah 'iduser', bukan 'id'.
     */
    protected $primaryKey = 'iduser';

    /**
     * Kolom created_at di tbluser bernama 'tglinput'.
     */
    const CREATED_AT = 'tglinput';
    const UPDATED_AT = 'updated_at';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'username',
        'nama_lengkap',
        'email',
        'password',
        'notelp',
        'role',
        'status',
        'keterangan',
        'idgroup',
        'status_administrator',
        'iduser_input',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tglinput' => 'datetime',
        ];
    }

    /**
     * Accessor: agar $user->name tetap berfungsi di seluruh aplikasi
     * (Controller, Blade, dll.) tanpa perlu mengubah kode yang sudah ada.
     * Membaca dari kolom 'nama_lengkap' yang ada di tbluser.
     */
    public function getNameAttribute()
    {
        return $this->nama_lengkap;
    }

    /**
     * Mutator: agar $user->name = 'xxx' tetap berfungsi
     * dan menyimpan ke kolom 'nama_lengkap'.
     */
    public function setNameAttribute($value)
    {
        $this->attributes['nama_lengkap'] = $value;
    }

    /**
     * Cek apakah user adalah pustakawan (admin).
     */
    public function isPustakawan(): bool
    {
        return $this->role === 'pustakawan';
    }

    /**
     * Cek apakah user adalah anggota biasa.
     */
    public function isAnggota(): bool
    {
        return $this->role === 'anggota';
    }
}
