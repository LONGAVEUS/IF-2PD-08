<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DataAdminController extends Controller
{
    public function tampilAdmin(Request $request)
    {
        $search = $request->query('search');
        $query = User::where('role', 'admin');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%');
            });
        }

        $admin = $query->orderBy('name', 'asc')->paginate(5)->withQueryString();
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
            return back()->withInput()->with('error', 'Gagal! NIP Admin sudah terdaftar.');
        }
        
        return back()->withInput()->withErrors($validator);
    }

        User::create([
            'name' => $request->name,
            'username' => $request->nip,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'status' => $request->status
        ]);

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

        $user->update([
            'name' => $request->name,
            'username' => $request->nip,
            'status' => $request->status,
        ]);

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

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
