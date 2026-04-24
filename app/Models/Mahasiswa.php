<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nim',
        'user_id',
        'prodi',
        'semester_ke',
        'ip_kumulatif',
        'ip_semester',
    ];


    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function krs() {
        return $this->hasMany(Krs::class, 'mahasiswa_nim', 'nim');
    }
}
