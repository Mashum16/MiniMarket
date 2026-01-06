<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        return view('backend.v_admin.v_kategori.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.v_admin.v_kategori.create', [
            'judul' => 'Tambah Kategori',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Category $category)
    {
        $judul = 'Edit Kategori';
        return view('backend.v_admin.v_kategori.edit', compact('category', 'judul'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori berhasil dihapus');
    }
}
