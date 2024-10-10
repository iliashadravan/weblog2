<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    public function view(User $user, Article $article)
    {
// همه کاربران می‌توانند مقالات را ببینند
        return true;
    }

    public function update(User $user, Article $article)
    {
// فقط کاربری که صاحب مقاله است، می‌تواند آن را ویرایش کند
        return $user->id === $article->user_id;
    }

    public function delete(User $user, Article $article)
    {
// فقط صاحب مقاله می‌تواند آن را حذف کند
        return $user->id === $article->user_id;
    }

    public function create(User $user)
    {
// فقط کاربرانی که احراز هویت شده‌اند می‌توانند مقاله ایجاد کنند
        return $user !== null;
    }
}
