<!DOCTYPE html>
<html>
<head>
    <!-- Link naar het CSS-bestand voor styling -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <title>Login</title>
</head>
<?php
    // $login = App\Http\Controllers\Api\AuthController::login;
?>
<body class="login-body">

    <div class="login-box">
        <h1>Login</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- code voor de inlog form -->
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>