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

}
