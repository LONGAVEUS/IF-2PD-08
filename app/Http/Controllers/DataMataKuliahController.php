<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Http\Request;

class DataMataKuliahController extends Controller
{
    public function tampilMatkul(Request $request)
    {
        $search = $request->query('search');
        $selectedSemester = $request->query('semester');

        $query = MataKuliah::with('dosen.user');

        if ($selectedSemester) {
            $query->where('semester', $selectedSemester);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_mk', 'like', '%' . $search . '%')
                ->orWhere('kode_mk', 'like', '%' . $search . '%');
            });
        }

        $matkul = $query->orderBy('semester', 'asc')->paginate(5)->withQueryString();
        $allDosen = User::where('role', 'dosen')->where('status', 'aktif')->get();

        return view('pages.admin.data_matkul', compact(
            'matkul',
            'allDosen',
            'search',
            'selectedSemester'
        ));
    }

    public function tambahMatkul(Request $request)
    {
        $request->validate([
            'kode_mk' => 'required|unique:mata_kuliah,kode_mk',
            'nama_mk' => 'required',
            'sks' => 'required|numeric',
            'semester' => 'required|numeric',
            'dosen_nidn' => 'required'
        ]);

        $validatorAkademik = new AturanKurikulumNasional($request->kode_mk, $request->sks);
        if (!$validatorAkademik->validasiKelayakan()) {
            return back()->with('error', 'Gagal: Kode Mata Kuliah wajib diawali huruf atau SKS bernilai negatif!');
        }

        MataKuliah::create($request->all());

        return back()->with('success', 'Mata kuliah berhasil ditambahkan!');
    }

    public function ubahMatkul(Request $request, $kode_mk)
    {
        $mk = MataKuliah::where('kode_mk', $kode_mk)->firstOrFail();

        $request->validate([
            'kode_mk' => 'required|unique:mata_kuliah,kode_mk,' . $kode_mk . ',kode_mk',
            'nama_mk' => 'required',
            'sks' => 'required|numeric',
            'semester' => 'required|numeric',
            'dosen_nidn' => 'required'
        ]);

        try {
            $validatorAkademik = new AturanKurikulumNasional($request->kode_mk, $request->sks);
            if (!$validatorAkademik->validasiKelayakan()) {
                return back()->with('error', 'Gagal: Kode Mata Kuliah wajib diawali huruf atau SKS bernilai negatif!');
            }

            $mk->update($request->all());

            return back()->with('success', 'Data mata kuliah berhasil diperbarui!');

        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return back()->with('error', 'Mata kuliah sedang berjalan di KRS mahasiswa! Kode MK tidak dapat diubah.');
            }
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function hapusMatkul($kode_mk)
    {
        MataKuliah::where('kode_mk', $kode_mk)->delete();

        return back()->with('success', 'Mata kuliah berhasil dihapus!');
    }
}

abstract class StandarKurikulum
{
    protected $kodeMk;
    protected $sks;

    public function __construct($kodeMk, $sks)
    {
        $this->kodeMk = $kodeMk;
        $this->sks = (int) $sks;
    }

    abstract public function validasiKelayakan();
}

class AturanKurikulumNasional extends StandarKurikulum
{
    public function validasiKelayakan()
    {
        if ($this->sks < 0) {
            return false;
        }

        if (is_numeric(substr($this->kodeMk, 0, 1))) {
            return false;
        }

        return true;
    }
}
