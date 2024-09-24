<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();  // سشن فعلی کاربر را نامعتبر می‌کند
        $request->session()->regenerateToken(); //یک توکن جدید برای سشن کاربر تولید می‌شود
        return redirect('/Home/articles/no/login');
    }
}

