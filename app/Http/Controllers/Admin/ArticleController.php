<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('user')->get();

        return response()->json([
            'success' => true,
            'articles' => $articles
        ]);
    }
    public function update(Article $article)
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required|min:3|max:50',
            'body' => 'required',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // به روز رسانی مقاله
        $article->update([
            'title' => $validator->validated()['title'],
            'body' => $validator->validated()['body'],
        ]);

        // همگام‌سازی دسته‌بندی‌ها با مقاله
        $article->categories()->sync($validator->validated()['categories']);

        return response()->json([
            'success' => true,
            'article' => $article,
            'massage' => 'Article updated successfully'
        ]);
    }

    public function delete(Article $article)
    {
        // حذف مقاله
        $article->delete();

        return response()->json([
            'success' => true,
            'message' => 'Article deleted successfully!'
        ]);
    }
}
