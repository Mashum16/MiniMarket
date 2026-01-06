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
        // Menghitung total data dari masing-masing tabel
        $data = [
            'totalUsers'   => User::count(),
            'totalProducts' => Product::count(),
            'totalOrders'   => Orders::count(),
            // Anda juga bisa menghitung total pendapatan jika perlu
            'totalRevenue'  => Orders::where('status', 'success')->sum('total_price'),
        ];
        return view('backend.v_admin.v_beranda.index', $data);
    }

    public function staffBeranda()
    {
// Menghitung total data dari masing-masing tabel
        $data = [
            'totalUsers'   => User::count(),
            'totalProducts' => Product::count(),
            'totalOrders'   => Orders::count(),
            // Anda juga bisa menghitung total pendapatan jika perlu
            'totalRevenue'  => Orders::where('status', 'success')->sum('total_price'),
        ];
        return view('backend.v_staff.v_beranda.index', $data);
    }
}
