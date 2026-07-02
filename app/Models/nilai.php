<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';
    protected $primaryKey = 'id_nilai';
    protected $fillable = ['krs_id', 'nilai_huruf', 'bobot'];

    public function krs()
    {
        return $this->belongsTo(Krs::class, 'krs_id', 'id_krs');
    }

    // Simpan data massal nilai mahasiswa
    public static function simpanBanyakNilai(array $krsIds, array $nilaiAngkas)
    {
        foreach ($krsIds as $i => $krsId) {
            $angka = $nilaiAngkas[$i];

            if ($angka === null || $angka === '') continue;

            $evaluasi = new KonverterNilaiResmi($angka);
            $hasilGrading = $evaluasi->hitungGrade();

            self::updateOrCreate(
                ['krs_id' => $krsId],
                [
                    'nilai_huruf' => $hasilGrading['huruf'],
                    'bobot' => $hasilGrading['bobot']
                ]
            );
        }
    }
}

abstract class EvaluasiAkademik
{
    protected $nilaiAngka;

    public function __construct($nilaiAngka)
    {
        $this->nilaiAngka = (int) $nilaiAngka;
    }

    abstract public function hitungGrade();
}

class KonverterNilaiResmi extends EvaluasiAkademik
{
    public function hitungGrade()
    {
        if ($this->nilaiAngka >= 85) {
            return ['huruf' => 'A', 'bobot' => 4.0];
        } elseif ($this->nilaiAngka >= 80) {
            return ['huruf' => 'A-', 'bobot' => 3.7];
        } elseif ($this->nilaiAngka >= 75) {
            return ['huruf' => 'B+', 'bobot' => 3.3];
        } elseif ($this->nilaiAngka >= 70) {
            return ['huruf' => 'B', 'bobot' => 3.0];
        } elseif ($this->nilaiAngka >= 65) {
            return ['huruf' => 'B-', 'bobot' => 2.7];
        } elseif ($this->nilaiAngka >= 60) {
            return ['huruf' => 'C+', 'bobot' => 2.3];
        } elseif ($this->nilaiAngka >= 55) {
            return ['huruf' => 'C', 'bobot' => 2.0];
        } elseif ($this->nilaiAngka >= 50) {
            return ['huruf' => 'C-', 'bobot' => 1.7];
        } elseif ($this->nilaiAngka >= 45) {
            return ['huruf' => 'D+', 'bobot' => 1.3];
        } elseif ($this->nilaiAngka >= 40) {
            return ['huruf' => 'D', 'bobot' => 1.0];
        } else {
            return ['huruf' => 'E', 'bobot' => 0.0];
        }
    }
}
