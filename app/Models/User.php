<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'username',
        'name',
        'password',
        'role',
        'status',
    ];

    // Kolom yang disembunyikan
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast tipe data otomatis (Bikin password otomatis di-hash)
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke model Mahasiswa
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'user_id', 'id');
    }

    // Relasi ke model Dosen
    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'user_id', 'id');
    }

    // Relasi ke model Admin
    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id', 'id');
    }
}
