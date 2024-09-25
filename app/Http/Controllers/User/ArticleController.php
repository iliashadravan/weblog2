<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ArticleController extends Controller
{
    public function create()
    {
        // بازگشت به صفحه create با ارسال دسته‌بندی‌ها
        return view('user.articles.create', [
            'categories' => Category::all()
        ]);
    }

    public function store()
    {
        $validate_data = $this->validate(request(), [
            'title' => 'required|min:3|max:100',
            'body' => 'required|min:5',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
        ]);

        // ایجاد مقاله جدید
        $article = Article::create([
            'title' => $validate_data['title'],
            'body' => $validate_data['body'],
            'user_id' => auth()->id(),
        ]);

        // پیوست کردن دسته‌بندی‌ها به مقاله
        $article->categories()->attach($validate_data['categories']);

        // هدایت به صفحه مقالات کاربر
        return redirect()->route('user.articles', ['user' => auth()->id()]);
    }

    public function edit(Article $article)
    {
        // بازگشت به صفحه ویرایش با ارسال دسته‌بندی‌ها
        return view('user.articles.edit', [
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

        return redirect()->route('user.articles.create')->with('success', 'Article updated successfully!');
    }

    public function delete(Article $article)
    {
        // حذف مقاله
        $article->delete();

        return back();
    }

    public function Index(User $user)
    {
        // دریافت مقالات کاربر
        $articles = $user->articles;

        return view('user.articles.index', compact('articles'));
    }


    public function like(Article $article)
    {
        $userId = auth()->id();

        // بررسی اینکه آیا کاربر مقاله را لایک کرده یا نه
        if ($article->likes()->where('user_id', $userId)->exists()) {
            $article->likes()->detach($userId);
        } else {
            $article->likes()->attach($userId);
        }

        return back();
    }

    public function rate(Request $request, Article $article)
    {
        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $userId = auth()->id();

        // بررسی اینکه آیا کاربر قبلاً امتیاز داده است یا نه
        $existing_rating = $article->ratings()->where('user_id', $userId)->first();

        if ($existing_rating) {
            // اگر کاربر قبلاً امتیاز داده، آن را به‌روزرسانی کن
            $article->ratings()->updateExistingPivot($userId, [
                'rating' => $validatedData['rating'],
            ]);
        } else {
            // در غیر این صورت، امتیاز جدید را ایجاد کن
            $article->ratings()->attach($userId, [
                'rating' => $validatedData['rating'],
            ]);
        }

        return back();
    }




    public function search(Request $request)
    {
        $search_term = $request->input('query');

        // جستجو بر اساس عنوان، محتوا، نویسنده یا دسته‌بندی
        $articles = Article::query()->where(function ($query) use ($search_term) {
            $query->where('title', 'LIKE', '%' . $search_term . '%')
                ->orWhere('body', 'LIKE', '%' . $search_term . '%')
                ->orWhereHas('user', function ($q) use ($search_term) {
                    $q->where('name', 'LIKE', '%' . $search_term . '%');
                })
                ->orWhereHas('categories', function ($q) use ($search_term) {
                    $q->where('name', 'LIKE', '%' . $search_term . '%');
                });
        })

            ->get();

        return view('user.articles.search_results', compact('articles'));
    }

}
