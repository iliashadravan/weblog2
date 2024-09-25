<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Article Comments</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #444;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 900px;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #046494;
            color: #fff;
            font-weight: 700;
            text-transform: uppercase;
        }

        td {
            background-color: #f9f9f9;
            transition: background-color 0.3s ease;
        }

        tr:hover td {
            background-color: #f1f1f1;
        }

        .comment {
            font-weight: bold;
        }

        .reply {
            padding-left: 40px;
            color: #666;
            font-style: italic;
        }

        label {
            font-weight: bold;
            margin-right: 10px;
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        button {
            padding: 10px 25px;
            background-color: #046494;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
            font-size: 1rem;
        }

        button:hover {
            background-color: #0280ba;
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            th, td {
                font-size: 0.9rem;
            }

            h1 {
                font-size: 2rem;
            }

            button {
                font-size: 0.9rem;
                padding: 8px 16px;
            }
        }
        a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1.1rem;
            font-weight: bold;
            text-decoration: none;
            color: white;
            background-color: #046494;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        a:hover {
            background-color: #0280ba;
            transform: translateY(-3px);
        }

        a:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Comments for Article: {{ $article->title }}</h1>

    <table>
        <thead>
        <tr>
            <th>Comment</th>
            <th>Visible</th>
            <th>Operations</th>
        </tr>
        </thead>
        <tbody>
        @foreach($comments as $comment)
            <tr>
                <td class="comment">{{ $comment->body }}</td>
                <td>{{ $comment->is_visible ? 'Visible' : 'Hidden' }}</td>
                <td>
                    <form action="{{ route('admin.comments.updateVisibility', $comment->id) }}" method="post">
                        @csrf
                        @method('put')
                        <label>
                            <input type="checkbox" name="is_visible" {{ $comment->is_visible ? 'checked' : '' }}>
                            Visible
                        </label>
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
            <!-- Replies for each comment -->
            @if($comment->replies->count())
                @foreach($comment->replies as $reply)
                    <tr>
                        <td class="reply">--> {{ $reply->body }}</td>
                        <td>{{ $reply->is_visible ? 'Visible' : 'Hidden' }}</td>
                        <td>
                            <form action="{{ route('admin.comments.updateVisibility', $reply->id) }}" method="post">
                                @csrf
                                @method('put')
                                <label>
                                    <input type="checkbox" name="is_visible" {{ $reply->is_visible ? 'checked' : '' }}>
                                    Visible
                                </label>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
        @endforeach
        </tbody>
    </table>
    <br>
    <a href="../users/article">go back </a>
</div>
</body>
</html>
