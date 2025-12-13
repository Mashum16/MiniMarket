<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    // Simpan produk baru (CREATE)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Upload foto
        if ($request->file('image')) {
            $file = $request->file('image');
            $fileName = date('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $directory = 'storage/img-product/';
            ImageHelper::uploadAndResize($file, $directory, $fileName, 500, 500);
            $validated['image'] = $fileName;
        }

        $product = Product::create([
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'stock'       => $validated['stock'],
            'description' => $validated['description'] ?? null,
            'image'       => $validated['image'] ?? null,
        ]);

        // ================= AUDIT LOG =================
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'CREATE',
            'table_name' => 'products',
            'record_id'  => $product->id,
            'description'=> 'Menambahkan data produk',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        // =============================================

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    // Form edit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('backend.v_dashboard.productEdit', compact('product'));
    }

    // Update produk (UPDATE)
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

        // Upload foto baru
        if ($request->file('image')) {

            if ($product->image && file_exists(public_path('storage/img-product/' . $product->image))) {
                unlink(public_path('storage/img-product/' . $product->image));
            }

            $file = $request->file('image');
            $fileName = date('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $directory = 'storage/img-product/';
            ImageHelper::uploadAndResize($file, $directory, $fileName, 500, 500);
            $validated['image'] = $fileName;
        }

        $product->update([
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'stock'       => $validated['stock'],
            'description' => $validated['description'] ?? $product->description,
            'image'       => $validated['image'] ?? $product->image,
        ]);

        // ================= AUDIT LOG =================
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'UPDATE',
            'table_name' => 'products',
            'record_id'  => $product->id,
            'description'=> 'Memperbarui data produk',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        // =============================================

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diupdate');
    }

    // Hapus produk (DELETE)
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && file_exists(public_path('storage/img-product/' . $product->image))) {
            unlink(public_path('storage/img-product/' . $product->image));
        }

        $product->delete();

        // ================= AUDIT LOG =================
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'DELETE',
            'table_name' => 'products',
            'record_id'  => $id,
            'description'=> 'Menghapus data produk',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        // =============================================

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

    // Detail produk
    public function show($id)
    {
        // Tidak ada perubahan data → tidak perlu audit
    }
}
