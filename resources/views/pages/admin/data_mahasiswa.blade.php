@extends('layouts.admin_layout')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <x-management-header title="Manajemen Data Mahasiswa" buttonText="Tambah Mahasiswa" targetModal="modalTambah" />

    <form action="{{ route('data_mahasiswa') }}" method="GET"
        class="bg-white border-2 border-indigo-50 rounded-2xl p-4 md:p-5 shadow-sm flex flex-col md:flex-row gap-4 md:items-center justify-between">

        {{-- Input Pencarian untuk mencari berdasarkan nim atau nama--}}
        <div class="relative w-full md:w-80">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            {{-- tambahkan name="search" dan value agar teks tidak hilang setelah loading --}}
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIM atau Nama..."
                class="block w-full pl-10 pr-3 py-2.5 bg-indigo-50/30 border-2 border-indigo-50 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
        </div>
        <x-semester-filter :selectedSemester="$selectedSemester" />
    </form>

    {{-- Tabel Mahasiswa --}}
    <div class="bg-white border-2 border-indigo-50 rounded-2xl shadow-sm overflow-hidden overflow-x-auto">
        <table class="w-full text-left min-w-[800px]">
            <thead class="bg-indigo-50/50">
                <tr class="text-[11px] font-bold uppercase text-indigo-800 tracking-wider">
                    <th class="px-6 py-5">NO</th>
                    <th class="px-6 py-5">NIM</th>
                    <th class="px-6 py-5">Nama Lengkap</th>
                    <th class="px-6 py-5">Program Studi</th>
                    <th class="px-6 py-5 text-center">Status</th>
                    <th class="px-6 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-indigo-50 text-sm">
                @foreach($mahasiswa as $index => $m)
                <tr class="hover:bg-indigo-50/30 transition-colors">
                    <td class="px-6 py-4 text-gray-400">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-bold text-gray-700">{{ $m->mahasiswa->nim }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $m->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $m->mahasiswa->prodi }}</td>
                    <td class="px-6 py-4 text-center">
                        <span
                            class="px-3 py-1 rounded-full text-[10px] font-bold {{ $m->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ strtoupper($m->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">

                            <button data-modal-target="modalEdit-{{ $m->id }}"
                                data-modal-toggle="modalEdit-{{ $m->id }}"
                                class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                            </button>

                            <form action="{{ route('mahasiswa.destroy', $m->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data mahasiswa {{ $m->name }}? Semua data akademik terkait juga akan terhapus.')">
                                @csrf
                                @method('DELETE')
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

                    {{--Pop up style untuk menambahkan mengedit--}}
                    <x-modal id="modalEdit-{{ $m->id }}" title="Edit Data Mahasiswa">
                        <form action="{{ route('mahasiswa.update', $m->id) }}" method="POST" class="p-0.5">
                            @csrf
                            @method('PUT')

                            {{-- NIM --}}
                            <div class="mb-5">
                                <label
                                    class="block mb-2 text-[11px] font-bold text-indigo-900 uppercase tracking-wider">NIM:</label>
                                <input type="text" name="nim" value="{{ $m->mahasiswa->nim }}" required
                                    class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 p-3 outline-none transition-all">
                            </div>

                            {{-- Nama Mahasiswa --}}
                            <div class="mb-5">
                                <label
                                    class="block mb-2 text-[11px] font-bold text-indigo-900 uppercase tracking-wider">Nama
                                    Lengkap Mahasiswa:</label>
                                <input type="text" name="name" value="{{ $m->name }}" required
                                    class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 p-3 outline-none transition-all">
                            </div>

                            {{-- Program Studi --}}
                            <div class="mb-5">
                                <label
                                    class="block mb-2 text-[11px] font-bold text-indigo-900 uppercase tracking-wider">Program
                                    Studi:</label>
                                <select name="prodi" required
                                    class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3 outline-none focus:border-indigo-500">
                                    <option value="Informatika"
                                        {{ $m->mahasiswa->prodi == 'Informatika' ? 'selected' : '' }}>Informatika
                                    </option>
                                    <option value="Sistem Informasi"
                                        {{ $m->mahasiswa->prodi == 'Sistem Informasi' ? 'selected' : '' }}>Sistem
                                        Informasi</option>
                                </select>
                            </div>

                            {{-- Password --}}
                            <div class="mb-5">
                                <label
                                    class="block mb-2 text-[11px] font-bold text-indigo-900 uppercase tracking-wider">Ganti
                                    Password (Opsional):</label>
                                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin ganti"
                                    class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 p-3 outline-none transition-all">
                            </div>

                            {{-- Grid Semester & Status --}}
                            <div class="grid grid-cols-2 gap-4 mb-7">
                                <div>
                                    <label
                                        class="block mb-2 text-[11px] font-bold text-indigo-900 uppercase tracking-wider">Semester:</label>
                                    <select name="semester_ke" required
                                        class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3 outline-none">
                                        <option value="1" {{ $m->mahasiswa->semester_ke == 1 ? 'selected' : '' }}>
                                            Semester 1</option>
                                        <option value="2" {{ $m->mahasiswa->semester_ke == 2 ? 'selected' : '' }}>
                                            Semester 2</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-[11px] font-bold text-indigo-900 uppercase tracking-wider">Status
                                        Akun:</label>
                                    <select name="status" required
                                        class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3 outline-none font-bold text-indigo-600">
                                        <option value="aktif" {{ $m->status == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="tidak_aktif" {{ $m->status == 'tidak_aktif' ? 'selected' : '' }}>
                                            Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-2xl shadow-lg shadow-indigo-500/20 transition-all active:scale-95">
                                Perbarui Data Mahasiswa
                            </button>
                        </form>
                    </x-modal>
                    @endforeach

                    {{--Pop up style untuk menambahkan mahasiswa--}}
                    <x-modal id="modalTambah" title="Tambah Mahasiswa">
                        <form action="{{ route('mahasiswa.store') }}" method="POST" class="p-0.5">
                            @csrf
                            <div class="mb-5">
                                <label
                                    class="block mb-1.5 text-[11px] font-bold text-gray-600 uppercase tracking-wider">NIM:</label>
                                <input type="text" name="nim" placeholder="Masukkan NIM Mahasiswa" required
                                    class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 p-3 outline-none transition-all">
                            </div>

                            <div class="mb-5">
                                <label
                                    class="block mb-1.5 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Nama
                                    Mahasiswa:</label>
                                <input type="text" name="name" placeholder="Nama Lengkap Mahasiswa" required
                                    class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 p-3 outline-none transition-all">
                            </div>

                            <div class="mb-5">
                                <label
                                    class="block mb-1.5 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Program
                                    Studi:</label>
                                <select name="prodi" required
                                    class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3 outline-none focus:border-indigo-500 appearance-none">
                                    <option value="">Pilih Program Studi</option>
                                    <option value="Informatika">Informatika</option>
                                </select>
                            </div>

                            <div class="mb-5">
                                <label
                                    class="block mb-1.5 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Password
                                    Login:</label>
                                <input type="password" name="password" placeholder="Buat Password Akun" required
                                    class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 p-3 outline-none transition-all">
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-7">
                                <div>
                                    <label
                                        class="block mb-1.5 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Semester:</label>
                                    <select name="semester_ke" required
                                        class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3 outline-none">
                                        <option value="1">Semester 1</option>
                                        <option value="2">Semester 2</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block mb-1.5 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Status:</label>
                                    <select name="status" required
                                        class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3 outline-none font-bold text-indigo-600">
                                        <option value="aktif">Aktif</option>
                                        <option value="tidak_aktif">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>

                             {{--Pop up style SUBMIT untuk menambahkan mahasiswa--}}
                            <button type="submit"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-2xl shadow-lg shadow-indigo-500/20 transition-all active:scale-95">
                                Simpan Data Mahasiswa
                            </button>
                        </form>
                    </x-modal>
                    @endsection
