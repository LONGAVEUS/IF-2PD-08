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

    // search dosen (read)
    public static function searchDosen($search)
    {
        $query = User::where('role', 'dosen')->with('dosen');

        if($search) {
            $query->where(function($q) use ($search) {
            $q->where('name', 'like', '%' .  $search . '%' )
            ->orWhereHas('dosen', function($dq) use ($search) {
                $dq->where('nidn' , 'like' , '%' . $search . '%' );
                });
            });
        }
    return $query;
    }

    // simpan data dosen baru (create)
    public static function simpanDosen(array $data)
    {
        $user = User::create([
            'name'     => $data['name'],
            'username' => $data['nidn'],
            'password' => $data['password'],
            'role'     => 'dosen',
            'status'   => $data['status']

        ]);

        return self::create([
            'user_id'  => $user->id,
            'nidn'     => $data['nidn'],
            'jurusan'  => $data['jurusan']
        ]);
    }

    // perbarui data dosen (update)
    public function updateDosen(array $data)
    {
        $this->update([
            'nidn'    => $data['nidn'],
            'jurusan' => $data['jurusan']
        ]);

        if ($this->user) {
            $this->user->update([
                'name'      => $data['name'],
                'username'  => $data['nidn'],
                'status'    => $data['status']
            ]);

        if (!empty($data['password'])) {
            $this->user->update(['password' => $data['password']]);
        }
    }
    return $this;
        }
    }


