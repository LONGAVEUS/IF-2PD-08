@extends('layouts.admin_layout')

@section('content')
<div class="space-y-6">
    <x-management-header title="Manajemen Mata Kuliah" buttonText="Tambah Matkul" targetModal="modalTambahMatkul" />

    {{-- Search Bar --}}
    <form action="{{ route('data_matkul') }}" method="GET"
        class="bg-white border-2 border-indigo-50 rounded-2xl p-4 md:p-5 shadow-sm flex flex-col md:flex-row gap-4 md:items-center justify-between">
        <div class="relative w-full md:w-80">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Kode atau Nama MK..."
                class="block w-full pl-10 pr-3 py-2.5 bg-indigo-50/30 border-2 border-indigo-50 text-gray-900 text-sm rounded-xl outline-none transition">
        </div>
        <x-semester-filter :selectedSemester="$selectedSemester" />
    </form>

    {{-- Tabel Mata Kuliah --}}
    <div class="bg-white border-2 border-indigo-50 rounded-2xl shadow-sm overflow-hidden overflow-x-auto">
        <table class="w-full text-left min-w-[800px]">
            <thead class="bg-indigo-50/50">
                <tr class="text-[11px] font-bold uppercase text-indigo-800 tracking-wider">
                    <th class="px-6 py-5">NO</th>
                    <th class="px-6 py-5">Kode MK</th>
                    <th class="px-6 py-5">Nama Mata Kuliah</th>
                    <th class="px-6 py-5 text-center">SKS</th>
                    <th class="px-6 py-5 text-center">Semester</th>
                    <th class="px-6 py-5">Dosen Pengampu</th>
                    <th class="px-6 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-indigo-50 text-sm">
                @foreach($matkul as $index => $mk)
                <tr class="hover:bg-indigo-50/30 transition-colors">
                    <td class="px-6 py-4 text-gray-400">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-bold text-indigo-700">{{ $mk->kode_mk }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $mk->nama_mk }}</td>
                    <td class="px-6 py-4 text-center font-bold text-gray-600">{{ $mk->sks }}</td>
                    <td class="px-6 py-4 text-center">Semester {{ $mk->semester }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $mk->dosen->user->name ?? 'NIDN: '.$mk->dosen_nidn }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            {{-- Gunakan kode_mk sebagai parameter --}}
                            <button data-modal-target="modalEditMK-{{ $mk->kode_mk }}"
                                data-modal-toggle="modalEditMK-{{ $mk->kode_mk }}"
                                class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                            </button>
                            <form action="{{ route('matkul.destroy', $mk->kode_mk) }}" method="POST"
                                onsubmit="return confirm('Hapus Mata Kuliah {{ $mk->nama_mk }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16" />
                                        </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                {{-- Modal Edit MK --}}
                <x-modal id="modalEditMK-{{ $mk->kode_mk }}" title="Edit Mata Kuliah">
                    <form action="{{ route('matkul.update', $mk->kode_mk) }}" method="POST" class="p-1 space-y-4">
                        @csrf @method('PUT')
                        <div>
                            <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase">Nama Mata
                                Kuliah:</label>
                            <input type="text" name="nama_mk" value="{{ $mk->nama_mk }}" required
                                class="w-full border border-gray-200 rounded-xl p-3 text-sm">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase">Kode
                                    MK:</label>
                                <input type="text" name="kode_mk" value="{{ $mk->kode_mk }}" required
                                    class="w-full border border-gray-200 rounded-xl p-3 text-sm">
                            </div>
                            <div>
                                <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase">SKS:</label>
                                <input type="number" name="sks" value="{{ $mk->sks }}" required
                                    class="w-full border border-gray-200 rounded-xl p-3 text-sm">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase">Semester:</label>
                                <input type="number" name="semester" value="{{ $mk->semester }}" required
                                    class="w-full border border-gray-200 rounded-xl p-3 text-sm">
                            </div>
                            <div>
                                <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase">Dosen
                                    Pengampu:</label>
                                <select name="dosen_nidn" required
                                    class="w-full border border-gray-200 rounded-xl p-3 text-sm font-bold text-indigo-600">
                                    @foreach($allDosen as $d)
                                    <option value="{{ $d->username }}"
                                        {{ $mk->dosen_nidn == $d->username ? 'selected' : '' }}>{{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full bg-indigo-600 text-white font-bold py-3.5 rounded-2xl shadow-lg active:scale-95 transition-all">Simpan
                            Perubahan</button>
                    </form>
                </x-modal>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah Matkul --}}
<x-modal id="modalTambahMatkul" title="Tambah Mata Kuliah">
    <form action="{{ route('matkul.store') }}" method="POST" class="p-1 space-y-4">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase">Kode MK:</label>
                <input type="text" name="kode_mk" placeholder="Contoh: IF101" required
                    class="w-full border border-gray-200 rounded-xl p-3 text-sm">
            </div>
            <div>
                <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase">SKS:</label>
                <input type="number" name="sks" placeholder="Jml SKS" required
                    class="w-full border border-gray-200 rounded-xl p-3 text-sm">
            </div>
        </div>
        <div>
            <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase">Nama Mata Kuliah:</label>
            <input type="text" name="nama_matkul" placeholder="Masukkan Nama Mata Kuliah" required
                class="w-full border border-gray-200 rounded-xl p-3 text-sm">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase">Semester:</label>
                <select name="semester" class="w-full border border-gray-200 rounded-xl p-3 text-sm">
                    @for($i=1; $i<=8; $i++) <option value="{{ $i }}">Semester {{ $i }}</option>
                        @endfor
                </select>
            </div>
            <div>
                <label class="block mb-1.5 text-[11px] font-bold text-indigo-900 uppercase">Dosen Pengampu:</label>
                <select name="user_id" required
                    class="w-full border border-gray-200 rounded-xl p-3 text-sm font-bold text-indigo-600">
                    <option value="">Pilih Dosen</option>
                    @foreach($allDosen as $d)
                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit"
            class="w-full bg-indigo-600 text-white font-bold py-3.5 rounded-2xl shadow-lg active:scale-95 transition-all">Simpan
            Mata Kuliah</button>
    </form>
</x-modal>
@endsection
