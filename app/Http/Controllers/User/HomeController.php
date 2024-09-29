<?php


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function Index(Request $request)
    {
        // دریافت عبارت جستجو از ورودی کاربر
        $search_term = $request->input('query');

        // اگر عبارت جستجو وجود داشته باشد، مقالات مرتبط را پیدا کن
        if ($search_term) {
            $articles = Article::query()
                ->where(function ($query) use ($search_term) {
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

        } else {
            // در غیر این صورت، همه مقالات را نمایش بده
            $articles = Article::all();
        }

        // ارسال داده‌ها به ویو برای نمایش
        return view('show.articles', ['articles' => $articles]);
    }
}
