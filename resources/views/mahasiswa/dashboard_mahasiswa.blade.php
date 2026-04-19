<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Dashboard Mahasiswa</title>
    
</head>
<body>
    @extends('layouts.mahasiswa_layout')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

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
                <p class="text-base font-bold text-slate-700">{{ Auth::user()->nim }}</p>
            </div>
            <div class="p-4 text-center">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Program Studi</p>
                <p class="text-base font-bold text-slate-700">{{ Auth::user()->program_studi }}</p>
            </div>
            <div class="p-4 text-center">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Semester</p>
                <p class="text-base font-bold text-slate-700">{{ Auth::user()->semester }}</p>
            </div>
        </div>
    </div>

    {{-- ══ STAT CARDS ══ --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

        {{-- IP Semester --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5
                    hover:-translate-y-0.5 hover:shadow-[0_8px_28px_rgba(99,102,241,0.12)]
                    transition-all duration-200
                    animate-[fadeUp_0.42s_0.14s_ease_both]">
            <div class="w-10 h-10 rounded-[10px] bg-indigo-50 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
            </div>
            <p class="text-3xl font-extrabold text-slate-800">{{ number_format(Auth::user()->ip_semester, 2) }}</p>
            <p class="text-sm text-slate-500 mt-0.5">IP Semester Ini</p>
            <div class="h-1.5 rounded-full bg-indigo-100 overflow-hidden mt-3">
                <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-indigo-400"
                     style="width: {{ min((Auth::user()->ip_semester / 4) * 100, 100) }}%">
                </div>
            </div>
            <p class="text-xs text-slate-400 mt-1.5">dari 4.00</p>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                         bg-emerald-50 text-emerald-600 mt-2">
                semester ini
            </span>
        </div>

        {{-- SKS Semester --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5
                    hover:-translate-y-0.5 hover:shadow-[0_8px_28px_rgba(99,102,241,0.12)]
                    transition-all duration-200
                    animate-[fadeUp_0.42s_0.21s_ease_both]">
            <div class="w-10 h-10 rounded-[10px] bg-blue-50 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8"  y1="2" x2="8"  y2="6"/>
                    <line x1="3"  y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <p class="text-3xl font-extrabold text-slate-800">{{ Auth::user()->sks_semester }}</p>
            <p class="text-sm text-slate-500 mt-0.5">SKS Semester Ini</p>
            <div class="h-1.5 rounded-full bg-blue-100 overflow-hidden mt-3">
                @php
                    $sksMax = Auth::user()->sks_max > 0 ? Auth::user()->sks_max : 24;
                    $sksPct = min((Auth::user()->sks_semester / $sksMax) * 100, 100);
                @endphp
                <div class="h-full rounded-full"
                     style="width: {{ $sksPct }}%; background: linear-gradient(90deg, #3b82f6, #93c5fd)">
                </div>
            </div>
            <p class="text-xs text-slate-400 mt-1.5">dari {{ $sksMax }} sks</p>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                         bg-blue-50 text-blue-500 mt-2">
                semua kelas
            </span>
        </div>

        {{-- IP Kumulatif --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5
                    hover:-translate-y-0.5 hover:shadow-[0_8px_28px_rgba(99,102,241,0.12)]
                    transition-all duration-200
                    animate-[fadeUp_0.42s_0.28s_ease_both]">
            <div class="w-10 h-10 rounded-[10px] bg-violet-50 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                </svg>
            </div>
            <p class="text-3xl font-extrabold text-slate-800">{{ number_format(Auth::user()->ip_kumulatif, 2) }}</p>
            <p class="text-sm text-slate-500 mt-0.5">IP Kumulatif</p>
            <div class="h-1.5 rounded-full bg-violet-100 overflow-hidden mt-3">
                <div class="h-full rounded-full"
                     style="width: {{ min((Auth::user()->ip_kumulatif / 4) * 100, 100) }}%;
                            background: linear-gradient(90deg, #8b5cf6, #c4b5fd)">
                </div>
            </div>
            <p class="text-xs text-slate-400 mt-1.5">total {{ Auth::user()->jumlah_semester }} semester</p>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                         bg-violet-50 text-violet-500 mt-2">
                ipk kumulatif
            </span>
        </div>

    </div>{{-- /stat cards --}}

</div>{{-- /max-w --}}
@endsection
</body>
</html>