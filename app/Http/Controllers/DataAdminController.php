<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DataAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = User::where('role', 'admin');

        // Pencarian berdasarkan NIP (username) atau Nama
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%');
            });
        }

        $admin = $query->orderBy('name', 'asc')->get();
        return view('pages.admin.data_admin', compact('admin', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:users,username',
            'name' => 'required',
            'password' => 'required|min:5',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->nip, // NIP disimpan sebagai username
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'status' => $request->status
        ]);

        return back()->with('success', 'Admin berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nip' => 'required|unique:users,username,' . $id,
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

    public function destroy($id)
    {
        $user = User::findOrFail($id);


        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $user->delete();
        return redirect()->route('data_admin')->with('success', 'Admin berhasil dihapus!');
    }
}
