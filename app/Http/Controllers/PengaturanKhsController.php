<?php
namespace App\Http\Controllers;

use App\Models\Nilai;
use Illuminate\Http\Request;

class PengaturanKhsController extends Controller
{
    public function index()
    {
        return view('pages.admin.pengaturan_khs');
    }


}
