<?php

use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ArticleController as AdminArticlesController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// روت‌های مربوط به مقالات در پنل user
Route::prefix('user')->middleware('checkUserAuthenticated')->group(function () {

    Route::prefix('articles')->controller(ArticleController::class)->group(function () {
        Route::get('/', 'index')->name('user.articles');
        Route::get('/create', 'create')->name('user.articles.create');
        Route::post('/create', 'store')->name('user.articles.store');
        Route::get('/{article}/edit', 'edit')->name('user.articles.edit');
        Route::put('/{article}/edit', 'update')->name('user.articles.update');
        Route::delete('/{article}', 'delete')->name('user.articles.delete');
        Route::post('/{article}/like', 'like')->name('article.like');
        Route::post('/{article}/rate', 'rate')->name('articles.rate');
    });
    Route::post('/{article}/comments', [CommentController::class, 'comment'])->name('comments.store');
    Route::post('/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');
});

// روت‌های مربوط به ثبت‌نام و ورود
Route::prefix('')->controller(AuthController::class)->group(function () {
    Route::get('/register', 'register_blade')->name('register');
    Route::post('/register', 'register')->name('register.store');
    Route::get('/login', 'login_blade')->name('login.form');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout',  'logout')->name('logout');
});

// روت‌های نمایش مقاله‌ها
Route::prefix('Home/user')->controller(HomeController::class)->group(function () {
    Route::get('/index', [HomeController::class, 'Index'])->name('user.articles.index');
});


// روت‌های مربوط به پنل مدیریت
Route::prefix('admin')->middleware('checkUserAuthenticated')->group(function () {
    Route::prefix('articles')->controller(AdminArticlesController::class)->group(function () {
        Route::get('/users/article', 'Index')->name('users.article');
        Route::get('/{article}/edit', 'edit')->name('admin.articles.edit');
        Route::put('/{article}/edit', 'update')->name('admin.articles.update');
        Route::delete('/{article}', 'delete')->name('admin.articles.delete');
        Route::get('/{article}/comments', [AdminCommentController::class, 'showComments'])->name('admin.articles.comments');
        Route::put('/comments/{comment}/visibility', [AdminCommentController::class, 'updateCommentVisibility'])
            ->name('admin.comments.updateVisibility');
    });

    Route::prefix('users')->controller(AdminUserController::class)->group(function () {
        Route::get('/{user}/edit', 'edit')->name('admin.users.edit');
        Route::put('/{user}', 'update')->name('admin.users.update');
        Route::delete('/{user}', 'delete')->name('admin.users.delete');
    });
});
