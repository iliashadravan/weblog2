<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
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
