<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
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

        // ایجاد کاربر جدید
        $user = User::create([
            'name' => $validate_data['name'],
            'email' => $validate_data['email'],
            'password' => Hash::make($validate_data['password']), // رمز عبور هش شده
        ]);

        // لاگین کردن کاربر تازه ثبت‌نام شده
        Auth::login($user);

        return redirect('Home/user/index');
    }


    public function login_blade()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validate_data = $request->validate([
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $user = User::where('email', $value)->first();
                    if (!$user || !Hash::check(request()->password, $user->password)) {
                        return $fail('ایمیل یا رمز عبور اشتباه است.');
                    }
                },
            ],
        ]);
        // پیدا کردن کاربر با ایمیل (در اینجا نیازی به بررسی دوباره نیست)
        $user = User::where('email', $validate_data['email'])->first();

        Auth::login($user); // لاگین کردن کاربر
        if ($user->is_admin === true) {
            return redirect()->route('users.article');
        } else {
            return redirect()->route('user.articles.index');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();  // سشن فعلی کاربر را نامعتبر می‌کند
        return redirect('/Home/user/index');
    }
}

