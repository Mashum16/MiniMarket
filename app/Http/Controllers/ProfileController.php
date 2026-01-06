<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Menampilkan halaman profil sesuai role
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        switch ($role) {
            case 'admin':
                return view('backend.v_admin.v_profile.profile', compact('user'));
            case 'staff':
                return view('backend.v_staff.v_profile.profile', compact('user'));
            case 'customer':
                return view('backend.v_customer.v_profile.profile', compact('user'));
            default:
                return redirect()->route('login');
        }
    }

    // Menangani update data profil
    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi Input
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:15',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // 2. Update Data Dasar
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // 3. Handle Upload Avatar
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $filename = time() . '_' . $user->name . '.' . $image->getClientOriginalExtension();
            
            // Hapus foto lama jika ada dan bukan foto default
            if ($user->avatar && Storage::exists('public/img-user/' . $user->avatar)) {
                Storage::delete('public/img-user/' . $user->avatar);
            }

            // Simpan foto baru ke folder storage/app/public/img-user
            $image->storeAs('public/img-user', $filename);
            $user->avatar = $filename;
        }

        // 4. Handle Password (Hanya update jika diisi)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}