<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\MataKuliah;
use App\Models\Nilai;

require_once __DIR__ . '/../../app/Models/MataKuliah.php';
require_once __DIR__ . '/../../app/Models/nilai.php';

class AturanAkademikTest extends TestCase
{
    /** @test */
    public function test_validasi_kurikulum_harus_menolak_sks_negatif()
    {
        // 1. Instansiasi objek dari class AturanKurikulumNasional yang ada di Model MataKuliah
        // Kita sengaja memasukkan angka SKS negatif (-3) untuk menguji kekuatannya
        $validator = new \App\Models\AturanKurikulumNasional('IF101', -3);

        // 2. Kita menegaskan (assert) bahwa hasilnya HARUS bernilai false (ditolak)
        $this->assertFalse($validator->validasiKelayakan());
    }

    /** @test */
    public function test_validasi_kurikulum_harus_menolak_kode_mk_diawali_angka()
    {
        // Kita sengaja memasukkan kode mata kuliah yang diawali angka "3" (Salah)
        $validator = new \App\Models\AturanKurikulumNasional('331IF', 3);

        // Kita menegaskan bahwa hasilnya HARUS bernilai false (ditolak)
        $this->assertFalse($validator->validasiKelayakan());
    }

    /** @test */
    public function test_konverter_nilai_harus_menghasilkan_grade_a()
    {
        // 1. Instansiasi objek dari class KonverterNilaiResmi yang ada di Model Nilai
        // Kita masukkan angka nilai 88 dari dosen
        $evaluasi = new \App\Models\KonverterNilaiResmi(88);
        $hasil = $evaluasi->hitungGrade();

        // 2. Kita menegaskan bahwa huruf yang keluar harus 'A' dan bobotnya harus 4.0
        $this->assertEquals('A', $hasil['huruf']);
        $this->assertEquals(4.0, $hasil['bobot']);
    }
}
