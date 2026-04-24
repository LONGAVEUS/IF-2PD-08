<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen';
    protected $primaryKey = 'nidn';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['nidn', 'user_id', 'jurusan'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

