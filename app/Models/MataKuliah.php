<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $table = 'mata_kuliah';
    protected $primaryKey = 'kode_mk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['kode_mk', 'nama_mk', 'sks', 'semester', 'dosen_nidn'];

    public function dosen() {
        return $this->belongsTo(Dosen::class, 'dosen_nidn', 'nidn');
    }

    public function krs()
    {
        return $this->hasMany(Krs::class, 'mk_kode', 'kode_mk');
    }


    // FUNGSI UNTUK ADMIN || DATA MATAKULIAH


    // Filter pencarian kode, nama mata kuliah, atau semester
    public static function searchMataKuliah($search, $selectedSemester)
    {
        $query = self::with('dosen.user');

        if ($selectedSemester) {
            $query->where('semester', $selectedSemester);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_mk', 'like', '%' . $search . '%')
                ->orWhere('kode_mk', 'like', '%' . $search . '%');
            });
        }

        return $query;
    }

    // Simpan data mata kuliah baru
    public static function simpanMataKuliah(array $data)
    {
        return self::create([
            'kode_mk' => $data['kode_mk'],
            'nama_mk' => $data['nama_mk'],
            'sks' => $data['sks'],
            'semester' => $data['semester'],
            'dosen_nidn' => $data['dosen_nidn'],
        ]);
    }

    // Update data mata kuliah
    public function updateMataKuliah(array $data)
    {
        return $this->update([
            'kode_mk' => $data['kode_mk'],
            'nama_mk' => $data['nama_mk'],
            'sks' => $data['sks'],
            'semester' => $data['semester'],
            'dosen_nidn' => $data['dosen_nidn'],
        ]);
    }


    // FUNGSI UNTUK DOSEN || DASHBOARD & NILAI

    // Mengambil kueri data dashboard dosen
    public static function dataDashboard($nidn)
    {
        return self::where('dosen_nidn', $nidn)
            ->with(['krs.nilai'])
            ->get()
            ->map(function($mk) {
                $totalMhs = $mk->krs->count();

                $mhsPunyaNilai = $mk->krs->filter(function($krsItem) {
                    return isset($krsItem->nilai) &&
                           !is_null($krsItem->nilai->nilai_huruf) &&
                           trim($krsItem->nilai->nilai_huruf) !== '';
                })->count();

                $mk->sudah_input = ($totalMhs > 0 && $totalMhs === $mhsPunyaNilai);
                $mk->rata_rata = $mk->krs->avg('nilai.bobot') ?? 0;

                return $mk;
            });
    }

    // Menghitung statistik dashboard dosen
    public static function hitungStatistik($mataKuliah)
    {
        $jumlahMatkul = $mataKuliah->count();
        $nilaiPending = 0;

        foreach ($mataKuliah as $mk) {
            $totalMhs = $mk->krs->count();
            $mhsPunyaNilai = $mk->krs->filter(function($krsItem) {
                return isset($krsItem->nilai) &&
                       !is_null($krsItem->nilai->nilai_huruf) &&
                       trim($krsItem->nilai->nilai_huruf) !== '';
            })->count();

            $nilaiPending += ($totalMhs - $mhsPunyaNilai);
        }

        return [
            'jumlahMatkul' => $jumlahMatkul,
            'nilaiPending' => $nilaiPending,
            'totalMahasiswa' => $mataKuliah->sum(fn($mk) => $mk->krs->count()),
            'rataRataSemua' => $mataKuliah->avg('rata_rata') ?? 0,
        ];
    }

    // Mengambil kueri data mahasiswa terdaftar
    public static function mhsTerdaftar($kode_mk, $selectedSemester)
    {
        $mahasiswaQuery = Krs::with(['mahasiswa.user', 'nilai'])
            ->where('mk_kode', $kode_mk);

        if ($selectedSemester) {
            $mahasiswaQuery->where('semester', $selectedSemester);
        }

        return $mahasiswaQuery->get();
    }

}
