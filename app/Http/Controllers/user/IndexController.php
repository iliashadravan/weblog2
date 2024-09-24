<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Article;

class IndexController extends Controller
{
    public function showArticle()
    {
        // دریافت همه مقالات از پایگاه داده
        $articles = Article::all();

        // ارسال داده‌ها به ویو برای نمایش
        return view('show.articles', ['articles' => $articles]);
    }
    public function showArticle2()
    {
        // دریافت همه مقالات از پایگاه داده
        $articles = Article::all();

        // ارسال داده‌ها به ویو برای نمایش
        return view('show.articles2', ['articles' => $articles]);
    }
}
