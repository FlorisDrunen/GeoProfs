
<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <div class="login-box">
        <h1>Login</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
