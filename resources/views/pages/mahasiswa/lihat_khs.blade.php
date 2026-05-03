@extends('layouts.mahasiswa_layout')

@section('content')

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
                <h1 class="text-2xl font-extrabold text-indigo-900 tracking-tight">Kartu Hasil Studi (KHS)</h1>
                <p class="text-slate-400 text-sm mt-0.5"> NIM: {{ $user->mahasiswa->nim }} | Nama: {{ $user->name }}</p>
            </div>
        </div>
    </div>

<!-- Ringkasan IPS/IPK/Total SKS/Nilai Mutu -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

    <div class="bg-white border border-indigo-100 rounded-2xl p-5 shadow-sm mt-6">
        <p class="text-sm font-medium text-slate-500">IPS</p>
        <p class="text-4xl font-extrabold text-slate-800">{{ $ips }}</p>
        <p class="text-xs text-slate-400 mt-1">Indeks Prestasi Semester</p>
    </div>

    <div class="bg-white border border-indigo-100 rounded-2xl p-5 shadow-sm mt-6">
        <p class="text-sm font-medium text-slate-500">IPK</p>
        <p class="text-4xl font-extrabold text-slate-800">{{ $ipk }}</p>
        <p class="text-xs text-slate-400 mt-1">Indeks Prestasi Kumulatif</p>
    </div>

    <div class="bg-white border border-indigo-100 rounded-2xl p-5 shadow-sm mt-6">
        <p class="text-sm font-medium text-slate-500">Total SKS</p>
        <p class="text-4xl font-extrabold text-slate-800">{{ $totalSks }}</p>
        <p class="text-xs text-slate-400 mt-1">SKS diambil semester ini</p>
    </div>

    <div class="bg-white border border-indigo-100 rounded-2xl p-5 shadow-sm mt-6">
        <p class="text-sm font-medium text-slate-500">Nilai Mutu</p>
        <p class="text-4xl font-extrabold text-slate-800">{{ $totalKn }}</p>
        <p class="text-xs text-slate-400 mt-1">Total K x N semester ini</p>
    </div>
</div>

<!-- Judul tabel dan dropdown semester-->
<div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-4">
    <p class="text-base font-semibold text-indigo-900">
        Daftar Nilai Mata Kuliah
    </p>
    <div class="w-full sm:w-auto">
        <x-semester-filter :selectedSemester="$selectedSemester" />
    </div>
</div>


<!-- Tabel Daftar Nilai -->
    <div class="bg-white border-2 border-indigo-50 rounded-2xl overflow-hidden shadow-lg shadow-indigo-500/5 overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
            <thead class="bg-indigo-50/50">
                <tr>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b-2 border-indigo-100 w-16">No</th>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b-2 border-indigo-100">Kode MK</th>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b-2 border-indigo-100">Nama Mata Kuliah</th>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b-2 border-indigo-100">SKS</th>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b-2 border-indigo-100">Nilai</th>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b-2 border-indigo-100">bobot</th>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b-2 border-indigo-100">K x N</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-indigo-50">
            @foreach($nilai as $i => $n)
            <tr>
                <td class="px-5 py-4 align-middle text-sm text-gray-400 font-medium">{{ $i+1 }}</td>
                <td class="px-5 py-4 align-middle">
                    <span class="text-sm font-medium text-gray-500">{{ $n->mataKuliah->kode_mk }}</span>
                </td>
                <td class="px-5 py-4 align-middle font-semibold text-gray-800">{{ $n->mataKuliah->nama_mk }}</td>
                <td class="px-5 py-4 align-middle font-semibold text-gray-800">{{ $n->sks }}</td>
                <td class="px-5 py-4 align-middle">
                    <span class="text-sm font-bold text-indigo-700" id="huruf-{{ $user->mahasiswa->nim }}">{{ $n->nilai_huruf }}</span>
                </td>
                <td class="px-5 py-4 align-middle font-semibold text-gray-800">{{ $n->bobot }}</td>
                <td class="px-5 py-4 align-middle font-semibold text-gray-800">{{ $n->kn }}</td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
@endsection
