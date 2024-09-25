<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Article</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 700px;
            margin-top: 100px;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .form-group label {
            font-weight: bold;
            color: #495057;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            font-size: 1rem;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 1.1rem;
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
        .page-title {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
        }
        .back-link {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            text-align: center;
            width: 100px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-link:hover {
            background-color: #495057;
        }

        .center-content {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="page-title">Create New Article</h2>
    <form action="{{ route('user.articles.store') }}" method="POST">
        @csrf
        <!-- فیلدهای فرم -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required placeholder="Enter article title">
        </div>

        <div class="form-group">
            <label for="body">Body</label>
            <textarea name="body" id="body" class="form-control" required placeholder="Write your article content" rows="5"></textarea>
        </div>

        <div class="form-group">
            <label for="categories">Categories</label>
            <select name="categories[]" id="categories" class="form-control" multiple>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- دکمه‌ها -->
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('user.articles', ['user' => auth()->id()]) }}" class="btn btn-secondary">Show My Articles</a>
        </div>
        <div class="center-content">
            <a href="/Home/articles" class="back-link">Back</a>
        </div>
    </form>
</div>

</body>
</html>
