<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Document</title>
</head>
<body>
        @extends('layouts.admin_layout')

@section('content')

@php
$mahasiswa = [
    (object)['nim'=>'221001','nama'=>'Peter Parker','email'=>'peter@gmail.com','prodi'=>'Informatika'],
];

$dosen = [
    (object)['nidn'=>'198765','nama'=>'Dr. Thanos','email'=>'thanos@kampus.ac.id','jurusan'=>'Informatika'],
];

$matkul = [
    (object)['kode'=>'IF101','nama'=>'Pemrograman Web','sks'=>3],
];
@endphp

<div class="max-w-6xl mx-auto space-y-6">

    <h1 class="text-2xl font-bold text-gray-800">Dashboard Akademik</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div onclick="showSection('mhs')"
            class="cursor-pointer bg-blue-100 border border-blue-300 p-6 rounded-xl shadow hover:bg-blue-200 hover:scale-105 transition">
            <h2 class="text-blue-700 font-semibold">Mahasiswa</h2>
        </div>

        <div onclick="showSection('dsn')"
            class="cursor-pointer bg-emerald-100 border border-emerald-300 p-6 rounded-xl shadow hover:bg-emerald-200 hover:scale-105 transition">
            <h2 class="text-emerald-700 font-semibold">Dosen</h2>
        </div>

        <div onclick="showSection('mk')"
            class="cursor-pointer bg-indigo-100 border border-indigo-300 p-6 rounded-xl shadow hover:bg-indigo-200 hover:scale-105 transition">
            <h2 class="text-indigo-700 font-semibold">Mata Kuliah</h2>
        </div>

    </div>

    <div id="content" class="hidden bg-white p-6 rounded-xl shadow border border-gray-100">

        <div id="mhs" class="hidden">
            <div class="flex justify-between mb-4">
                <h2 class="font-semibold text-gray-700">Data Mahasiswa</h2>
                <button onclick="openModal('mhs')" class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
                    + Tambah Akun
                </button>
            </div>

            @foreach($mahasiswa as $m)
            <div class="flex justify-between border-b py-3 last:border-0">
                <div>
                    <p class="font-medium text-gray-900">{{ $m->nama }}</p>
                    <p class="text-sm text-slate-500">
                        {{ $m->nim }} | {{ $m->email }} | {{ $m->prodi }}
                    </p>
                </div>
                <div class="flex gap-3 text-sm">
                    <button class="text-blue-600 font-medium">Edit</button>
                    <button class="text-red-600 font-medium">Hapus</button>
                </div>
            </div>
            @endforeach
        </div>

        <div id="dsn" class="hidden">
            <div class="flex justify-between mb-4">
                <h2 class="font-semibold text-gray-700">Data Dosen</h2>
                <button onclick="openModal('dsn')" class="bg-green-600 text-white px-3 py-1 rounded text-sm">
                    + Tambah Akun
                </button>
            </div>

            @foreach($dosen as $d)
            <div class="flex justify-between border-b py-3 last:border-0">
                <div>
                    <p class="font-medium text-gray-900">{{ $d->nama }}</p>
                    <p class="text-sm text-slate-500">
                        {{ $d->nidn }} | {{ $d->email }} | {{ $d->jurusan }}
                    </p>
                </div>
                <div class="flex gap-3 text-sm">
                    <button class="text-blue-600 font-medium">Edit</button>
                    <button class="text-red-600 font-medium">Hapus</button>
                </div>
            </div>
            @endforeach
        </div>

        <div id="mk" class="hidden">
            <div class="flex justify-between mb-4">
                <h2 class="font-semibold text-gray-700">Data Mata Kuliah</h2>
                <button onclick="openModal('mk')" class="bg-indigo-600 text-white px-3 py-1 rounded text-sm">
                    + Tambah Data
                </button>
            </div>

            @foreach($matkul as $mk)
            <div class="flex justify-between border-b py-3 last:border-0">
                <div>
                    <p class="font-medium text-gray-900">{{ $mk->nama }}</p>
                    <p class="text-sm text-slate-500">
                        {{ $mk->kode }} | {{ $mk->sks }} SKS
                    </p>
                </div>
                <div class="flex gap-3 text-sm">
                    <button class="text-blue-600 font-medium">Edit</button>
                    <button class="text-red-600 font-medium">Hapus</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Modal & Script tetap sama sesuai kode aslimu --}}
<div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[60]">
    <div class="bg-white p-6 rounded-xl w-96 shadow-2xl">
        <h2 class="font-semibold mb-4 text-gray-800">Tambah Data</h2>
        <div id="formContent"></div>
        <button onclick="closeModal()" class="mt-4 text-sm text-red-600 hover:underline">Tutup</button>
    </div>
</div>

<script>
function showSection(section) {
    document.getElementById('content').classList.remove('hidden');
    ['mhs','dsn','mk'].forEach(id => document.getElementById(id).classList.add('hidden'));
    document.getElementById(section).classList.remove('hidden');
}

function openModal(type) {
    let form = '';
    if(type === 'mhs'){
        form = `<input class="border p-2 w-full mb-2 rounded" placeholder="Nama"><input class="border p-2 w-full mb-2 rounded" placeholder="NIM"><button class="bg-blue-600 text-white w-full py-2 rounded mt-2">Simpan</button>`;
    } else if(type === 'dsn'){
        form = `<input class="border p-2 w-full mb-2 rounded" placeholder="Nama"><input class="border p-2 w-full mb-2 rounded" placeholder="NIDN"><button class="bg-green-600 text-white w-full py-2 rounded mt-2">Simpan</button>`;
    } else if(type === 'mk'){
        form = `<input class="border p-2 w-full mb-2 rounded" placeholder="Nama Matkul"><input class="border p-2 w-full mb-2 rounded" placeholder="Kode"><button class="bg-indigo-600 text-white w-full py-2 rounded mt-2">Simpan</button>`;
    }
    document.getElementById('formContent').innerHTML = form;
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal(){
    document.getElementById('modal').classList.add('hidden');
}
</script>
@endsection


</body>
</html>
