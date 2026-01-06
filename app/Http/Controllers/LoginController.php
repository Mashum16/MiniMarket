<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Rules\reCaptcha;

class LoginController extends Controller
{
    public function login()
    {
        return view('backend.v_login.login', [
            'judul' => 'login'
        ]);
    }

    public function authenticate(Request $request)
    {
        // VALIDASI AWAL (termasuk captcha)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => [new reCaptcha()] // pastikan captcha dicentang
        ]);

        // PROSES AUTENTIKASI USER
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'LOGIN',
                'description' => 'User melakukan login',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Redirect berdasarkan role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.beranda');
            }

            if (Auth::user()->role === 'staff') {
                return redirect()->route('staff.beranda');
            }

            return redirect('/beranda');
            }

            AuditLog::create([
                'user_id' => null, // karena belum login
                'action' => 'LOGIN_FAILED',
                'description' => 'Percobaan login gagal dengan email: '.$request->email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        
            return back()->withErrors([
                'email' => 'Email atau password salah.'
            ])->withInput();

    }

    public function logout(Request $request)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'LOGOUT',
            'description' => 'User melakukan logout',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
