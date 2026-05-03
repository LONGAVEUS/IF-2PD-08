@extends('layouts.admin_layout')

@section('content')
<div class="space-y-6">
    <x-management-header title="Manajemen Data Dosen" buttonText="Tambah Dosen" targetModal="modalTambahDosen" />

    {{-- Search Bar --}}
    <form action="{{ route('data_dosen') }}" method="GET" class="bg-white border-2 border-indigo-50 rounded-2xl p-4 shadow-sm flex items-center justify-between">
        <div class="relative w-full md:w-80">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIDN atau Nama..." class="block w-full pl-10 pr-3 py-2.5 bg-indigo-50/30 border-2 border-indigo-50 text-gray-900 text-sm rounded-xl outline-none">
        </div>
    </form>

    {{-- Tabel Dosen --}}
    <div class="bg-white border-2 border-indigo-50 rounded-2xl shadow-sm overflow-hidden overflow-x-auto">
    <table class="w-full text-left min-w-[800px]">
        <thead class="bg-indigo-50/50">
            <tr class="text-[11px] font-bold uppercase text-indigo-800 tracking-wider">
                <th class="px-6 py-5">NO</th>
                <th class="px-6 py-5">NIDN</th>
                <th class="px-6 py-5">Nama Lengkap</th>
                <th class="px-6 py-5">Jurusan</th>
                <th class="px-6 py-5 text-center">Status</th>
                <th class="px-6 py-5 text-center">Aksi</th>
            </tr>
        </thead>
            <tbody class="divide-y divide-indigo-50 text-sm">
                @foreach($dosen as $index => $d)
                <tr class="hover:bg-indigo-50/30 transition-colors">
                    <td class="px-6 py-4 text-gray-400">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-bold text-indigo-700">{{ $d->dosen->nidn }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $d->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $d->dosen->jurusan }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $d->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ strtoupper(str_replace('_', ' ', $d->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <button data-modal-target="modalEdit-{{ $d->id }}" data-modal-toggle="modalEdit-{{ $d->id }}" class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <form action="{{ route('dosen.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Hapus data dosen {{ $d->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                {{-- Modal Edit Dosen --}}
                <x-modal id="modalEdit-{{ $d->id }}" title="Edit Data Dosen">
                    <form action="{{ route('dosen.update', $d->id) }}" method="POST" class="p-0.5">
                        @csrf @method('PUT')

                        {{-- NIDN --}}
                        <div class="mb-5">
                            <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase tracking-wider">NIDN:</label>
                            <input type="text" name="nidn" value="{{ $d->dosen->nidn }}" required
                                class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 p-3 outline-none transition-all">
                        </div>

                        {{-- Nama Dosen --}}
                        <div class="mb-5">
                            <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase tracking-wider">Nama Dosen:</label>
                            <input type="text" name="name" value="{{ $d->name }}" required
                                class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 p-3 outline-none transition-all">
                        </div>

                        {{-- Jurusan --}}
                        <div class="mb-5">
                            <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase tracking-wider">Jurusan:</label>
                            <select name="jurusan" required class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3 outline-none focus:border-indigo-500 appearance-none">
                                <option value="Teknik Informatika" {{ $d->dosen->jurusan == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                <option value="Sistem Informasi" {{ $d->dosen->jurusan == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                            </select>
                        </div>

                        {{-- Grid Password & Status --}}
                        <div class="grid grid-cols-2 gap-4 mb-7">
                            <div>
                                <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase tracking-wider">Password:</label>
                                <input type="password" name="password" placeholder="Kosongkan jika tetap"
                                    class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 p-3 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase tracking-wider">Status:</label>
                                <select name="status" class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3 outline-none font-bold text-indigo-600">
                                    <option value="aktif" {{ $d->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="tidak_aktif" {{ $d->status == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                        </div>

                        {{-- Tombol Perbarui --}}
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-2xl shadow-lg shadow-indigo-500/20 transition-all active:scale-95">
                            Perbarui Data Dosen
                        </button>
                    </form>
                </x-modal>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah Dosen --}}
<x-modal id="modalTambahDosen" title="Tambah Dosen">
    <form action="{{ route('dosen.store') }}" method="POST" class="p-1 space-y-4">
        @csrf
        <div>
            <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase">NIDN:</label>
            <input type="text" name="nidn" placeholder="Tambah NIDN Dosen" required class="w-full border border-gray-200 rounded-xl p-3 text-sm">
        </div>
        <div>
            <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase">Nama Dosen:</label>
            <input type="text" name="name" placeholder="Tambah Nama Dosen" required class="w-full border border-gray-200 rounded-xl p-3 text-sm">
        </div>
        <div>
            <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase">Jurusan:</label>
            <select name="jurusan" required class="w-full border border-gray-200 rounded-xl p-3 text-sm">
                <option value="">Pilih Jurusan</option>
                <option value="Teknik Informatika">Teknik Informatika</option>
                <option value="Manajemen Bisnis">Manajemen Bisnis</option>
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase">Password:</label>
                <input type="password" name="password" placeholder="Password" required class="w-full border border-gray-200 rounded-xl p-3 text-sm">
            </div>
            <div>
                <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase">Status:</label>
                <select name="status" class="w-full border border-gray-200 rounded-xl p-3 text-sm font-bold text-indigo-600">
                    <option value="aktif">Aktif</option>
                    <option value="tidak_aktif">Tidak Aktif</option>
                </select>
            </div>
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3.5 rounded-2xl active:scale-95 transition-all">Simpan</button>
    </form>
</x-modal>
@endsection
