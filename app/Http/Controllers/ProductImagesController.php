<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductImagesController extends Controller
{
    // SIMPAN FOTO TAMBAHAN
    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'staff'])) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'image'      => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // simpan file
        $path = $request->file('image')->store('product-photo', 'public');

        $image = ProductImage::create([
            'product_id' => $validated['product_id'],
            'image'      => $path,
        ]);

        // audit log
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'CREATE',
            'table_name' => 'product_images',
            'record_id'  => $image->id,
            'description'=> 'Menambahkan foto tambahan produk',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Foto berhasil ditambahkan');
    }

    // HAPUS FOTO TAMBAHAN
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $image = ProductImage::findOrFail($id);

        // hapus file fisik
        if (Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'DELETE',
            'table_name' => 'product_images',
            'record_id'  => $id,
            'description'=> 'Menghapus foto tambahan produk',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Foto berhasil dihapus');
    }
}
