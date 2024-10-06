<?php

use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ArticleController as AdminArticlesController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    // روت‌های مربوط به مقالات در پنل کاربر
    Route::prefix('user/articles')->controller(ArticleController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/create', 'store');
        Route::put('/{article}/edit', 'update');
        Route::delete('/{article}', 'delete');
        Route::post('/{article}/like', 'like');
        Route::post('/{article}/rate', 'rate');
    });

    Route::post('/user/{article}/comments', [CommentController::class, 'comment']);
    Route::post('/user/{comment}/reply', [CommentController::class, 'reply']);

    // روت‌های مربوط به مقالات پنل مدیریت
    Route::prefix('admin/articles')->controller(AdminArticlesController::class)->group(function () {
        Route::get('/users/article', 'index');
        Route::put('/{article}/edit', 'update');
        Route::delete('/{article}', 'delete');
        Route::get('/{article}/comments',[AdminCommentController::class,'showComments']);
        Route::put('/comments/{comment}/visibility',[AdminCommentController::class,'updateCommentVisibility']);
    });

    Route::prefix('admin/users')->controller(AdminUserController::class)->group(function () {
        Route::put('/{user}', 'update');
        Route::delete('/{user}', 'delete');
    });
});

// روت‌های مربوط به ثبت‌نام و ورود
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
});

// روت‌های نمایش مقاله‌ها
Route::prefix('home/user')->controller(HomeController::class)->group(function () {
    Route::get('/index', [HomeController::class, 'index']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
