@extends('layouts.mahasiswa_layout')

@section('content')
<div class="space-y-6">

    {{-- ══ GREETING CARD ══ --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm px-7 py-6
                flex flex-col md:flex-row md:items-center md:justify-between gap-3
                animate-[fadeUp_0.42s_ease_both]">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-indigo-900 tracking-tight">
                Halo, {{ Auth::user()->name }}! 👋
            </h1>
            <p class="text-slate-400 text-sm mt-1">
                Selamat Datang di Sistem Pengisian KRS dan Hasil Akhir (KHS)
            </p>
        </div>
    </div>

    {{-- ══ DATA AKADEMIK CARD ══ --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6
                animate-[fadeUp_0.42s_0.07s_ease_both]">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3
                  flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <rect x="3"  y="3"  width="7" height="7" rx="1"/>
                <rect x="14" y="3"  width="7" height="7" rx="1"/>
                <rect x="3"  y="14" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
            Data Akademik
        </p>
        <div class="bg-slate-50 rounded-xl border border-slate-100 grid grid-cols-3 divide-x divide-slate-100">
            <div class="p-4 text-center">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">NIM</p>
                <p class="text-base font-bold text-slate-700">{{ Auth::user()->mahasiswa->nim }}</p>
            </div>
            <div class="p-4 text-center">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Prodi</p>
                <p class="text-base font-bold text-slate-700">{{ Auth::user()->mahasiswa->prodi }}</p>
            </div>
            <div class="p-4 text-center">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Semester</p>
                <p class="text-base font-bold text-slate-700">Semester {{ Auth::user()->mahasiswa->semester_ke }}</p>
            </div>
        </div>
    </div>

    {{-- ══ STAT CARDS ══ --}}
    <div class="grid grid-cols-3 gap-2 md:gap-6">
        <div class="bg-white border-2 border-indigo-50 rounded-xl md:rounded-2xl p-3 md:p-6 shadow-sm"> {{-- p-3 untuk mobile --}}
        <div class="w-7 h-7 md:w-10 md:h-10 rounded-lg bg-indigo-50 flex items-center justify-center mb-2 md:mb-3"> {{-- Ikon lebih kecil --}}
            <svg class="w-4 h-4 md:w-5 md:h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
        </div>
        <p class="text-[9px] md:text-sm font-medium text-slate-500">IP Sem</p> {{-- Font label lebih kecil --}}
        <p class="text-xl md:text-4xl font-extrabold text-slate-800">{{ $ips }}</p> {{-- Font angka disesuaikan --}}
        <p class="text-[8px] md:text-xs text-slate-400 hidden md:block">dari 4.00</p>
    </div>



    {{-- SKS Semester --}}
    <div class="bg-white border-2 border-indigo-50 rounded-xl md:rounded-2xl p-3 md:p-6 shadow-sm">
        <div class="w-7 h-7 md:w-10 md:h-10 rounded-lg bg-blue-50 flex items-center justify-center mb-2 md:mb-3">
            <svg class="w-4 h-4 md:w-5 md:h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>
        <p class="text-[9px] md:text-sm font-medium text-slate-500">SKS Sem</p>
        <p class="text-xl md:text-4xl font-extrabold text-slate-800">{{ $totalSks }}</p>
        <p class="text-[8px] md:text-xs text-slate-400 hidden md:block">dari {{ $sksMax }} SKS</p>
    </div>

    {{-- IP Kumulatif --}}
    <div class="bg-white border-2 border-indigo-50 rounded-xl md:rounded-2xl p-3 md:p-6 shadow-sm">
        <div class="w-7 h-7 md:w-10 md:h-10 rounded-lg bg-violet-50 flex items-center justify-center mb-2 md:mb-3">
            <svg class="w-4 h-4 md:w-5 md:h-5 text-violet-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
        </div>
        <p class="text-[9px] md:text-sm font-medium text-slate-500">IPK</p>
        <p class="text-xl md:text-4xl font-extrabold text-slate-800">{{ $ipk }}</p>
        <p class="text-[8px] md:text-xs text-slate-400 hidden md:block">total {{ $jumlahSemester }} sem</p>
    </div>
</div>
</div>
@endsection

