<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register_blade()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validate_data = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
        ]);

        User::create([
            'name' => $validate_data['name'],
            'email' => $validate_data['email'],
            'password' => Hash::make($validate_data['password']), // رمز عبور هش شده
        ]);

        return redirect('new/login');
    }

    public function login_blade()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validate_data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // پیدا کردن کاربر با ایمیل
        $user = User::where('email', $validate_data['email'])->first();

        if ($user && Hash::check($validate_data['password'], $user->password)) {
            Auth::login($user); // لاگین کردن کاربر
            if ($user->is_admin == 1) {
                return redirect()->route('users.article');
            } else {
                return redirect()->route('show.articles');
            }
        }

        // اعتبارسنجی ناموفق
        return back()->withErrors([
            'email' => 'ایمیل یا رمز عبور اشتباه است.',
        ])->onlyInput('email');
    }
}
