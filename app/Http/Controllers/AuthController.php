<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
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
            'password' => Hash::make($validate_data['password']),
        ]);

        // ورود کاربر به سیستم
        Auth::login($user);

        return response()->json([
            'message' => 'ثبت‌نام موفقیت‌آمیز بود.',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $validate_data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);

        // پیدا کردن کاربر با ایمیل
        $user = User::where('email', $validate_data['email'])->first();

        // بررسی اعتبار کاربر
        if (!$user || !Hash::check($validate_data['password'], $user->password)) {
            return response()->json(['message' => 'ایمیل یا رمز عبور اشتباه است.'], 401);
        }

        // ورود کاربر به سیستم
        Auth::login($user); // لاگین کردن کاربر

        return response()->json([
            'message' => 'ورود موفقیت‌آمیز بود.',
            'user' => $user,
            'token' => $user->createToken('YourAppName')->plainTextToken, // ایجاد توکن برای کاربر
        ], 200);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // از بین بردن توکن
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json([
            'message' => 'خروج موفقیت‌آمیز بود.',
        ], 200);
    }
}
