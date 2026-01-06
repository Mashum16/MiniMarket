<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class BerandaController extends Controller
{
    public function beranda()
    {
        return view('backend.v_beranda.beranda', [
            'judul'    => 'Halaman Beranda',
            'products' => Product::orderBy('updated_at', 'desc')->get()
        ]);
    }

    public function adminBeranda()
    {
        return view('backend.v_admin.v_beranda.index', [
            'judul' => 'Beranda Admin'
        ]);
    }

    public function staffBeranda()
    {
        return view('backend.v_staff.v_beranda.index', [
            'judul' => 'Beranda Staff'
        ]);
    }


}
