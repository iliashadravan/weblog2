<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Results</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #343a40;
        }
        .container {
            margin-top: 40px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-10px);
        }
        .card-header {
            background-color: #054270;
            color: #fff;
            font-size: 1.5rem;
            padding: 15px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
        .card-body {
            background-color: #ffffff;
            padding: 25px;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }
        .alert-info {
            margin-top: 30px;
            background-color: #d1ecf1;
            color: #0c5460;
            font-size: 1.1rem;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        h1 {
            font-size: 2.5rem;
            color: #343a40;
            text-align: center;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="mb-4">Search Results</h1>

    @if($articles->isEmpty())
        <div class="alert alert-info" role="alert">
            No results found for your search.
        </div>
    @else
        @foreach($articles as $article)
            <br>
            <div class="card">

                <div class="card-header">
                    {{ $article->title }}
                </div>
                <div class="card-body">
                    <p><strong>Body:</strong> {{ $article->body }}</p>
                    <p><strong>Writer:</strong> {{ $article->user ? $article->user->name : 'Anonymous' }}</p>
                    <p><strong>Likes:</strong> {{ $article->likes->count() }}</p>
                    <p><strong>Rating:</strong> {{ $article->averageRating() ?? 'No ratings yet' }}</p>

                    <p><strong>Categories:</strong>
                        @foreach($article->categories as $category)
                            {{ $category->name }}@if(!$loop->last), @endif
                        @endforeach
                    </p>
                </div>
            </div>
        @endforeach
    @endif
</div>
</body>
</html>
