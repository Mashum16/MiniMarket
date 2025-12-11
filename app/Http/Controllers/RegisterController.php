<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function registerForm()
{
    return view('backend.v_dashboard.register');
}

public function storeRegister   (Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ]);

    // Simpan ke database
    User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    // Redirect ke login dengan pesan sukses
    return redirect()->route('login')->with('success', 'Register berhasil! Silakan login.');
}
}
