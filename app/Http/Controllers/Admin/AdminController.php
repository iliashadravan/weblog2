<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;



class AdminController extends Controller
{
    public function showArticles()
    {
        $articles = Article::with('user')->get();

        return view('admin.articles.users_article', compact('articles'));

    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', [
            'article' => $article,
            'categories' => Category::all(),
            'selectedCategories' => $article->categories->pluck('id')->toArray()
        ]);
    }

    public function update(Article $article)
    {
        $validate_data = Validator::make(request()->all(), [
            'title' => 'required|min:3|max:50',
            'body' => 'required',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
        ])->validated();

        // به روز رسانی مقاله
        $article->update([
            'title' => $validate_data['title'],
            'body' => $validate_data['body'],
        ]);

        // همگام‌سازی دسته‌بندی‌ها با مقاله
        $article->categories()->sync($validate_data['categories']);

        return redirect()->route('users.article')->with('success', 'Article updated successfully!');
    }

    public function delete(Article $article)
    {
        // حذف مقاله
        $article->delete();

        return back();
    }

    public function edit_user(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update_user(Request $request, User $user)
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

        // بازگشت به صفحه مقالات پس از به‌روزرسانی موفقیت‌آمیز
        return redirect()->route('users.article');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.article');
    }


    public function showComments(Article $article)
    {
        // گرفتن تمام کامنت‌های مربوط به یک مقاله
        $comments = Comment::where('commentable_id', $article->id)->with('replies')->get();

        return view('admin.articles.comment', compact('article', 'comments'));
    }

    public function updateCommentVisibility(Request $request, Comment $comment)
    {
        // بروزرسانی وضعیت قابل مشاهده بودن کامنت
        $comment->is_visible = $request->has('is_visible');

        // ذخیره‌سازی تغییرات
        $comment->save();

        // ریدایرکت کردن به صفحه قبلی با پیام موفقیت
        return back()->with('success', 'Comment visibility updated successfully!');
    }

}
