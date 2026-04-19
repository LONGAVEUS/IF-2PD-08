<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['nip', 'user_id'];
}
