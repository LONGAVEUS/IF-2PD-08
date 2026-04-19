<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    protected $table = 'semester';
    protected $primaryKey = 'id_semester';
    protected $fillable = [
        'tahun_ajaran',
        'tipe_semester',
        'batas_pengisian',
        'batas_tgl_nilai',
        'status_krs',
        'status_khs'
    ];
}
