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
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #495057;
            font-size: 2rem;
        }
        .table {
            width: 100%;
            margin: auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        thead {
            background-color: #343a40;
            color: #fff;
        }
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        th, td {
            padding: 15px;
            text-align: center;
        }
        td {
            vertical-align: middle;
        }
        .btn-primary {
            margin-right: 5px;
            border-radius: 50px;
        }
        .btn-danger {
            border-radius: 50px;
        }
        form {
            display: inline-block;
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
    <h2>All Articles</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>id</th>
            <th>title</th>
            <th>body</th>
            <th>operation</th>
        </tr>
        </thead>
        <tbody>
        @foreach($articles as $article)
            <tr>
                <td>{{ $article->id }}</td>
                <td>{{ $article->title }}</td>
                <td>{{ $article->body }}</td>
                <td>
                    <!-- دکمه ویرایش -->
                    <a href="{{ route('user.articles.edit', $article->id) }}" class="btn btn-primary">Edit</a>
                    <!-- فرم حذف -->
                    <form action="/user/articles/{{ $article->id }}" method="post" onsubmit="return confirm('Are you sure you want to delete this article?')">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br>
    <div class="center-content">
        <a href="/Home/articles" class="back-link">Back</a>
    </div>
</div>
</body>
</html>
