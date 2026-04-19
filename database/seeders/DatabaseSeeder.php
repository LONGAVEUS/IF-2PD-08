<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use App\Models\Semester;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        $userAdmin = User::create([
            'username' => 'admin123',
            'name' => 'Administrator Utama',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'aktif',
        ]);
        Admin::create([
            'nip' => 'admin123',
            'user_id' => $userAdmin->id,
        ]);

        // 2. Buat Akun Dosen
        $userDosen = User::create([
            'username' => '12345678',
            'name' => 'Dr. Budi Santoso',
            'password' => Hash::make('password'),
            'role' => 'dosen',
            'status' => 'aktif',
        ]);
        Dosen::create([
            'nidn' => '12345678',
            'user_id' => $userDosen->id,
            'jurusan' => 'Teknik Informatika',
        ]);

        // 3. Buat Akun Mahasiswa
        $userMhs = User::create([
            'username' => '202604001',
            'name' => 'Arnol Hutagalung',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'status' => 'aktif',
        ]);

        Mahasiswa::create([
            'nim' => '202604001',
            'user_id' => $userMhs->id,
            'prodi' => 'Informatika',
            'semester_ke' => 2,
            'angkatan' => 2025,  
        ]);

        // 4. Buat Data Semester Aktif
        Semester::create([
            'tahun_ajaran' => '2025/2026',
            'tipe_semester' => 'genap',
            'batas_pengisian' => '2026-04-30',
            'batas_tgl_nilai' => '2026-06-30',
            'status_krs' => 'buka',
            'status_khs' => 'proses',
        ]);
    }
}
