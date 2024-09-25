<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;

class HomeController extends Controller
{
    public function Index()
    {
        // دریافت همه مقالات از پایگاه داده
        $articles = Article::all();

        // ارسال داده‌ها به ویو برای نمایش
        return view('show.articles', ['articles' => $articles]);
    }
    public function Homepage()
    {
        // دریافت همه مقالات از پایگاه داده
        $articles = Article::all();

        // ارسال داده‌ها به ویو برای نمایش
        return view('show.Homepage', ['articles' => $articles]);
    }
}
