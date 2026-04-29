<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Http\Request;

class DataMataKuliahController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $selectedSemester = $request->query('semester'); 

        $query = MataKuliah::with('dosen.user');

        // Filter berdasarkan semester
        if ($selectedSemester) {
            $query->where('semester', $selectedSemester);
        }

        // Pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_mk', 'like', '%' . $search . '%')
                ->orWhere('kode_mk', 'like', '%' . $search . '%');
            });
        }

        $matkul = $query->orderBy('semester', 'asc')->get();
        $allDosen = User::where('role', 'dosen')->get();

        return view('pages.admin.data_matkul', compact('matkul', 'allDosen', 'search', 'selectedSemester'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mk' => 'required|unique:mata_kuliahs,kode_mk',
            'nama_mk' => 'required',
            'sks' => 'required|numeric',
            'semester' => 'required|numeric',
            'dosen_nidn' => 'required'
        ]);

        MataKuliah::create($request->all());

        return back()->with('success', 'Mata kuliah berhasil ditambahkan!');
    }

    public function update(Request $request, $kode_mk)
    {
        // Cari MK berdasarkan kode_mk karena tidak ada kolom 'id'
        $mk = MataKuliah::where('kode_mk', $kode_mk)->firstOrFail();

        $request->validate([
            'kode_mk' => 'required|unique:mata_kuliahs,kode_mk,' . $kode_mk . ',kode_mk',
            'nama_mk' => 'required',
            'sks' => 'required|numeric',
            'semester' => 'required|numeric',
            'dosen_nidn' => 'required'
        ]);

        $mk->update($request->all());

        return back()->with('success', 'Data mata kuliah berhasil diperbarui!');
    }

    public function destroy($kode_mk)
    {
        MataKuliah::where('kode_mk', $kode_mk)->delete();
        return back()->with('success', 'Mata kuliah berhasil dihapus!');
    }
}
