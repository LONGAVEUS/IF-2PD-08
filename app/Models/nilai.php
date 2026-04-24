<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';

    protected $primaryKey = 'id_nilai';

    protected $fillable = [
        'krs_id',
        'nilai_angka',
        'bobot',
    ];

    public function krs()
    {
        return $this->belongsTo(Krs::class, 'krs_id', 'id_krs');
    }
}
