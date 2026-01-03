<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Orders;
use App\Models\OrderItems;

class CartController extends Controller
{
    // 💠 1. Menampilkan Keranjang
    public function index()
    {
        $cart = session('cart', []);
        return view('backend.v_cart.cart', compact('cart'));
    }

    // 💠 2. Menambah Produk ke Keranjang
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += 1;
        } else {
            $cart[$id] = [
                'name'  => $product->name,
                'qty'   => 1,
                'price' => $product->price,
                'image' => $product->image
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    // 💠 3. Update jumlah item
    public function update(Request $request, $id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $request->qty;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Jumlah produk diperbarui!');
    }

    // 💠 4. Hapus satu item
    public function remove($id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk dihapus dari keranjang!');
    }

    // 💠 5. Kosongkan keranjang
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang dikosongkan!');
    }

    // 💠 6. Checkout → Simpan ke database
    public function checkout()
    {
        $cart = session('cart');

        if (!$cart || count($cart) == 0) {
            return back()->with('error', 'Keranjang kosong!');
        }

        // 1. Buat ORDER (header)
        $order = Orders::create([
            'user_id'     => auth()->id(),
            'total_price' => collect($cart)->sum(fn($item) => $item['qty'] * $item['price']),
            'status'      => 'pending'
        ]);

        // 2. Masukkan detail belanja ke OrderItems
        foreach ($cart as $product_id => $item) {
            OrderItems::create([
                'order_id'         => $order->id,
                'product_id'        => $product_id,
                'qty'               => $item['qty'],
                'price_at_purchase' => $item['price']
            ]);
        }

        // 3. Kosongkan keranjang
        session()->forget('cart');

        return redirect()->route('beranda', $order->id)
                         ->with('success', 'Checkout berhasil!');
    }
}
