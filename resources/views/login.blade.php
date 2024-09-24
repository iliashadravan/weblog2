<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه ورود</title>
    <!-- لینک به کتابخانه Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #2c3e50;
            color: white;
            border-radius: 4px;
            width: 100%;
        }
        .btn-custom:hover {
            background-color: #34495e;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Login</h2>
    <form action="{{route('login')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="email">email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-custom">Entry</button>
     <p>if you dont have account <a href="/new/register">register</a></p>
    </form>
</div>
</body>
</html>
