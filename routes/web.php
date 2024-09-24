<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\user\ArticleController;
use App\Http\Controllers\user\CommentController;
use App\Http\Controllers\user\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// روت‌های مربوط به مقالات در پنل user
Route::prefix('user')->middleware('checkUserAuthenticated')->group(function () {
    Route::prefix('articles')->controller(ArticleController::class)->group(function () {
        Route::get('/', 'index')->name('user.articles.index');
        Route::get('/create', 'create')->name('user.articles.create');
        Route::post('/create', 'store')->name('user.articles.store');
        Route::get('/{article}/edit', 'edit')->name('user.articles.edit');
        Route::put('/{article}/edit', 'update')->name('user.articles.update');
        Route::delete('/{article}', 'delete')->name('user.articles.delete');
    });

    Route::get('/{user}/articles', [ArticleController::class, 'userArticles'])->name('user.articles');
});

// روت‌های لایک و امتیاز مقالات
Route::prefix('articles')->group(function () {
    Route::post('/{article}/like', [ArticleController::class, 'like'])->name('article.like');
    Route::post('/{article}/rate', [ArticleController::class, 'rate'])->name('articles.rate');
});

// روت‌های مربوط به ثبت‌نام و ورود
Route::prefix('new')->controller(RegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'store')->name('register.store');
    Route::get('/login', 'login')->name('login.form');
    Route::post('/login', 'index')->name('login');
});

// روت‌های نمایش مقاله‌ها
Route::prefix('Home')->middleware('checkUserAuthenticated')->controller(HomeController::class)->group(function () {
    Route::get('/articles', 'showArticle')->name('show.articles');
});
Route::get('/Home/articles/no/login', [HomeController::class, 'Homepage'])->name('Homepage');

// روت‌های مربوط به کامنت‌ها
Route::prefix('articles')->group(function () {
    Route::post('/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');
});

// روت‌های مربوط به جستجو
Route::get('/search', [ArticleController::class, 'search'])->name('search');

// روت‌های مربوط به پنل مدیریت
Route::prefix('admin')->middleware('checkUserAuthenticated')->controller(AdminController::class)->group(function () {
    Route::get('/users/article', 'showArticles')->name('users.article');
    Route::prefix('articles')->group(function () {
        Route::get('/{article}/edit', 'edit')->name('admin.articles.edit');
        Route::put('/{article}/edit', 'update')->name('admin.articles.update');
        Route::delete('/{article}', 'delete')->name('admin.articles.delete');
        Route::get('/{article}/comments', 'showComments')->name('admin.articles.comments');
    });
    Route::put('/comments/{comment}/visibility', 'updateCommentVisibility')->name('admin.comments.updateVisibility');

    Route::prefix('users')->group(function () {
        Route::get('/{user}/edit', 'edit_user')->name('admin.users.edit');
        Route::put('/{user}', 'update_user')->name('admin.users.update');
        Route::delete('/{user}', 'destroy')->name('admin.users.destroy');
    });
});

// روت خروج از سیستم
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
