@php
    use Hekmatinasser\Verta\Verta;
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Users Articles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #495057;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #495057;
            color: #fff;
        }

        tbody tr:nth-child(even) {
            background-color: #f4f4f9;
        }

        tbody tr:hover {
            background-color: #e9ecef;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            margin-right: 5px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #4e73df;
            color: #fff;
        }

        .btn-danger {
            background-color: #ff6b6b;
            color: #fff;
        }

        form {
            display: inline;
        }

        button[type="submit"] {
            background-color: #054977;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #228afa;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Users Articles</h1>

    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Body</th>
            <th>Writer</th>
            <th>Publication Date</th>
            <th>Operation</th>
        </tr>
        </thead>
        <tbody>
        @foreach($articles as $article)
            <tr>
                <td>{{ $article->title }}</td>
                <td>{{ Str::limit($article->body, 130) }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $article->user->id) }}">{{ $article->user->name }}</a>
                </td>
                <td>{{ Verta::instance($article->created_at)->timezone('Asia/Tehran') }}</td>
                <td>
                    <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-primary">Edit</a>
                    <form action="/user/articles/{{ $article->id }}" method="post"
                          onsubmit="return confirm('Are you sure you want to delete this article?')">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger">Delete</button>
                    </form>

                    <!-- دکمه نمایش کامنت‌ها -->
                    <a href="{{ route('admin.articles.comments', $article->id) }}" class="btn btn-primary">Show
                        Comments</a>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <br>
    <form action="{{url('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>
</body>
</html>
