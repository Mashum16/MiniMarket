<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\ImageHelper;

class ProductController extends Controller
{
    // Tampilkan semua produk
    public function index()
    {
        $products = Product::orderBy('updated_at', 'desc')->get();
        return view('backend.v_dashboard.productDashboard', compact('products'));
    }

    // Form tambah produk
    public function create()
    {
        return view('backend.v_dashboard.productCreate');
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
            'description' => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Upload foto menggunakan ImageHelper
        if ($request->file('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $fileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;

            $directory = 'storage/img-product/';

            // Resize contoh 500x500 (bisa diganti)
            ImageHelper::uploadAndResize($file, $directory, $fileName, 500, 500);

            $validated['image'] = $fileName;
        }

        Product::create([
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'stock'       => $validated['stock'],
            'description' => $validated['description'] ?? null,
            'image'       => $validated['image'] ?? null,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    // Form edit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('backend.v_dashboard.productEdit', compact('product'));
    }

    // Update produk
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
            'description' => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Jika ada foto baru
        if ($request->file('image')) {

            // Hapus foto lama jika ada
            if ($product->image && file_exists(public_path('storage/img-product/' . $product->image))) {
                unlink(public_path('storage/img-product/' . $product->image));
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;

            $directory = 'storage/img-product/';

            ImageHelper::uploadAndResize($file, $directory, $fileName, 500, 500);

            $validated['image'] = $fileName;
        }

        // Update database
        $product->update([
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'stock'       => $validated['stock'],
            'description' => $validated['description'] ?? $product->description,
            'image'       => $validated['image'] ?? $product->image,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diupdate');
    }

    // Hapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus foto jika ada
        if ($product->image && file_exists(public_path('storage/img-product/' . $product->image))) {
            unlink(public_path('storage/img-product/' . $product->image));
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

    // Detail produk (ga guna jir)
    public function show($id)
    {

    }
}
