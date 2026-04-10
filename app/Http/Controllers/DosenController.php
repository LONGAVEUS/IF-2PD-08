<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function getData()
    {
        $dataNilai = [
            ['id' => 1, 'nama' => 'Peter Parker', 'matkul' => 'Pemrograman Web', 'nilai' => 98],
            ['id' => 2, 'nama' => 'Tony Stark', 'matkul' => 'Pemrograman Web', 'nilai' => 95],
            ['id' => 3, 'nama' => 'Natalia Romanoff', 'matkul' => 'Pemrograman Web', 'nilai' => 78],
        ];

        return $dataNilai;
    }

    public function tampilkan()
    {
        $data = $this->getData();

        $mataKuliah = [
            [
                'nama'             => 'Pemrograman Web',
                'kode'             => 'IF301',
                'kelas'            => 'IF-3B',
                'jumlah_mahasiswa' => 32,
                'sks'              => 3,
                'sudah_input'      => true,
                'rata_rata'        => '86.2',
                'deadline'         => null,
            ],
            [
                'nama'             => 'Basis Data Lanjut',
                'kode'             => 'IF302',
                'kelas'            => 'IF-3A',
                'jumlah_mahasiswa' => 30,
                'sks'              => 3,
                'sudah_input'      => false,
                'rata_rata'        => null,
                'deadline'         => '15 Apr',
            ],
        ];

        $jumlahMatkul = count($mataKuliah);
        $nilaiPending = collect($mataKuliah)->where('sudah_input', false)->count();

        return view('dosen.dashboard_dosen', compact('data', 'mataKuliah', 'jumlahMatkul', 'nilaiPending'));
    }

    public function inputNilai()
    {
        $data = $this->getData();
        return view('dosen.input_nilai', compact('data'));
    }

    public function dataUsers()
    {
        $data = [
            ['id' => 1, 'nama' => 'Peter Parker', 'email' => 'peter@gmail.com', 'role' => 'Mahasiswa'],
            ['id' => 2, 'nama' => 'Tony Stark', 'email' => 'tony@gmail.com', 'role' => 'Dosen'],
            ['id' => 3, 'nama' => 'Natalia Romanoff', 'email' => 'natalia@gmail.com', 'role' => 'Admin'],
        ];

        return view('dosen.data_users', compact('data'));
    }
}