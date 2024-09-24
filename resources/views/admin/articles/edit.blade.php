<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Article</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 600px;
        }

        h2 {
            text-align: center;
            color: #495057;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 14px;
            color: #495057;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"], textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, textarea:focus, select:focus {
            border-color: #4e73df;
            outline: none;
        }

        textarea {
            resize: none;
        }

        .alert {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #ffcccc;
            border-radius: 5px;
            border: 1px solid red;
        }

        ul {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }

        ul li {
            font-size: 14px;
        }

        button {
            background-color: #4e73df;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #3b5abd;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Article</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.articles.update', $article->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" value="{{ $article->title }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="body">Body:</label>
            <textarea name="body" id="body" cols="30" rows="10" class="form-control">{{ $article->body }}</textarea>
        </div>

        <div class="form-group">
            <label for="categories">Categories:</label>
            <select name="categories[]" class="form-control" multiple>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-danger">Update</button>
    </form>
</div>
</body>
</html>
