<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function registerForm()
    {
        return view('backend.v_login.register');
    }

    public function store(Request $request)
    {
        // men validasi input
        $validated = $request->validate([
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|numeric',
            'password' => 'required|min:6|confirmed',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
        ]);

         // Upload avatar
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = date('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $directory = 'storage/img-user/';
            ImageHelper::uploadAndResize($file, $directory, $fileName, 385, 400);
            $validated['avatar'] = $fileName;
        }

        // menyimpan ke database
        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'avatar'   => $fileName,
        ]);

        // kembali ke halaman login dengan pesan sukses cihuyy
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}