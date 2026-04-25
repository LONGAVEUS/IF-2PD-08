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
        <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center mb-3">
            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/>
            </svg>
        </div>
        <p class="text-2xl font-semibold text-gray-900">3.72</p>
        <p class="text-xs text-gray-500 mt-1">IPS</p>
        <span class="mt-2 inline-block text-xs bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded-full">Indeks Prestasi Semester </span>
    </div>

    <div class="bg-white border border-indigo-100 rounded-2xl p-5 shadow-sm mt-6">
        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center mb-3">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
            </svg>
        </div>
        <p class="text-2xl font-semibold text-gray-900">3.54</p>
        <p class="text-xs text-gray-500 mt-1">IPK</p>
        <span class="mt-2 inline-block text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full">Indeks Prestasi Kumulatif</span>
    </div>

    <div class="bg-white border border-indigo-100 rounded-2xl p-5 shadow-sm mt-6">
        <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center mb-3">
            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
        </div>
        <p class="text-2xl font-semibold text-gray-900">22</p>
        <p class="text-xs text-gray-500 mt-1">Total SKS</p>
        <span class="mt-2 inline-block text-xs bg-green-50 text-green-600 px-2 py-0.5 rounded-full">SKS diambil semester ini</span>
    </div>

    <div class="bg-white border border-indigo-100 rounded-2xl p-5 shadow-sm mt-6">
        <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center mb-3">
            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>
        <p class="text-2xl font-semibold text-red-600">77.3</p>
        <p class="text-xs text-gray-500 mt-1">Nilai Mutu</p>
        <span class="mt-2 inline-block text-xs bg-red-50 text-red-500 px-2 py-0.5 rounded-full">Total K x N semester ini</span>
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
                <td class="px-4 py-2 text-center">{{ $i+1 }}</td>
                <td class="px-4 py-2">{{ $n->mataKuliah->kode_mk }}</td>
                <td class="px-4 py-2">{{ $n->mataKuliah->nama_mk }}</td>
                <td class="px-4 py-2 text-center">{{ $n->sks }}</td>
                <td class="px-4 py-2 text-center">
                    <span class="px-2 py-1 rounded 
                        @if($n->nilai_huruf == 'A') bg-green-200 
                        @elseif($n->nilai_huruf == 'B') bg-blue-200 
                        @elseif($n->nilai_huruf == 'C') bg-yellow-200 
                        @else bg-red-200 @endif">
                        {{ $n->nilai_huruf }}
                    </span>
                </td>
                <td class="px-4 py-2 text-center">{{ $n->bobot }}</td>
                <td class="px-4 py-2 text-center">{{ $n->kn }}</td>
            </tr>
            @endforeach
        </tbody>
        <script>
        function highlightNilai() {
            document.querySelectorAll("tbody tr").forEach(tr => {
                const huruf = tr.querySelector("td:nth-child(5) span").textContent.trim();
                if (huruf === "D" || huruf === "E") {
                    tr.classList.add("bg-red-50");
                }
            });
        }

        function recalcRingkasan() {
            let totalKN = 0, totalSKS = 0;
            document.querySelectorAll("tbody tr").forEach(tr => {
                const sks = parseInt(tr.querySelector("td:nth-child(4)").textContent);
                const kn = parseFloat(tr.querySelector("td:nth-child(7)").textContent);
                totalSKS += sks;
                totalKN += kn;
            });
            const ips = (totalKN / totalSKS).toFixed(2);
            document.getElementById("ipsCard").textContent = ips;
            document.getElementById("sksCard").textContent = totalSKS;
            document.getElementById("mutuCard").textContent = totalKN.toFixed(1);
        }

        // panggil saat halaman load
        highlightNilai();
        recalcRingkasan();
        </script>
        </table>
    </div>
</div>
@endsection
