<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataDosenController extends Controller
{
    // Read - menampilkan daftar dosen
    public function tampilDosen(Request $request)
    {
        $search = $request->query('search');

        $dosen = Dosen::searchDosen($search)->orderBy('username', 'asc')->paginate(5)->withQueryString();

        return view('pages.admin.data_dosen', compact('dosen', 'search'));
    }

    // Create - Menambahkan dosen baru
    public function tambahDosen(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nidn' => 'required|unique:dosen,nidn|max:20',
            'name' => 'required',
            'jurusan' => 'required',
            'password' => 'required|min:5',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        if ($validator->fails()) {
        if ($validator->errors()->has('nidn')) {
            return back()->withInput()->with('error', 'NIDN/NIP dosen sudah terdaftar.');
        }

        return back()->withInput()->withErrors($validator);
    }


        Dosen::simpanDosen($request->all());

        return back()->with('success', 'Dosen berhasil ditambahkan!');
    }

    // Update - Mengubah data dosen
    public function ubahDosen(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'nidn' => 'required|unique:dosen,nidn,' . $user->dosen->user_id . ',user_id|max:20',
            'name' => 'required',
            'jurusan' => 'required',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        $user->dosen->updateDosen($request->all());

        return redirect()->route('data_dosen')->with('success', 'Data dosen berhasil diperbarui!');
    }

    // Delete - Menghapus data dosen
    public function hapusDosen($id)
    {
        $user = User::findOrFail($id);

        if ($user->dosen)
        { $user->dosen->delete(); }

        $user->delete();
        return redirect()->route('data_dosen')->with('success', 'Data dosen berhasil dihapus!');
    }
}
