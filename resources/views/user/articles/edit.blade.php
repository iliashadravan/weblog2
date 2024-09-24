<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>edit Article</title>
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
    </style>
</head>
<body>

<div class="container">
<h2>Edit Article</h2>
@if($errors->any())
    <div class="alert alert-danger">
        <ul style="color: red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('user.articles.update', $article->id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" name="title" value="{{ $article->title }}" class="form-control" style="border-radius: 2px">
    </div>
    <br>
    <div class="form-group">
        <label for="body">Body:</label>
        <textarea name="body" id="body" cols="30" rows="10" class="form-control" style="border-radius: 5px">{{ $article->body }}</textarea>
    </div>
    <br>
    <div class="form-group">
        <label for="categories">Categories:</label>
        <select name="categories[]" class="form-control" multiple>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <br>
    <button class="btn btn-danger">Update</button>
</form>
</div>
