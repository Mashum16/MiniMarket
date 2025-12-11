<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Menampilkan halaman profil dengan data user login
    public function index()
    {
        $user = Auth::user();

        return view('backend.v_profile.profile', compact('user'));
    }
}
