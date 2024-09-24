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
            max-width: 1200px;
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
            margin-bottom: 30px;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            background-color: white;
            transition: all 0.3s ease;
        }

        .article-wrapper:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
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

        .btn-secondary {
            background-color: #343a40;
            border-color: #343a40;
            padding: 10px 20px;
            border-radius: 30px;
        }

        .btn-secondary:hover {
            background-color: #495057;
            border-color: #495057;
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
</head>
<body>

<div class="container">
    <h2 class="page-title">All Articles</h2>

    <!-- Search Bar -->
    <div class="search-bar">
        <form action="/search" method="GET">
            <input type="text" name="query" placeholder="متن جستجو...">
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Articles Table -->
    <table class="table table-striped table-bordered table-hover shadow-lg">
        <tbody>
        @foreach($articles as $article)
            <tr class="article-wrapper">
                <td>
                    <div class="article-title">{{ $article->title }}</div>
                    <div class="article-body">{{ $article->body }}</div>
                    <p><strong>Published at date:</strong>
                    <div class="article-body">{{Verta::instance($article->created_at)->timezone('Asia/Tehran')  }}</div>
                    </p>
                    <p><strong>Writer:</strong> {{ $article->user ? $article->user->name : 'Anonymous' }}</p>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>

    <!-- Login Button -->
    <div class="text-center mt-4">
        <p>If you want to like or add a comment <a href="/new/login" class="btn btn-secondary">Login</a></p>
    </div>
</div>
</body>
</html>
