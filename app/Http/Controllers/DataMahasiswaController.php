<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataMahasiswaController extends Controller
{
    public function tampilMahasiswa(Request $request)
    {
        $selectedSemester = $request->query('semester');
        $search = $request->query('search');
        $mahasiswa = Mahasiswa::searchMahasiswa($search, $selectedSemester)
            ->orderBy('name', 'asc')
            ->paginate(5)
            ->withQueryString();

        return view('pages.admin.data_mahasiswa', compact('mahasiswa', 'selectedSemester', 'search'));
    }

    public function tambahMahasiswa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|unique:mahasiswa,nim|max:15',
            'name' => 'required',
            'prodi' => 'required',
            'password' => 'required|min:5',
            'semester_ke' => 'required',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        if ($validator->fails()) {

            if ($validator->errors()->has('nim')) {
                return back()->withInput()->with('error', 'Gagal! NIM mahasiswa sudah terdaftar.');
            }
            return back()->withInput()->withErrors($validator);
        }

        Mahasiswa::simpanMahasiswa($request->all());

        return back()->with('success', 'Berhasil! Mahasiswa berhasil ditambahkan!');
    }

    public function ubahMahasiswa(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nim' => 'required|unique:mahasiswa,nim,' . $user->mahasiswa->user_id . ',user_id|max:15',
            'name' => 'required',
            'prodi' => 'required',
            'semester_ke' => 'required',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        $user->mahasiswa->updateMahasiswa($request->all());

        return redirect()->route('data_mahasiswa')->with('success', 'Berhasil! Data mahasiswa berhasil diperbarui!.');
    }

    public function hapusMahasiswa($id)
    {
        $user = User::findOrFail($id);

        // Hapus data profil mahasiswa dulu baru akun user utamanya
        if ($user->mahasiswa) {
            $user->mahasiswa->delete();
        }
        $user->delete();

        return redirect()->route('data_mahasiswa')->with('success', 'Berhasil! Data mahasiswa berhasil dihapus!');
    }
}
