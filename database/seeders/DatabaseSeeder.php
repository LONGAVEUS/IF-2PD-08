<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Krs;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $userAdmin = User::create([
            'username' => 'admin123',
            'name'     => 'Administrator Utama',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'status'   => 'aktif',
        ]);
        Admin::create([
            'nip'     => 'admin123',
            'user_id' => $userAdmin->id,
        ]);


        $userDosen = User::create([
            'username' => '12345678',
            'name'     => 'Dr. Budi Santoso',
            'password' => Hash::make('password'),
            'role'     => 'dosen',
            'status'   => 'aktif',
        ]);
        Dosen::create([
            'nidn'    => '12345678',
            'user_id' => $userDosen->id,
            'jurusan' => 'Teknik Informatika',
        ]);


        $userMhs = User::create([
            'username' => '202604001',
            'name'     => 'Arnol Hutagalung',
            'password' => Hash::make('password'),
            'role'     => 'mahasiswa',
            'status'   => 'aktif',
        ]);
        $mahasiswa = Mahasiswa::create([
            'nim'         => '202604001',
            'user_id'     => $userMhs->id,
            'prodi'       => 'Informatika',
            'semester_ke' => 2,
        ]);


        $mk1 = MataKuliah::create([
            'kode_mk'    => 'IF301',
            'nama_mk'    => 'Pemrograman Web',
            'sks'        => 3,
            'semester'   => 2,
            'dosen_nidn' => '12345678',
        ]);

        $mk2 = MataKuliah::create([
            'kode_mk'    => 'IF302',
            'nama_mk'    => 'Basis Data',
            'sks'        => 3,
            'semester'   => 2,
            'dosen_nidn' => '12345678',
        ]);

        Krs::create([
            'mahasiswa_nim' => $mahasiswa->nim,
            'mk_kode'       => $mk1->kode_mk,
            'semester'      => 2,
        ]);

        Krs::create([
            'mahasiswa_nim' => $mahasiswa->nim,
            'mk_kode'       => $mk2->kode_mk,
            'semester'      => 2,
        ]);
    }
}
