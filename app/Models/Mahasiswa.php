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


    public static function searchMahasiswa($search, $selectedSemester)
    {
        $query = User::where('role', 'mahasiswa')->with('mahasiswa');

        // Filter berdasarkan semester jika dipilih
        if ($selectedSemester) {
            $query->whereHas('mahasiswa', function($q) use ($selectedSemester) {
                $q->where('semester_ke', $selectedSemester);
            });
        }

        // Pencarian berdasarkan nama atau NIM
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('mahasiswa', function($mq) use ($search) {
                    $mq->where('nim', 'like', '%' . $search . '%');
                });
            });
        }

        return $query;
    }
    public static function simpanMahasiswa(array $data) {
    $user = User::Create([
        'name'     => $data['name'],
        'username' => $data['nim'],
        'password' => $data['password'],
        'role'     => 'mahasiswa',
        'status'   => $data['status']

        ]);

        return self::create([
            'user_id'     => $user->id,
            'nim'         => $data['nim'],
            'prodi'       => $data['prodi'],
            'semester_ke' => $data['semester_ke']

        ]);
    }

    public function updateMahasiswa(array $data) {
        $this->update([
            'nim'         => $data['nim'],
            'prodi'       => $data['prodi'],
            'semester_ke' => $data['semester_ke']
        ]);

        if($this->user){
            $this->user->update([
                'name'      => $data['name'],
                'username'  => $data['nim'],
                'status'    => $data['status'],
            ]);

            if (!empty($data['password'])) {
                $this->user->update(['password' => $data['password']]);
            }
        }
        return $this;
    }
}


