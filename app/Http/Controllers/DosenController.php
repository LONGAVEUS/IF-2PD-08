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
        return view('dashboard_dosen', compact('data'));
    }

    public function inputNilai()
    {
        $data = $this->getData();
        return view('input_nilai', compact('data'));
    }
    
    public function dataUsers()
{
    $data = [
        ['id' => 1, 'nama' => 'Peter Parker', 'email' => 'peter@gmail.com', 'role' => 'Mahasiswa'],
        ['id' => 2, 'nama' => 'Tony Stark', 'email' => 'tony@gmail.com', 'role' => 'Dosen'],
        ['id' => 3, 'nama' => 'Natalia Romanoff', 'email' => 'natalia@gmail.com', 'role' => 'Admin'],
    ];

    return view('data_users', compact('data'));
}
}