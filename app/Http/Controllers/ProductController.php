<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ImageHelper;

class ProductController extends Controller
{
    // TAMPILKAN SEMUA PRODUK
    // Admin & Staff boleh
    public function index()
    {
        $products = Product::with('category')->orderBy('updated_at', 'desc')->get();
        $user = Auth::user();

        if ($user->role === 'staff') {
            return view('backend.v_staff.v_produk.index', compact('products'));
        }

        // default admin
        return view('backend.v_admin.v_produk.index', compact('products'));
    }

    // FORM TAMBAH PRODUK
    public function create()
    {
        // ❌ status dihapus
        $categories = Category::orderBy('name')->get();

        if (Auth::user()->role === 'admin') {
            return view('backend.v_admin.v_produk.create', [
                'judul' => 'Tambah Produk',
                'categories' => $categories
            ]);
        } elseif (Auth::user()->role === 'staff') {
            return view('backend.v_staff.v_produk.create', [
                'judul' => 'Tambah Produk',
                'categories' => $categories
            ]);
        }

        abort(403, 'Anda tidak memiliki akses.');
    }

    // SIMPAN PRODUK BARU
    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'staff'])) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
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
            'description'=> (Auth::user()->role === 'admin' ? 'Admin' : 'Staff') . ' menambahkan data produk',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    // FORM EDIT PRODUK
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        // ❌ status dihapus
        $categories = Category::orderBy('name')->get();

        $judul = 'Edit Produk';

        return view('backend.v_admin.v_produk.edit', compact('product', 'judul', 'categories'));
    }

    // UPDATE PRODUK
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
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
            'category_id' => $validated['category_id'] ?? $product->category_id,
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

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diupdate');
    }

    // HAPUS PRODUK
    // ADMIN SAJA
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

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

    public function show(string $id)
    {
       $product = Product::with(['category', 'images'])->findOrFail($id);
        $categories = Category::orderBy('name', 'asc')->get();
    
        return view('backend.v_admin.v_produk.show', [
            'judul'      => 'Detail Produk',
            'product'    => $product,
            'categories' => $categories
        ]);
    }

}
