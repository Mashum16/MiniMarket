<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;

class UserController extends Controller
{
    // Menampilkan semua user
    public function index()
    {
        $users = User::orderBy('updated_at', 'desc')->get();

        // Pilih view berdasarkan role
        if (Auth::user()->role === 'staff') {
            return view('backend.v_staff.v_user.index', [
                'judul' => 'Data User',
                'index' => $users
            ]);
        }

        // Default admin
        return view('backend.v_admin.v_user.index', [
            'judul' => 'Data User',
            'index' => $users
        ]);
    }

    // Form tambah user
    public function create()
    {
        return view('backend.v_admin.v_user.create', [
            'judul' => 'Tambah User'
        ]);
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:customer,staff,admin',
            'phone'    => 'nullable|string|max:13',
            'avatar'   => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'status'   => 'required|boolean',
            'password' => 'required|min:4|confirmed',
        ]);

        // Upload avatar
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = date('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $directory = 'storage/img-user/';
            ImageHelper::uploadAndResize($file, $directory, $fileName, 385, 400);
            $validated['avatar'] = $fileName;
        }

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        // ================= AUDIT LOG (CREATE) =================
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'CREATE',
            'table_name' => 'users',
            'record_id'  => $user->id,
            'description'=> 'Menambahkan user baru: ' . $user->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        // ======================================================

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    // Form edit user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.v_admin.v_user.edit', [
            'judul' => 'Edit User',
            'edit' => $user
        ]);
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required|in:customer,staff,admin',
            'phone'    => 'nullable|string|max:13',
            'avatar'   => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'status'   => 'required|boolean',
            'password' => 'nullable|min:4|confirmed',
        ]);

        // Upload avatar baru
        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(public_path('storage/img-user/' . $user->avatar))) {
                unlink(public_path('storage/img-user/' . $user->avatar));
            }
            $file = $request->file('avatar');
            $fileName = date('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $directory = 'storage/img-user/';
            ImageHelper::uploadAndResize($file, $directory, $fileName, 385, 400);
            $validated['avatar'] = $fileName;
        }

        // Update password jika ada
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        // ================= AUDIT LOG (UPDATE) =================
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'UPDATE',
            'table_name' => 'users',
            'record_id'  => $user->id,
            'description'=> 'Mengubah data user: ' . $user->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        // ======================================================

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    // Hapus user
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->avatar && file_exists(public_path('storage/img-user/' . $user->avatar))) {
            unlink(public_path('storage/img-user/' . $user->avatar));
        }

        $user->delete();

        // ================= AUDIT LOG (DELETE) =================
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'DELETE',
            'table_name' => 'users',
            'record_id'  => $id,
            'description'=> 'Menghapus user: ' . $user->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        // ======================================================

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    // Detail user
    public function show($id)
    {
        $user = User::findOrFail($id);

        // ================= AUDIT LOG (VIEW) =================
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'VIEW',
            'table_name' => 'users',
            'record_id'  => $user->id,
            'description'=> 'Melihat detail user: ' . $user->name,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        // ======================================================

        return view('backend.v_layouts.showUser', [
            'judul' => 'Detail User',
            'user'  => $user
        ]);
    }
}
