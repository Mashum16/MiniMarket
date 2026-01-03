<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ImageHelper;

class StaffDashboardController extends Controller
{
    /**
     * Menampilkan daftar user (tanpa kontrol role)
     */
    public function index()
    {
        $user = User::orderBy('updated_at', 'desc')->get();

        return view('backend.v_dashboard.staffDashboard', [
            'judul' => 'Data User',
            'index' => $user,
        ]);
    }

    /**
     * Form tambah user
     */
    public function create()
    {
        return view('backend.v_dashboard.register', [
            'judul' => 'Tambah User',
        ]);
    }

    /**
     * Simpan user baru (role otomatis)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:13',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
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

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'role'     => 'customer', // 🔒 ROLE DIKUNCI
            'phone'    => $validated['phone'] ?? null,
            'avatar'   => $validated['avatar'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        // AUDIT LOG
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'CREATE',
            'table_name' => 'users',
            'record_id'  => $user->id,
            'description'=> 'Staff menambahkan user',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('staff.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Form edit user
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('backend.v_dashboard.staffEdit', [
            'judul' => 'Edit User',
            'index' => $user,
        ]);
    }

    /**
     * Update user (tanpa role)
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:13',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'password' => 'nullable|min:4|confirmed',
        ]);

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

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? $user->phone,
            'avatar'   => $validated['avatar'] ?? $user->avatar,
            'password' => $validated['password'] ?? $user->password,
        ]);

        // AUDIT LOG
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'UPDATE',
            'table_name' => 'users',
            'record_id'  => $user->id,
            'description'=> 'Staff memperbarui data user',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('staff.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }
}
