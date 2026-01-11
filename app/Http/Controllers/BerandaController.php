<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Orders;
use App\Models\User;

class BerandaController extends Controller
{
    public function beranda()
    {
        return view('backend.v_customer.v_beranda.index', [
            'judul'    => 'Halaman Beranda',
            'products' => Product::orderBy('updated_at', 'desc')->get()
        ]);
    }

    public function adminBeranda()
    {
        // Menghitung total hasil data dari masing2 tabel
        $data = [
            'totalUsers'   => User::count(),
            'totalProducts' => Product::count(),
            'totalOrders'   => Orders::count(),
            // ini untuk total pendapatan
            'totalRevenue'  => Orders::where('status', 'success')->sum('total_price'),
        ];
        return view('backend.v_admin.v_beranda.index', $data);
    }

    public function staffBeranda()
    {
        // sama kek di atas
        $data = [
            'totalUsers'   => User::count(),
            'totalProducts' => Product::count(),
            'totalOrders'   => Orders::count(),
            'totalRevenue'  => Orders::where('status', 'success')->sum('total_price'),
        ];
        return view('backend.v_staff.v_beranda.index', $data);
    }
}
