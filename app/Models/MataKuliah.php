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

    // Filter pencarian kode, nama mata kuliah, atau semester
    public static function searchMataKuliah($search, $selectedSemester)
    {
        $query = self::with('dosen.user');

        if ($selectedSemester) {
            $query->where('semester', $selectedSemester);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_mk', 'like', '%' . $search . '%')
                ->orWhere('kode_mk', 'like', '%' . $search . '%');
            });
        }

        return $query;
    }

    // Simpan data mata kuliah baru
    public static function simpanMataKuliah(array $data)
    {
        return self::create([
            'kode_mk' => $data['kode_mk'],
            'nama_mk' => $data['nama_mk'],
            'sks' => $data['sks'],
            'semester' => $data['semester'],
            'dosen_nidn' => $data['dosen_nidn'],
        ]);
    }

    // Update data mata kuliah
    public function updateMataKuliah(array $data)
    {
        return $this->update([
            'kode_mk' => $data['kode_mk'],
            'nama_mk' => $data['nama_mk'],
            'sks' => $data['sks'],
            'semester' => $data['semester'],
            'dosen_nidn' => $data['dosen_nidn'],
        ]);
    }

}
