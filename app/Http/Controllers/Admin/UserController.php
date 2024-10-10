<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request, User $user)
    {
        // بررسی مجوز کاربر برای به‌روزرسانی
        $this->authorize('update', $user);

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
            $user->password = bcrypt($request->password);
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
        // بررسی مجوز کاربر برای حذف
        $this->authorize('delete', $user);

        // حذف کاربر
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully!'
        ]);
    }
}
