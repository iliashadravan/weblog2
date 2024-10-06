<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function update(Request $request, User $user)
    {
        // اعتبارسنجی اطلاعات ورودی
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:3',
        ]);

        // به‌روزرسانی اطلاعات کاربر
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);   // رمز عبور جدید هش شده و در دیتابیس ذخیره می‌شود.
        }
        $user->save();

        // بازگشت اطلاعات به‌روز شده کاربر به صورت JSON
        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!',
            'user' => $user
        ]);
    }

    public function delete(User $user)
    {
        // حذف کاربر
        $user->delete();

        // بازگشت پیام موفقیت‌آمیز به صورت JSON
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully!'
        ]);
    }
}
