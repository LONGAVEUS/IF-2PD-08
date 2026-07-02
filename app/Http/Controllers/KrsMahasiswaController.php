<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MataKuliah;
use App\Models\Krs;

class KrsMahasiswaController extends Controller
{
    // Read - Menampilkan halaman pengisian KRS mahasiswa
    public function isiKrs()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $mataKuliahTerdaftar = Krs::with('mata_kuliah.dosen.user')->where('mahasiswa_nim', $mahasiswa->nim)->where('semester', $mahasiswa->semester_ke)->get();
        $sudahDipilihCodes = $mataKuliahTerdaftar->pluck('mk_kode')->toArray();
        $mataKuliahTersedia = MataKuliah::with('dosen.user')->where('semester', $mahasiswa->semester_ke)->whereNotIn('kode_mk', $sudahDipilihCodes)->get();

        $infoKrs = Krs::krsLalu($mahasiswa);

        return view('pages.mahasiswa.isi_krs', compact('infoKrs', 'mataKuliahTerdaftar', 'mataKuliahTersedia'));
    }

    // Create - Menambahkan mata kuliah ke KRS mahasiswa
    public function tambahMataKuliah(Request $request)
    {
        $request->validate(['kode_mk' => 'required']);
        $hasil = Krs::tambahKrs(Auth::user()->mahasiswa, $request->kode_mk);
        return redirect()->back()->with($hasil['status'], $hasil['pesan']);
    }

    // Update - Menyimpan KRS mahasiswa
    public function simpanKrs()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        if (!Krs::inisialisasiNilai($mahasiswa)) {
            return redirect()->back()->with('error', 'Belum ada mata kuliah yang dipilih.');
        }
        return redirect()->route('lihat_khs', ['semester' => $mahasiswa->semester_ke])->with('success', 'KRS berhasil disimpan!');
    }

    // Delete - Membatalkan pilihan mata kuliah
    public function hapusMataKuliah($id)
    {
        $krsItem = Krs::where('id_krs', $id)->first();

        if ($krsItem) {
            $krsItem->delete();
            return redirect()->back()->with('success', 'Mata kuliah berhasil dibatalkan dari KRS.');
        }

        return redirect()->back()->with('error', 'Data KRS gagal ditemukan atau sudah dihapus.');
    }
}
