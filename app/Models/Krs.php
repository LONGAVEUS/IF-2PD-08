<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory;

    protected $table = 'krs';
    protected $primaryKey = 'id_krs';

    protected $fillable = [
        'mahasiswa_nim',
        'mk_kode',
        'semester',
    ];

    public function mata_kuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mk_kode', 'kode_mk');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_nim', 'nim');
    }

    public function nilai()
    {
        return $this->hasOne(Nilai::class, 'krs_id', 'id_krs');
    }

    // Ambil data KHS
    public static function ambilKhs($nim, $semester)
    {
        return Nilai::with(['krs' => function($query) use ($nim, $semester) {
            $query->where('mahasiswa_nim', $nim)->where('semester', $semester);
        }, 'krs.mata_kuliah'])
        ->whereHas('krs', function($query) use ($nim, $semester) {
            $query->where('mahasiswa_nim', $nim)->where('semester', $semester);
        })->get();
    }

    // Hitung IPK rill
    public static function hitungIpk($nim)
    {
        $semuaNilai = Nilai::whereHas('krs', function($query) use ($nim) {
            $query->where('mahasiswa_nim', $nim);
        })->whereNotNull('bobot')->get();

        $totalSks = $semuaNilai->sum(fn($n) => $n->krs->mata_kuliah->sks ?? 0);
        $totalKn = $semuaNilai->sum(fn($n) => ($n->krs->mata_kuliah->sks ?? 0) * ($n->bobot ?? 0));

        return $totalSks > 0 ? round($totalKn / $totalSks, 2) : 0.00;
    }

    // Data KRS lalu
    public static function krsLalu($mahasiswa)
    {
        $nilaiLalu = Nilai::whereHas('krs', function($query) use ($mahasiswa) {
            $query->where('mahasiswa_nim', $mahasiswa->nim)->where('semester', '<', $mahasiswa->semester_ke);
        })->whereNotNull('bobot')->get();

        $totalSksLalu = $nilaiLalu->sum(fn($n) => $n->krs->mata_kuliah->sks ?? 0);
        $totalKnLalu = $nilaiLalu->sum(fn($n) => ($n->krs->mata_kuliah->sks ?? 0) * ($n->bobot ?? 0));
        $ipkLalu = $totalSksLalu > 0 ? round($totalKnLalu / $totalSksLalu, 2) : 0.00;

        $semesterLalu = $mahasiswa->semester_ke - 1;
        $nilaiSemesterLalu = $nilaiLalu->filter(fn($n) => $n->krs->semester == $semesterLalu);

        $totalSksSemesterLalu = $nilaiSemesterLalu->sum(fn($n) => $n->krs->mata_kuliah->sks ?? 0);
        $totalKnSemesterLalu = $nilaiSemesterLalu->sum(fn($n) => ($n->krs->mata_kuliah->sks ?? 0) * ($n->bobot ?? 0));
        $ipsLalu = $totalSksSemesterLalu > 0 ? round($totalKnSemesterLalu / $totalSksSemesterLalu, 2) : 0.00;

        return [
            'semester_aktif' => "Semester " . $mahasiswa->semester_ke,
            'nim'            => $mahasiswa->nim,
            'ipk'            => number_format($ipkLalu, 2),
            'ips'            => number_format($ipsLalu, 2),
        ];
    }

    // Data Dashboard
    public static function dataDashboard($nim, $semesterAktif)
    {
        $krsAktif = self::where('mahasiswa_nim', $nim)->where('semester', $semesterAktif)->with(['nilai', 'mata_kuliah'])->get();
        $totalSks = $krsAktif->sum(fn($k) => $k->mata_kuliah->sks ?? 0);
        $totalKn = $krsAktif->sum(fn($k) => ($k->mata_kuliah->sks ?? 0) * ($k->nilai?->bobot ?? 0));

        return [
            'ips'            => $totalSks > 0 ? round($totalKn / $totalSks, 2) : 0.00,
            'ipk'            => self::hitungIpk($nim),
            'totalSks'       => $totalSks,
            'sksMax'         => 24,
            'jumlahSemester' => self::where('mahasiswa_nim', $nim)->distinct('semester')->count('semester')
        ];
    }

    // Tambah KRS
    public static function tambahKrs($mahasiswa, $kodeMk)
    {
        $sudahAda = self::where('mahasiswa_nim', $mahasiswa->nim)
        ->where('mk_kode', $kodeMk)
        ->where('semester', $mahasiswa->semester_ke)
        ->exists();

        if ($sudahAda) {
            return ['status' => 'error', 'pesan' => 'Mata kuliah ini sudah ditambahkan ke dalam rencana studi Anda!'];
        }

        $sksSekarang = self::with('mata_kuliah')->where('mahasiswa_nim', $mahasiswa->nim)->where('semester', $mahasiswa->semester_ke)
        ->get()
        ->sum(fn($k) => $k->mata_kuliah->sks ?? 0);

        $matkulBaru = MataKuliah::where('kode_mk', $kodeMk)->firstOrFail();
        if (($sksSekarang + $matkulBaru->sks) > 24) {
            return ['status' => 'error', 'pesan' => 'Tidak dapat mengambil matakuliah lewat dari maksimum sks!'];
        }

        self::create(['mahasiswa_nim' => $mahasiswa->nim, 'mk_kode' => $kodeMk, 'semester' => $mahasiswa->semester_ke]);
        return ['status' => 'success', 'pesan' => 'Mata kuliah berhasil ditambahkan ke rencana studi Anda!'];
    }

    // Inisialisasi Nilai
    public static function inisialisasiNilai($mahasiswa)
    {
        $krsAktif = self::where('mahasiswa_nim', $mahasiswa->nim)
        ->where('semester', $mahasiswa->semester_ke)->get();
        if ($krsAktif->isEmpty()) return false;

        foreach ($krsAktif as $krs) {
            if (!Nilai::where('krs_id', $krs->id_krs)->exists()) {
                $drafObjek = new DrafNilaiBaru($krs->id_krs);
                $nilaiDefault = $drafObjek->setNilaiDefault();
                Nilai::create([
                    'krs_id'      => $krs->id_krs,
                    'nilai_huruf' => $nilaiDefault['huruf'],
                    'bobot'       => $nilaiDefault['bobot']
                ]);
            }
        }
        return true;
    }
}

abstract class NilaiAkademik
{
    protected $krsId;

    public function __construct($krsId)
    {
        $this->krsId = $krsId;
    }

    abstract public function setNilaiDefault();
}

class DrafNilaiBaru extends NilaiAkademik
{
    public function setNilaiDefault()
    {
        return [
            'huruf' => null,
            'bobot' => null
        ];
    }
}
