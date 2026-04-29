@extends('layouts.admin_layout')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <x-management-header
        title="Manajemen Data Admin"
        buttonText="Tambah Admin"
        targetModal="modalTambahAdmin"
    />

    {{-- Search Bar --}}
    <form action="{{ route('data_admin') }}" method="GET" class="bg-white border-2 border-indigo-50 rounded-2xl p-4 shadow-sm flex items-center justify-between">
        <div class="relative w-full md:w-80">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIP atau Nama..."
                class="block w-full pl-10 pr-3 py-2.5 bg-indigo-50/30 border-2 border-indigo-50 text-gray-900 text-sm rounded-xl outline-none">
        </div>
    </form>

    {{-- Tabel Admin --}}
    <div class="bg-white border-2 border-indigo-50 rounded-2xl shadow-sm overflow-hidden overflow-x-auto">
        <table class="w-full text-left min-w-[800px]">
            <thead class="bg-indigo-50/50">
                <tr class="text-[11px] font-bold uppercase text-indigo-800 tracking-wider">
                    <th class="px-6 py-5">NO</th>
                    <th class="px-6 py-5">NIP</th>
                    <th class="px-6 py-5">Nama Lengkap</th>
                    <th class="px-6 py-5 text-center">Status</th>
                    <th class="px-6 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-indigo-50 text-sm">
                @foreach($admin as $index => $a)
                <tr class="hover:bg-indigo-50/30 transition-colors">
                    <td class="px-6 py-4 text-gray-400">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-bold text-gray-700">{{ $a->username }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $a->name }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $a->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ strtoupper(str_replace('_', ' ', $a->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <button data-modal-target="modalEditAdmin-{{ $a->id }}" data-modal-toggle="modalEditAdmin-{{ $a->id }}"
                                class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <form action="{{ route('admin.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Hapus data admin {{ $a->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                {{-- Modal Edit Admin --}}
                <x-modal id="modalEditAdmin-{{ $a->id }}" title="Edit Data Admin">
                    <form action="{{ route('admin.update', $a->id) }}" method="POST" class="p-0.5">
                        @csrf @method('PUT')

                        {{-- NIP --}}
                        <div class="mb-5">
                            <label class="block mb-2 text-[11px] font-bold text-indigo-900 uppercase tracking-wider">NIP:</label>
                            <input type="text" name="nip" value="{{ $a->username }}" required
                                class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 p-3 outline-none transition-all">
                        </div>

                        {{-- Nama Admin --}}
                        <div class="mb-5">
                            <label class="block mb-2 text-[11px] font-bold text-indigo-900 uppercase tracking-wider">Nama Admin:</label>
                            <input type="text" name="name" value="{{ $a->name }}" required
                                class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 p-3 outline-none transition-all">
                        </div>

                        {{-- Grid Password & Status --}}
                        <div class="grid grid-cols-2 gap-4 mb-7">
                            <div>
                                <label class="block mb-2 text-[11px] font-bold text-indigo-900 uppercase tracking-wider">Password (Opsional):</label>
                                <input type="password" name="password" placeholder="Kosongkan jika tetap"
                                    class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 p-3 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block mb-2 text-[11px] font-bold text-indigo-900 uppercase tracking-wider">Status Akun:</label>
                                <select name="status" required class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3 outline-none font-bold text-indigo-600">
                                    <option value="aktif" {{ $a->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="tidak_aktif" {{ $a->status == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                        </div>

                        {{-- Tombol Perbarui --}}
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-2xl shadow-lg shadow-indigo-500/20 transition-all active:scale-95">
                            Perbarui Data Admin
                        </button>
                    </form>
                </x-modal>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah Admin --}}
<x-modal id="modalTambahAdmin" title="Tambah Admin">
    <form action="{{ route('admin.store') }}" method="POST" class="p-1 space-y-4">
        @csrf
        <div>
            <label class="block mb-1.5 text-[11px] font-bold text-gray-600 uppercase">NIP:</label>
            <input type="text" name="nip" placeholder="Masukkan NIP Admin" required class="w-full border border-gray-200 rounded-xl p-3 text-sm outline-none focus:border-indigo-500">
        </div>
        <div>
            <label class="block mb-1.5 text-[11px] font-bold text-gray-600 uppercase">Nama Admin:</label>
            <input type="text" name="name" placeholder="Nama Lengkap Admin" required class="w-full border border-gray-200 rounded-xl p-3 text-sm outline-none focus:border-indigo-500">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block mb-1.5 text-[11px] font-bold text-gray-600 uppercase">Password:</label>
                <input type="password" name="password" placeholder="Buat Password" required class="w-full border border-gray-200 rounded-xl p-3 text-sm outline-none">
            </div>
            <div>
                <label class="block mb-1.5 text-[11px] font-bold text-gray-600 uppercase">Status:</label>
                <select name="status" class="w-full border border-gray-200 rounded-xl p-3 text-sm font-bold text-indigo-600 outline-none">
                    <option value="aktif">Aktif</option>
                    <option value="tidak_aktif">Tidak Aktif</option>
                </select>
            </div>
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3.5 rounded-2xl shadow-lg shadow-indigo-500/20 active:scale-95 transition-all">Simpan Data Admin</button>
    </form>
</x-modal>
@endsection
