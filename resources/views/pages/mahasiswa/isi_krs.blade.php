@extends('layouts.mahasiswa_layout')

@section('content')
<div class="space-y-6">

    {{-- PAGE HEADER --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm px-7 py-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3 animate-[fadeUp_0.42s_ease_both]">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                    <rect x="9" y="3" width="6" height="4" rx="1"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-indigo-900 tracking-tight">Kartu Rencana Studi (KRS)</h1>
                <p class="text-slate-400 text-sm mt-0.5">NIM: {{ $infoKrs['nim'] }} | Nama: {{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>

    {{-- INFO CARDS: Semester & IPK --}}
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-6">
    <div class="bg-white border-2 border-indigo-50 rounded-2xl p-4 md:p-6 shadow-sm">
        <p class="text-[10px] md:text-sm font-medium text-slate-500">Semester Saat Ini:</p>
        <p class="text-xl md:text-4xl font-extrabold text-slate-800">{{ $infoKrs['semester_aktif'] }}</p>
    </div>

    {{-- KARTU IPK/IPS --}}
    <div class="bg-white border-2 border-indigo-50 rounded-2xl p-4 md:p-6 shadow-sm">
        <p class="text-[10px] md:text-sm font-medium text-slate-500">IPK/IPS (lalu):</p>
        <p class="text-xl md:text-4xl font-extrabold text-slate-800">
            {{ $infoKrs['ipk'] }} <span class="text-lg md:text-4xl">/</span> {{ $infoKrs['ips'] }}
        </p>
    </div>
</div>

    {{-- Header Tabel --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between px-5 py-5 border-b border-slate-100 gap-4">
        <div>
            <h2 class="text-sm md:text-base font-semibold text-indigo-900">Daftar Mata Kuliah Terpilih</h2>
            <p class="text-[10px] md:text-xs text-slate-400 mt-0.5">
                Total: <span class="font-semibold text-slate-600">{{ $mataKuliahTerdaftar->count() }} Matkul</span>
                &nbsp;·&nbsp;
                <span class="font-semibold text-slate-600">{{ $mataKuliahTerdaftar->sum(fn($k) => $k->mata_kuliah->sks) }} SKS</span>
            </p>
        </div>
        <button data-modal-target="modalPilihMK" data-modal-toggle="modalPilihMK"
                class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white text-xs md:text-sm font-semibold px-4 py-2.5 rounded-xl flex items-center justify-center gap-2 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Pilih Mata Kuliah
        </button>
    </div>

    {{-- Tabel  KRS --}}
    <div class="overflow-x-auto">
        <div class="bg-white border-2 border-indigo-50 rounded-2xl overflow-hidden shadow-lg shadow-indigo-500/5 overflow-x-auto">
        <table class="w-full text-left min-w-[800px] border-collapse">
            <thead class="bg-indigo-50/50">
                <tr>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b border-indigo-100 w-16">NO</th>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b border-indigo-100">Kode MK</th>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b border-indigo-100">Nama Mata Kuliah</th>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b border-indigo-100">SKS</th>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b border-indigo-100">Dosen</th>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b border-indigo-100 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-indigo-50 text-sm">
                @foreach($mataKuliahTerdaftar as $index => $item)
                <tr class="hover:bg-indigo-50/30 transition-colors">
                    <td class="px-5 py-4 align-middle text-gray-400 font-medium">{{ $index + 1 }}</td>
                    <td class="px-5 py-4 align-middle font-semibold text-gray-500">{{ $item->mk_kode }}</td>
                    <td class="px-5 py-4 align-middle font-semibold text-gray-800">{{ $item->mata_kuliah->nama_mk }}</td>
                    <td class="px-5 py-4 align-middle font-bold text-gray-700">{{ $item->mata_kuliah->sks }}</td>
                    <td class="px-5 py-4 align-middle font-semibold text-gray-800">{{ $item->mata_kuliah->dosen->user->name ?? '-' }}</td>
                    <td class="px-5 py-4 align-middle text-center">
                        <form action="{{ route('mahasiswa.destroy', $item->id_krs) }}" method="POST" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>

{{-- TOMBOL SIMPAN --}}
    <div class="flex justify-end mt-8 mb-4 pr-4 md:pr-16">
        <button class="w-full sm:w-auto bg-indigo-600 text-white rounded-xl px-8 py-3 text-sm font-semibold shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 active:scale-95 transition" onclick="simpan()">
            Simpan
        </button>
    </div>

{{-- MODAL TAMBAH MATA KULIAH --}}
<div id="modalPilihMK" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="flex items-center justify-between p-5 border-b">
                <h3 class="text-lg font-bold text-slate-800">Pilih Mata Kuliah Tersedia</h3>
                <button type="button" class="text-slate-400 hover:text-slate-600" data-modal-hide="modalPilihMK">✕</button>
            </div>
            <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                @foreach($mataKuliahTersedia as $mk)
                <div class="flex justify-between items-center p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <div>
                        <p class="text-xs text-slate-500">{{ $mk->kode_mk }}</p>
                        <p class="font-bold text-slate-800">{{ $mk->nama_mk }}</p>
                        <p class="text-xs text-slate-500">{{ $mk->sks }} SKS • {{ $mk->dosen->user->name ?? '-' }}</p>
                    </div>
                    <form action="{{ route('mahasiswa.krs.tambah') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kode_mk" value="{{ $mk->kode_mk }}">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-indigo-700">Tambah</button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection

