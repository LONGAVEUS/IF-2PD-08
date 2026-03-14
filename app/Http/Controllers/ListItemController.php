<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListItemController extends Controller
{
    function tampilkan($id, $nama){
        return view('list_item', ['id' => $id, 'nama' => $nama]);
    }
}
