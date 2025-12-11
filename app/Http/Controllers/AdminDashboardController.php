<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ImageHelper;

class AdminDashboardController extends Controller
{
    /**
     * Menampilkan semua user
     */
    public function index()
    {
        $user = User::orderBy('updated_at', 'desc')->get();

        return view('backend.v_dashboard.AdminDashboard', [
            'judul' => 'Data User',
            'index' => $user,
        ]);
    }

    /**
     * Form tambah user
     */
    public function create()
    {
        return view('backend.v_dashboard.adminCreate', [
            'judul' => 'Tambah User',
        ]);
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:customer,staff,admin',
            'phone'       => 'nullable|string|max:13',
            'avatar'     => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'password' => 'required|min:4|confirmed',
        ]);

        // Upload foto jika ada
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $fileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-user/';

            ImageHelper::uploadAndResize($file, $directory, $fileName, 385, 400);

            $validated['avatar'] = $fileName;
        }

        $validated['password'] = Hash::make($validated['password']);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'role'     => $validated['role'],
            'phone'    => $validated['phone'] ?? null,
            'avatar'   => $validated['avatar'] ?? null,
            'password' => $validated['password'],
        ]);

        return redirect()->route('admin.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Form edit user
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('backend.v_dashboard.adminEdit', [
            'judul' => 'Edit User',
            'index'  => $user,
        ]);
    }

    /**
     * Update user
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required|in:customer,staff,admin',
            'phone'       => 'nullable|string|max:13',
            'avatar'     => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'password' => 'nullable|min:4|confirmed',
        ]);

        // --- Jika upload foto baru → hapus lama + simpan baru ---
        if ($request->hasFile('avatar')) {

            if ($user->avatar && file_exists(public_path('storage/img-user/' . $user->avatar))) {
                unlink(public_path('storage/img-user/' . $user->avatar));
            }

            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $fileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-user/';

            ImageHelper::uploadAndResize($file, $directory, $fileName, 385, 400);

            $validated['avatar'] = $fileName;
        }

        // --- Password hanya diupdate jika diisi ---
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // --- Update data ---
        $user->update([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'role'     => $validated['role'],
            'phone'    => $validated['phone'] ?? $user->phone,
            'avatar'   => $validated['avatar'] ?? $user->avatar,
            'password' => $validated['password'] ?? $user->password,
        ]);

        return redirect()->route('admin.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Hapus user
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // hapus foto jika ada
        if ($user->avatar && file_exists(public_path('storage/img-user/' . $user->avatar))) {
            unlink(public_path('storage/img-user/' . $user->avatar));
        }

        $user->delete();

        return redirect()->route('admin.index')
            ->with('success', 'User berhasil dihapus.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.show', compact('user'));
    }

}
