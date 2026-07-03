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

    // Relasi balik ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Read - pencarian admin
    public static function searchAdmin($search)
    {
        $query = User::where('role', 'admin')->with('admin');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%');
            });
        }
        return $query;
    }

    // Create - menyimpan data admin baru
    public static function simpanAdmin(array $data)
    {
        $user = User::create([
            'name'     => $data['name'],
            'username' => $data['nip'],
            'password' => $data['password'],
            'role'     => 'admin',
            'status'   => $data['status'],
        ]);

        return self::create([
            'nip'     => $data['nip'],
            'user_id' => $user->id,
        ]);
    }

    // Update - mengubah data admin
    public function updateAdmin(array $data)
    {
        $this->update(['nip' => $data['nip']]);

        if ($this->user) {
            $this->user->update([
                'name'     => $data['name'],
                'username' => $data['nip'],
                'status'   => $data['status'],
            ]);

            if (!empty($data['password'])) {
                $this->user->update(['password' => $data['password']]);
            }
        }
        return $this;
    }

    // Read - kalkulasi statistik dashboard admin
    public static function dataDashboard($selectedSemester)
    {
        $totalMahasiswa = Mahasiswa::where('semester_ke', $selectedSemester)->count();
        $totalDosen = MataKuliah::where('semester', $selectedSemester)->distinct('dosen_nidn')->count();
        $totalMatkulCount = MataKuliah::where('semester', $selectedSemester)->count();

        $mataKuliahAktif = MataKuliah::where('semester', $selectedSemester)
            ->with(['dosen.user'])
            ->orderBy('kode_mk', 'asc')
            ->paginate(5)
            ->withQueryString();

        $semuaMhs = Mahasiswa::where('semester_ke', $selectedSemester)->get();
        $mahasiswaBelumKrs = [];

        foreach ($semuaMhs as $mhs) {
            $sudahIsiKrs = Krs::where('mahasiswa_nim', $mhs->nim)
                ->where('semester', $selectedSemester)
                ->exists();

            if (!$sudahIsiKrs) {
                $mahasiswaBelumKrs[] = $mhs;
            }
        }

        return [
            'totalMahasiswa'    => $totalMahasiswa,
            'totalDosen'        => $totalDosen,
            'totalMatkulCount'  => $totalMatkulCount,
            'mataKuliahAktif'   => $mataKuliahAktif,
            'mahasiswaBelumKrs' => $mahasiswaBelumKrs,
            'jumlahBelumKrs'    => count($mahasiswaBelumKrs)
        ];
    }
}
