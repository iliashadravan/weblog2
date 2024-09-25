<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function Index()
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

}
