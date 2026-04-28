@extends('layouts.mahasiswa_layout')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- ══ PAGE HEADER ══ --}}
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
                <p class="text-slate-400 text-sm mt-0.5">NIM: {{ $infoKrs['nim'] }} - {{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>

    {{-- ══ INFO CARDS: Tanggal & IPK ══ --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 animate-[fadeUp_0.42s_0.07s_ease_both]">
        <div class="bg-slate-50 rounded-xl border border-slate-100 grid grid-cols-2 md:grid-cols-3 divide-x divide-slate-100">
            <div class="p-4">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Batas Pengisian</p>
                <p class="text-base font-bold text-slate-700">
                    {{ $infoKrs['batas_pengisian'] }}
                </p>
            </div>
            <div class="p-4">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Semester</p>
                <p class="text-lg font-extrabold text-slate-700">
                    {{ $infoKrs['semester_aktif'] }}
                </p>
            </div>
            <div class="p-4">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">IPK / IPS</p>
                <p class="text-lg font-extrabold text-slate-700">
                    {{ $infoKrs['ipk'] }} <span class="text-slate-400 font-semibold">/</span> {{ $infoKrs['ips'] }}
                </p>
            </div>
        </div>
    </div>

    {{-- ══ DAFTAR MATA KULIAH TERDAFTAR ══ --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden animate-[fadeUp_0.42s_0.14s_ease_both]">
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
            <div>
                <h2 class="text-base font-bold text-slate-800">Daftar Mata Kuliah Terpilih</h2>
                <p class="text-xs text-slate-400 mt-0.5">
                    Total: <span class="font-semibold text-slate-600">{{ $mataKuliahTerdaftar->count() }} Matkul</span>
                    &nbsp;·&nbsp;
                    <span class="font-semibold text-slate-600">{{ $mataKuliahTerdaftar->sum(fn($k) => $k->mata_kuliah->sks) }} SKS</span>
                </p>
            </div>
            <button data-modal-target="modalPilihMK" data-modal-toggle="modalPilihMK" class="bg-indigo-600 hover:bg-indigo-700 transition-colors text-white text-sm font-semibold px-4 py-2 rounded-xl shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Pilih Mata Kuliah
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-800 text-white">
                        <th class="px-5 py-3.5 text-left text-xs uppercase tracking-wider w-12">NO</th>
                        <th class="px-5 py-3.5 text-left text-xs uppercase tracking-wider">Kode</th>
                        <th class="px-5 py-3.5 text-left text-xs uppercase tracking-wider">Nama Mata Kuliah</th>
                        <th class="px-5 py-3.5 text-center text-xs uppercase tracking-wider w-16">SKS</th>
                        <th class="px-5 py-3.5 text-left text-xs uppercase tracking-wider">Dosen</th>
                        <th class="px-5 py-3.5 text-center text-xs uppercase tracking-wider w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($mataKuliahTerdaftar as $index => $item)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-5 py-4 text-slate-500 font-medium">{{ $index + 1 }}</td>
                        <td class="px-5 py-4">
                             <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-indigo-50 text-indigo-600">
                                {{ $item->mk_kode }}
                            </span>
                        </td>
                        <td class="px-5 py-4 font-semibold text-slate-800">{{ $item->mata_kuliah->nama_mk }}</td>
                        <td class="px-5 py-4 text-center font-bold">{{ $item->mata_kuliah->sks }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $item->mata_kuliah->dosen->user->name ?? '-' }}</td>
                        <td class="px-5 py-4 text-center">
                            <form action="{{ route('mahasiswa.krs.hapus', $item->id_krs) }}" method="POST" onsubmit="return confirm('Hapus dari KRS?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 bg-red-50 px-3 py-1.5 rounded-lg border border-red-100 hover:bg-red-100">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-16 text-center text-slate-400">Belum ada mata kuliah terdaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalPilihMK" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="flex items-center justify-between p-5 border-b">
                <h3 class="text-lg font-bold text-slate-800">Pilih Mata Kuliah Tersedia</h3>
                <button type="button" class="text-slate-400 hover:text-slate-600" data-modal-hide="modalPilihMK">✕</button>
            </div>
            <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                @forelse($mataKuliahTersedia as $mk)
                <div class="flex justify-between items-center p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <div>
                        <p class="font-bold text-slate-800">{{ $mk->nama_mk }}</p>
                        <p class="text-xs text-slate-500">{{ $mk->kode_mk }} • {{ $mk->sks }} SKS</p>
                    </div>
                    <form action="{{ route('mahasiswa.krs.tambah') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kode_mk" value="{{ $mk->kode_mk }}">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-indigo-700">Tambah</button>
                    </form>
                </div>
                @empty
                <p class="text-slate-400 text-center py-10">Tidak ada mata kuliah untuk semester kamu.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

