<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $selectedSemester = $request->query('semester');
        $search = $request->query('search');

        $query = User::where('role', 'mahasiswa')->with('mahasiswa');

        if ($selectedSemester) {
            $query->whereHas('mahasiswa', function($q) use ($selectedSemester) {
                $q->where('semester_ke', $selectedSemester);
            });
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('mahasiswa', function($mq) use ($search) {
                    $mq->where('nim', 'like', '%' . $search . '%');
                });
            });
        }

        $mahasiswa = $query->get();

        return view('pages.admin.data_mahasiswa', compact('mahasiswa', 'selectedSemester', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswa,nim',
            'name' => 'required',
            'password' => 'required|min:5',
            'semester_ke' => 'required',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->nim,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
            'status' => $request->status
        ]);

        Mahasiswa::create([
            'user_id' => $user->id,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'semester_ke' => $request->semester_ke
        ]);

        return back()->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'nim' => 'required|unique:mahasiswa,nim,' . $user->mahasiswa->user_id . ',user_id',
            'name' => 'required',
            'prodi' => 'required',
            'semester_ke' => 'required',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        $user->update(['name' => $request->name, 'status' => $request->status]);

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->mahasiswa->update([
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'semester_ke' => $request->semester_ke
        ]);

        return redirect()->route('data_mahasiswa')->with('success', 'Data mahasiswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->mahasiswa) { $user->mahasiswa->delete(); }
        $user->delete();
        return redirect()->route('data_mahasiswa')->with('success', 'Data mahasiswa berhasil dihapus!');
    }
}
