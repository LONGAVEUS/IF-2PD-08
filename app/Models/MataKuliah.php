<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $table = 'mata_kuliah';
    protected $primaryKey = 'kode_mk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['kode_mk', 'nama_mk', 'sks', 'semester', 'dosen_nidn'];

    public function dosen() {
        return $this->belongsTo(Dosen::class, 'dosen_nidn', 'nidn');
    }

    public function krs()
    {
        return $this->hasMany(Krs::class, 'mk_kode', 'kode_mk');
    }


}

