@php
    use Hekmatinasser\Verta\Verta;
@endphp
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All Articles</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            margin-top: 40px;
        }

        .page-title {
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.5rem;
            color: #343a40;
            text-transform: uppercase;
            font-weight: bold;
        }

        .table {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .article-title {
            font-weight: 700;
            font-size: 1.5rem;
            color: #054977;
            margin-bottom: 15px;
        }

        .article-body {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 20px;
        }


        .article-wrapper {
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }

        .btn-like, .btn-rate {
            padding: 0.6rem 1.2rem;
            font-size: 1rem;
            border-radius: 30px;
            transition: all 0.3s ease;
            margin-right: 10px;
        }

        .btn-like {
            color: #fff;
            background-color: #054977;
            border: none;
        }

        .btn-like:hover {
            background-color: #ff4a4a;
        }

        .btn-outline-success {
            color: #28a745;
            border-color: #28a745;
        }

        .btn-outline-success:hover {
            background-color: #28a745;
            color: white;
        }

        .btn-rate {
            background-color: #6c757d;
            color: #fff;
        }

        .btn-rate:hover {
            background-color: #5a6268;
        }

        .average-rating {
            font-weight: bold;
            color: #495057;
        }

        textarea {
            width: 100%;
            border-radius: 10px;
            border: 1px solid #ced4da;
            padding: 10px;
            margin-bottom: 10px;
            resize: none;
            font-size: 1rem;
        }

        button[type="submit"] {
            background-color: #054977;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #007bff;
        }

        .comment, .reply {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 10px;
            margin-bottom: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .reply {
            margin-left: 40px;
        }

        .form-group {
            margin-top: 20px;
        }

        .btn-secondary {
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 1.1rem;
            background-color: #6c757d;
            border-color: #6c757d;
            margin-left: 10px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .search-bar {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .search-bar input[type="text"] {
            padding: 10px;
            border-radius: 30px;
            border: 1px solid #ced4da;
            width: 300px;
            margin-right: 10px;
        }

        .search-bar button[type="submit"] {
            background-color: #054977;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            cursor: pointer;
        }

        .search-bar button[type="submit"]:hover {
            background-color: #007bff;
        }

        @media (max-width: 768px) {
            .search-bar input[type="text"] {
                width: 200px;
            }
        }
    </style>

    <div class="container">
        <h2 class="page-title">All Articles</h2>
        <div class="search-bar">
            <form action="/user/articles/search" method="GET">
                <input type="text" name="query" placeholder="متن جستجو...">
                <button type="submit">Search</button>
            </form>
        </div>
        <br>
        <table class="table table-striped table-bordered table-hover shadow-lg">
            <tbody>
            @foreach($articles as $article)
                <tr class="article-wrapper"> <!-- کلاس جدید اضافه شد -->
                    <td>
                        <br>
                        <div class="article-title">{{ $article->title }}</div>
                        <div class="article-body">{{ $article->body }}</div>
                        <p><strong>Publish at date:</strong>
                        <div
                            class="article-body">{{Verta::instance($article->created_at)->timezone('Asia/Tehran')  }}</div>
                        </p>
                        <p><strong>Writer:</strong> {{ $article->user ? $article->user->name : 'Anonymous' }}</p>

                        <div class="mt-3">
                            <!-- دکمه لایک -->
                            <form action="{{ route('article.like', $article) }}" method="POST"
                                  style="display:inline;">
                                @csrf
                                <button
                                    class="btn btn-like {{ $article->likes->contains('user_id', auth()->id()) ? 'btn-outline-success' : 'btn-like' }}">
                                    <i class="fas fa-heart"></i>
                                    @if($article->likes->contains('user_id', auth()->id()))
                                        Liked
                                    @else
                                        Like
                                    @endif
                                    ({{ $article->likes->count() }})
                                </button>
                            </form>

                            <!-- امتیاز -->
                            <form action="{{ route('articles.rate', $article) }}" method="POST"
                                  style="display:inline-block;">
                                @csrf
                                <div class="form-group">
                                    <label for="rating">Rate this article:</label>
                                    <select name="rating" id="rating" class="form-control">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <button type="submit" class="btn btn-rate mt-2">Rate</button>
                                </div>
                            </form>
                            <p class="average-rating">Average
                                Rating: {{ $article->averageRating() ?? 'No ratings yet' }}</p>
                        </div>

                        <!-- فرم ارسال کامنت -->
                        <form action="{{ route('comments.store', ['article' => $article->id]) }}" method="POST">
                            @csrf
                            <textarea name="body" placeholder="write your comment..." required></textarea>
                            <button type="submit">send comment</button>
                        </form>

                        <!-- نمایش کامنت‌ها -->
                        @foreach($article->comments as $comment)
                            @if($comment->is_visible)
                                <!-- فقط کامنت‌های قابل مشاهده -->
                                <div class="comment">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <p>{{ $comment->body }}</p>

                                    <!-- فرم ریپلای -->
                                    <form action="{{ route('comments.reply', ['comment' => $comment->id]) }}" method="POST">
                                        @csrf
                                        <textarea name="body" placeholder="write your reply..." required></textarea>
                                        <button type="submit">Reply</button>
                                    </form>

                                    <!-- نمایش ریپلای‌ها -->
                                    @foreach($comment->replies as $reply)
                                        @if($reply->is_visible)
                                            <!-- فقط ریپلای‌های قابل مشاهده -->
                                            <div class="reply">
                                                <strong>{{ $reply->user->name }}</strong>
                                                <p>{{ $reply->body }}</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        @endforeach

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="../user/articles/create" class="btn btn-secondary">create a new article</a>
        <form action="{{ url('logout') }}" method="POST">
            @csrf
            <button type="submit"> Logout</button>
        </form>
    </div>
    </body>
</head>
</html>
