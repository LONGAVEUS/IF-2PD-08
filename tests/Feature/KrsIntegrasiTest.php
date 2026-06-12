<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Krs;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KrsIntegrasiTest extends TestCase
{
    // Menggunakan RefreshDatabase agar data uji coba otomatis terhapus
    // setelah tes selesai dan tidak mengotori database aslimu
    use RefreshDatabase;

    /** @test */
    public function test_simulasi_mahasiswa_mengisi_krs_sampai_muncul_khs()
    {
        // 1. MEMBUAT DATA DAFTAR KANDIDAT DI DATABASE TIRUAN
        // Membuat user dengan role mahasiswa
        $user = User::create([
            'name' => 'Arnol Hutagalung',
            'username' => 'arnol123',
            'password' => bcrypt('password'),
            'role' => 'mahasiswa',
            'status' => 'aktif'
        ]);

        // Membuat data profile mahasiswa terkait
        $mahasiswa = Mahasiswa::create([
            'nim' => '3312511130',
            'user_id' => $user->id,
            'prodi' => 'Teknik Informatika',
            'semester_ke' => 3
        ]);

        $userDosen = User::create([
            'name' => 'Dosen PBO',
            'username' => 'dosenpbo',
            'password' => bcrypt('password'),
            'role' => 'dosen',
            'status' => 'aktif'
        ]);

        // Daftarkan NIDN '123456' ke dalam tabel dosen secara fisik
        \App\Models\Dosen::create([
            'nidn' => '123456',
            'user_id' => $userDosen->id,
            'jurusan' => 'Teknik Informatika'
        ]);

        // Membuat data mata kuliah tiruan yang tersedia di semester 3
        $matkul = MataKuliah::create([
            'kode_mk' => 'IF301',
            'nama_mk' => 'Pemrograman Berorientasi Objek',
            'sks' => 4,
            'semester' => 3,
            'dosen_nidn' => '123456'
        ]);

        // 2. ROBOT BERAKSI (SIMULASI PENGGUNA)
        // Robot bertindak sebagai user yang login, lalu membuka halaman View isi KRS
        // 1. Perbaiki Baris 65: Tambahkan 'mahasiswa/' di depan URL GET
        // 1. Perbaiki Baris 66: Gunakan isi_krs (bukan isiKrs)
        $responseView = $this->actingAs($user)->get('mahasiswa/isi_krs');

        // Memeriksa apakah halaman View KRS sukses terbuka
        $responseView->assertStatus(200);

        // 2. Perbaiki Baris 71: Gunakan rute POST tambah matkul kalian yang asli
        $responseController = $this->actingAs($user)->post('mahasiswa/krs/tambah', [
            'kode_mk' => 'IF301'
        ]);
        // 3. VERIFIKASI INTEGRASI DATA
        // Memeriksa apakah data KRS otomatis berhasil tersimpan ke dalam tabel Model KRS
        $this->assertDatabaseHas('krs', [
            'mahasiswa_nim' => '3312511130',
            'mk_kode' => 'IF301',
            'semester' => 3
        ]);

        // Memeriksa apakah setelah sukses, Controller melempar kembali ke halaman KRS dengan pesan sukses
        $responseController->assertRedirect();
        $responseController->assertSessionHas('success', 'Mata kuliah berhasil ditambahkan ke rencana studi Anda!');
    }
}
