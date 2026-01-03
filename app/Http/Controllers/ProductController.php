<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ImageHelper;

class ProductController extends Controller
{
    // =============================
    // TAMPILKAN SEMUA PRODUK
    // Admin & Staff boleh
    // =============================
    public function index()
    {
        $products = Product::orderBy('updated_at', 'desc')->get();
        return view('backend.v_dashboard.productDashboard', compact('products'));
    }

    // =============================
    // FORM TAMBAH PRODUK
    // ADMIN SAJA
    // =============================
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('backend.v_dashboard.productCreate');
    }

    // =============================
    // SIMPAN PRODUK BARU
    // ADMIN SAJA
    // =============================
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->file('image')) {
            $file = $request->file('image');
            $fileName = date('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            ImageHelper::uploadAndResize($file, 'storage/img-product/', $fileName, 500, 500);
            $validated['image'] = $fileName;
        }

        $product = Product::create($validated);

        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'CREATE',
            'table_name' => 'products',
            'record_id'  => $product->id,
            'description'=> 'Menambahkan data produk',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    // =============================
    // FORM EDIT PRODUK
    // ADMIN & STAFF
    // =============================
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('backend.v_dashboard.productEdit', compact('product'));
    }

    // =============================
    // UPDATE PRODUK
    // ADMIN & STAFF
    // =============================
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->file('image')) {
            if ($product->image && file_exists(public_path('storage/img-product/' . $product->image))) {
                unlink(public_path('storage/img-product/' . $product->image));
            }

            $file = $request->file('image');
            $fileName = date('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            ImageHelper::uploadAndResize($file, 'storage/img-product/', $fileName, 500, 500);
            $validated['image'] = $fileName;
        }

        $product->update([
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'stock'       => $validated['stock'],
            'description' => $validated['description'] ?? $product->description,
            'image'       => $validated['image'] ?? $product->image,
        ]);

        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'UPDATE',
            'table_name' => 'products',
            'record_id'  => $product->id,
            'description'=> 'Memperbarui data produk',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diupdate');
    }

    // =============================
    // HAPUS PRODUK
    // ADMIN SAJA
    // =============================
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $product = Product::findOrFail($id);

        if ($product->image && file_exists(public_path('storage/img-product/' . $product->image))) {
            unlink(public_path('storage/img-product/' . $product->image));
        }

        $product->delete();

        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'DELETE',
            'table_name' => 'products',
            'record_id'  => $id,
            'description'=> 'Menghapus data produk',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}
