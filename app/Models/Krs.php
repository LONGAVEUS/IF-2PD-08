<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory;

    protected $table = 'krs';
    protected $primaryKey = 'id_krs';

    protected $fillable = [
        'mahasiswa_nim',
        'mk_kode',
        'semester',
    ];

    public function mata_kuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mk_kode', 'kode_mk');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_nim', 'nim');
    }

    public function nilai()
    {
        return $this->hasOne(Nilai::class, 'krs_id', 'id_krs');
    }
}

abstract class NilaiAkademik
{
    protected $krsId;

    public function __construct($krsId)
    {
        $this->krsId = $krsId;
    }

    // Abstract method sebagai kontrak wajib kelas turunan
    abstract public function setNilaiDefault();
}

class DrafNilaiBaru extends NilaiAkademik
{
    // Polimorfisme untuk mengisi data draf awal nilai
    public function setNilaiDefault()
    {
        return [
            'huruf' => null,
            'bobot' => null
        ];
    }
}
