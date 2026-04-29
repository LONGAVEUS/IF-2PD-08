<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataDosenController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = User::where('role', 'dosen')->with('dosen');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('dosen', function($dq) use ($search) {
                    $dq->where('nidn', 'like', '%' . $search . '%');
                });
            });
        }

        $dosen = $query->orderBy('name', 'asc')->get();
        return view('pages.admin.data_dosen', compact('dosen', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nidn' => 'required|unique:dosen,nidn',
            'name' => 'required',
            'jurusan' => 'required',
            'password' => 'required|min:5',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->nidn,
            'password' => Hash::make($request->password),
            'role' => 'dosen',
            'status' => $request->status
        ]);

        // Simpan ke tabel dosen (sesuaikan dengan migration dosen)
        \App\Models\Dosen::create([
            'user_id' => $user->id,
            'nidn' => $request->nidn,
            'jurusan' => $request->jurusan
        ]);

        return back()->with('success', 'Dosen berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'nidn' => 'required|unique:dosen,nidn,' . $user->dosen->user_id . ',user_id',
            'name' => 'required',
            'jurusan' => 'required',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        $user->update(['name' => $request->name, 'status' => $request->status]);

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->dosen->update([
            'nidn' => $request->nidn,
            'jurusan' => $request->jurusan
        ]);

        return redirect()->route('data_dosen')->with('success', 'Data dosen berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->dosen) { $user->dosen->delete(); }
        $user->delete();
        return redirect()->route('data_dosen')->with('success', 'Data dosen berhasil dihapus!');
    }
}
