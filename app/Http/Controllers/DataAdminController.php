<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DataAdminController extends Controller
{
    public function tampilAdmin(Request $request)
    {
        $search = $request->query('search');

        $admin = User::searchAdmin($search)->orderBy('name', 'asc')->paginate(5)->withQueryString();
        return view('pages.admin.data_admin', compact('admin', 'search'));
    }

    public function tambahAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|unique:users,username|max:20',
            'name' => 'required',
            'password' => 'required|min:5',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        if ($validator->fails()) {
        if ($validator->errors()->has('nip')) {
            return back()->withInput()->with('error', 'NIP Admin sudah terdaftar.');
        }

        return back()->withInput()->withErrors($validator);
    }

        User::simpanAdmin($request->all());

        return back()->with('success', 'Admin berhasil ditambahkan!');
    }

    public function ubahAdmin(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nip' => 'required|unique:users,username,' . $id . '|max:20',
            'name' => 'required',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        $user->updateAdmin($request->all());

        return redirect()->route('data_admin')->with('success', 'Data admin berhasil diperbarui!');
    }

    public function hapusAdmin($id)
    {
        $user = User::findOrFail($id);


        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $user->delete();
        return redirect()->route('data_admin')->with('success', 'Admin berhasil dihapus!');
    }
}
